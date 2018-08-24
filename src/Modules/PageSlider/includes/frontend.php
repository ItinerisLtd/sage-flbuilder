<?php if (! empty($settings->slides)) : ?>
    <div class="main-slideshow">
        <?php foreach ($settings->slides as $slide) : ?>
            <?php
            if (! $slide->enabled) {
                continue;
            }
            ?>
            <div class="slide">
                <figure class="main-banner">
                    <?php $module->renderBackground($slide); // Background Image ?>
                    <?php $module->renderContent($slide); // Content ?>
                </figure><!-- end main-banner -->
            </div><!-- end slide -->
        <?php endforeach; ?>
    </div><!-- end main-slideshow -->
<?php endif; ?>
