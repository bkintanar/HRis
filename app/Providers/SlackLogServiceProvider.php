<?php

namespace HRis\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Monolog\Handler\SlackHandler;
use Monolog\Logger;
use Monolog\Processor\WebProcessor;

class SlackLogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $monolog = Log::getMonolog();
        $monolog->pushProcessor(new WebProcessor());

        $slackHandler = new SlackHandler('xoxp-7580385233-7623067718-18558369985-89c011fd72', '#hris', 'HRBot');
        $slackHandler->setLevel(Logger::DEBUG);

        $monolog->pushHandler($slackHandler);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
