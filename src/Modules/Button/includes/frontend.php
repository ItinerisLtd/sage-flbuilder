<?php
/**
 * Generic Bootstrap button widget
 *
 * @package Fabric
 */

use Itineris\SageFLBuilder\AbstractHelper;
use function Roots\app;

/** @var AbstractHelper $helper */
$helper = app(AbstractHelper::class);

?>
<?php if (! empty($settings->link) && ! empty($settings->text)) : ?>
    <a href="<?php echo esc_url($settings->link); ?>"
       class="btn <?php echo esc_html($settings->style); ?>"
       target="<?php echo esc_attr($settings->target); ?>"><?php echo esc_html($settings->text); ?></a>
<?php endif; ?>
