<?php

declare(strict_types=1);

use Itineris\SageFLBuilder\AbstractHelper;
use function Roots\app as sage;

/** @var AbstractHelper $helper */
$helper = sage(AbstractHelper::class);

echo $helper->breadcrumbs();
