<?php

namespace LaravelReady\PackageStarter\Facades;

use Illuminate\Support\Facades\Facade;

class PackageName extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'package-name';
    }
}
