<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder;


interface RegistrableModuleInterface
{
    /**
     * Register the module and its form settings.
     * If needed, register a settings form to use in the "form" field type.
     */
    public static function register(): void;
}
