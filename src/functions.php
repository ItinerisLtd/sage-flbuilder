<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder;

use Roots\Sage\Container;

/**
 * Get the helper instance.
 *
 * @internal
 *
 * @return AbstractHelper
 */
function getHelper(): AbstractHelper
{
    $container = Container::getInstance();

    return $container->makeWith(AbstractHelper::class);
}
