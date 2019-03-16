<?php

namespace Gmlo\Finkok;

use Gmlo\Finkok\Services\Register;
use Gmlo\Finkok\Services\Stamp;
use Gmlo\Finkok\Services\Cancel;

class Finkok
{
    public function __construct()
    {
    }

    public function registerClient($rfc, $type = 'O')
    {
        $service = new Register();
        return $service->add($rfc, $type);
    }

    public function stamp(\DOMDocument $xml)
    {
        $service = new Stamp();
        return $service->stamp($xml);
    }

    public function cancel($uuids, $transmitter_rfc, $cer_file, $key_file, $store_pending = true)
    {
        $service = new Cancel();
        return $service->cancel($uuids, $transmitter_rfc, $cer_file, $key_file, $store_pending);
    }

    public function getSatStatus($transmitter_rfc, $receiver_rfc, $uuid, $total)
    {
        $service = new Cancel();
        return $service->getSatStatus($transmitter_rfc, $receiver_rfc, $uuid, $total);
    }
}
