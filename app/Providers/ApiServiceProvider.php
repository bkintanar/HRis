<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Providers;

use Dingo\Api\Provider\LaravelServiceProvider;
use HRis\Exceptions\Handler as ExceptionHandler;

class ApiServiceProvider extends LaravelServiceProvider
{
    /**
     * Register the exception handler.
     *
     * @return void
     */
    protected function registerExceptionHandler()
    {
        $this->app->singleton('api.exception', function ($app) {
            $config = $app['config']['api'];

            return new ExceptionHandler($app['log'], $config['errorFormat'], $config['debug']);
        });
    }
}
