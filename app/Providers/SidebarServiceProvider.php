<?php

namespace HRis\Providers;

use Illuminate\Support\ServiceProvider;

class SidebarServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('sidebar', 'HRis\Menu\HRisSidebar');
    }
}
