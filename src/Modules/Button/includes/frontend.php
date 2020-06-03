<?php
/**
 * Generic Bootstrap button widget
 *
 * @package Fabric
 */

use Itineris\SageFLBuilder\AbstractHelper;
use function Roots\app as sage;

/** @var AbstractHelper $helper */
$helper = sage(AbstractHelper::class);

?>
<?php if (! empty($settings->link) && ! empty($settings->text)) : ?>
    <a href="<?php echo esc_url($settings->link); ?>"
       class="btn <?php echo $helper->sanitizeHtmlClasses($settings->style); ?>"
       target="<?php echo esc_attr($settings->target); ?>"><?php echo esc_html($settings->text); ?></a>
<?php endif; ?>
