<?php

declare(strict_types=1);

use Itineris\SageFLBuilder\AbstractHelper;
use function Roots\app;

/** @var AbstractHelper $helper */
$helper = app(AbstractHelper::class);

echo $helper->breadcrumbs();
