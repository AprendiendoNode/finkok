<?php

namespace Gmlo\Finkok\Services;

use Gmlo\Finkok\Exceptions\FinkokException;

class Cancel extends FinkokService
{
    protected $service = 'cancel';

    public function cancel($uuids, $transmitter_rfc, $cer_file, $key_file, $store_pending = false)
    {
        if (!is_array($uuids)) {
            $uuids = [$uuids];
        }
        $cer = file_get_contents($cer_file);
        $key = file_get_contents($key_file);

        $result = $this->send('cancel', [
            'UUIDS' => ['uuids' => $uuids],
            'taxpayer_id' => $transmitter_rfc,
            'cer' => $cer,
            'key' => $key,
            'store_pending' => $store_pending,
            'username' => $this->user,
            'password' => $this->password
        ]);

        $data = (object)[
            'accuse' => isset($result->Acuse) ? $result->Acuse : null,
            'datetime' => $result->Fecha,
            'transmitter_rfc' => $result->RfcEmisor,
            'folios' => [
            ],
        ];
        foreach ($result->Folios as $folio) {
            $data->folios[] = (object)[
                'uuid' => $folio->UUID,
                'status' => $folio->EstatusUUID,
                'cancellation_status' => $folio->EstatusCancelacion,
            ];
        }

        return $data;
    }

    public function getSatStatus($transmitter_rfc, $receiver_rfc, $uuid, $total)
    {
        $data = [
            'uuid' => $uuid,
            'taxpayer_id' => $transmitter_rfc,
            'rtaxpayer_id' => $receiver_rfc,
            'total' => $total,
            'username' => $this->user,
            'password' => $this->password
        ];
        $result = $this->send('get_sat_status', $data);

        if (!isset($result->sat) or !starts_with($result->sat->CodigoEstatus, 'S -')) {
            info($data);
            throw new FinkokException('No se localizo el CFDI, revisar la información enviada', 0, null, ['errors' => $result->sat->CodigoEstatus]);
        }

        $cancelable_types = [
            'Cancelable sin aceptación' => 'without_acceptance',
            'Cancelable con aceptación' => 'with_acceptance',
            'No cancelable' => false,
        ];

        $cancellation_status = [
            'En proceso' => [
                'label' => 'processing',
                'canceled' => false,
            ],
            'Cancelado con aceptación' => [
                'label' => 'canceled_with_acceptance',
                'canceled' => true,
            ],
            'Plazo vencido' => [
                'label' => 'expired_deadline',
                'canceled' => true,
            ],
            'Cancelado sin aceptación' => [
                'label' => 'canceled_without_acceptance',
                'canceled' => true,
            ],
        ];

        $cfdi_status = [
            'Vigente' => 'active',
            'Cancelado' => 'canceled'
        ];

        $data = (object)[
            'cancelable' => $cancelable_types[$result->sat->EsCancelable],
            'cfdi_status' => isset($cfdi_status[$result->sat->Estado]) ? $cfdi_status[$result->sat->Estado] : $result->sat->Estado,
            'cancellation_status' => $cancellation_status[$result->sat->EstatusCancelacion]['label'],
            'canceled' => $cancellation_status[$result->sat->EstatusCancelacion]['canceled'],
            'cancellation_status_m' => $result->sat->EstatusCancelacion,
            'original_result' => $result
        ];

        return $data;
    }

    /*public function stamp($xml)
    {
        $result = $this->send('stamp', [
            'xml' => $xml->saveXML(),
            'username' => $this->user,
            'password' => $this->password
        ]);
        $xml = new \DOMDocument('1.0', 'UTF-8');
        $xml->loadXML($result->xml);
        return $xml;
    }*/
}
