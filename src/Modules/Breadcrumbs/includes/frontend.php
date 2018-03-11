<?php

declare(strict_types=1);

use Itineris\SageFLBuilder\AbstractHelper;
use function App\sage;

/** @var AbstractHelper $helper */
$helper = sage(AbstractHelper::class);

echo $helper->breadcrumbs();
