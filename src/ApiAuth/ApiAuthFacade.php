<?php namespace Rlogical\ApiAuth;

/**
 * This file is a part of Api Auth,
 * api authentication management solution for Laravel.
 *
 * @license MIT
 * @package Rlogical\ApiAuth
 */

use Illuminate\Support\Facades\Facade;

class ApiAuthFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'api-auth';
    }
}
