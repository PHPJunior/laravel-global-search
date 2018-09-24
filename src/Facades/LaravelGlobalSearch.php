<?php
/**
 * Created by PhpStorm.
 * User: Nyi Nyi Lwin
 * Date: 9/21/18
 * Time: 16:47
 */

namespace PhpJunior\LaravelGlobalSearch\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelGlobalSearch extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-global-search';
    }
}