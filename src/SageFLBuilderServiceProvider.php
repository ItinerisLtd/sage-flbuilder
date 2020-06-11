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
    public function boot()
    {
        $this->loadViewsFrom(base_path('Plugins/FLBuilder/Modules'), 'ItinerisSageFLBuilder');
    }
}