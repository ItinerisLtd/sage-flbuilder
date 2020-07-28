<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder;

use Illuminate\Support\Facades\View;
use Itineris\SageFLBuilder\View\Composers\FLBuilder;
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
            'Sage'
        );

        $this->loadViewsFrom(
            __DIR__ . '/../resources/views/',
            'ItinerisSageFLBuilder'
        );

        View::composer(FLBuilder::views(), FLBuilder::class);
    }
}
