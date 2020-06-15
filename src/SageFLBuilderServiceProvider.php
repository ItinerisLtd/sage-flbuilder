<?php

namespace Itineris\SageFLBuilder;

use Roots\Acorn\ServiceProvider;

use function Roots\base_path;

class SageFLBuilderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadViewsFrom(
            base_path('app/Plugins/FLBuilder/Modules/'),
            'ItinerisSageFLBuilder'
        );

        $this->loadViewsFrom(
            __DIR__ . '/Views/',
            'ItinerisSageFLBuilderViews'
        );
    }
}
