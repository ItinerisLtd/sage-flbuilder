<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder;

use FLBuilderModule;

abstract class AbstractModule extends FLBuilderModule
{
    /**
     * Register the module and its form settings.
     * If needed, register a settings form to use in the "form" field type.
     */
    abstract public static function register(): void;
}
