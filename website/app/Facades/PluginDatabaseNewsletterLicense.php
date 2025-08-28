<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PluginDatabaseNewsletterLicense extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'plugin-database-newsletter-license';
    }
}
