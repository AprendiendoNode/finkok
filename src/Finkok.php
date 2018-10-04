<?php

namespace Gmlo\Finkok;

use Gmlo\Finkok\Services\Register;
use Gmlo\Finkok\Services\Stamp;

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
}
