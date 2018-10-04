<?php

namespace Gmlo\Finkok\Services;

use Gmlo\Finkok\Exceptions\FinkokException;

class FinkokService
{
    protected $url = 'https://facturacion.finkok.com/servicios/soap/';
    protected $user;
    protected $password;
    protected $service;

    public function __construct()
    {
        $this->user = config('finkok.user');
        $this->password = config('finkok.password');
        if (config('app.env') != 'production') {
            $this->url = 'https://demo-facturacion.finkok.com/servicios/soap/';
        }
    }

    protected function send($method, $data)
    {
        $client = new \SoapClient($this->url . $this->service . '.wsdl');
        /*$params = [
            'username' => $this->user,
            'password' => $this->password
        ] + $data;*/
        $params = $data;
        $response = $client->__soapCall($method, [$params]);

        $response = $response->{$method . 'Result'};
        if (isset($response->Incidencias) and isset($response->Incidencias->Incidencia)) {
            $error = $response->Incidencias->Incidencia;
            $message = 'Ocurrio un error: ' . $error->CodigoError . ' - ' . $error->MensajeIncidencia;
            if (config('app.env') == 'local') {
                $message .= '  ' . json_encode($error);
            }
            throw new FinkokException($message, 0, null, ['errors' => $response->Incidencias->Incidencia]);
            return false;
        }
        return $response;
    }
}
