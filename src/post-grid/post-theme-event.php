<?php
/**
 * Generic frontend theme template file for Post Grid widget
 *
 * @package Fabric
 */

$the_id = get_the_id();
$the_excerpt = (! empty($summary)) ? $summary : get_the_excerpt();
$the_date_format = 'default' === $settings->date_format ? get_option('date_format') : $settings->date_format;
$img = has_post_thumbnail() ? get_the_post_thumbnail(null,
    'post-thumb') : wp_get_attachment_image(get_theme_mod('fabric_placeholder_image'), 'post-thumb');
?>
<div id="post-<?php echo esc_attr($the_id); ?>" <?php post_class('col-xs-6 col-md-3 fl-post-theme-post'); ?> itemscope
     itemtype="<?php FLPostGridModule::schema_itemtype(); ?>" role="contentinfo" aria-label="article">
    <a href="<?php the_permalink(); ?>" class="widget-link">
        <?php FLPostGridModule::schema_meta(); ?>
        <figure class="event-box">
            <?php if (! empty($img)) : ?>
                <div class="img">
                    <?php echo $img; ?>
                </div>
            <?php endif; ?>
            <figcaption>
                <?php the_title('<h3>', '</h3>'); ?>
                <?php if ($settings->show_date) : ?>
                    <p><?php Itineris\SageFLBuilder\EventDate::echo($settings->date_format); ?></p>
                    <?php if (get_field('location')['location']) : ?>
                        <?php echo wpautop(get_field('location')['location']); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </figcaption>
        </figure>
    </a>
</div>
