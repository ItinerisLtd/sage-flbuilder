<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings;

interface InitializableInterface
{
    public static function init(): void;
}
