<?php

namespace Gmlo\Finkok\Services;

class Stamp extends FinkokService
{
    protected $service = 'stamp';

    public function stamp($xml)
    {
        $result = $this->send('stamp', [
            'xml' => $xml->saveXML(),
            'username' => $this->user,
            'password' => $this->password
        ]);
        $xml = new \DOMDocument('1.0', 'UTF-8');
        $xml->loadXML($result->xml);
        return $xml;
    }

    /*
    public function cancel($rfc, $uuid, $path)
    {
        shell_exec("openssl rsa -in {$path}.key.pem -des3 -out {$path}.enc -passout pass:{$this->password}");

        $result = $this->send('cancel', [
            'taxpayer_id' => $rfc,
            'UUIDS' => ['uuids' => [$uuid]],
            'cer' => $this->getContentFromFile($path . '.cer.pem'),
            'key' => $this->getContentFromFile($path . '.enc'),
        ]);

        return $result ? $result->Fecha : false;
    }

    protected function getContentFromFile($path)
    {
        $file = fopen($path, 'r');
        $content = fread($file, filesize($path));
        fclose($file);
        return $content;
    }*/
}
