<?php

namespace HRis\Facades;

use Illuminate\Support\Facades\Facade;

class Sidebar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sidebar';
    }
}
