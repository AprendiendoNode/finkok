<?php

namespace Gmlo\Finkok\Services;

class Register extends FinkokService
{
    protected $service = 'registration';

    /**

     */
    public function add($rfc, $type = 'O')
    {
        $result = $this->send('add', [
            'reseller_username' => $this->user,
            'reseller_password' => $this->password,
            'taxpayer_id' => trim($rfc),
            'type_user' => $type,
        ]);
        return $result->success == true;
    }
}
