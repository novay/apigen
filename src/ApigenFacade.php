<?php

namespace Novay\Apigen;

use Illuminate\Support\Facades\Facade;

class ApigenFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'apigen';
    }
}