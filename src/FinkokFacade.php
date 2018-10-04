<?php

namespace Gmlo\Finkok;

use Illuminate\Support\Facades\Facade;

class FinkokFacade extends Facade
{
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'finkok';
    }
}
