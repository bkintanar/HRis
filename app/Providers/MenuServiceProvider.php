<?php

namespace HRis\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider 
{
	public function register()
	{
		$this->app->bind('menu', 'HRis\Menu\HRisMenu');
	}
}