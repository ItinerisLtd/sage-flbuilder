<?php

declare(strict_types=1);

use Itineris\SageFLBuilder\AbstractHelper;
use function Roots\app;

/** @var AbstractHelper $helper */
$helper = app(AbstractHelper::class);

?>

<div id="secondary" class="hidden-sm hidden-xs widget-area" role="complementary">

    <aside class="sidebar">

        <?php $helper->getSecondaryNav(); ?>

    </aside>

</div> <!-- #secondary -->
