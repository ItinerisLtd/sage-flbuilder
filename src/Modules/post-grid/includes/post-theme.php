<?php
/**
 * Generic frontend theme template file for Post Grid widget
 *
 * @package Fabric
 */

$post_type          = get_post_type_object($settings->post_type);
$the_id             = get_the_id();
$the_excerpt        = (!empty($summary)) ? $summary : get_the_excerpt();
$the_date_format    = 'default' === $settings->date_format ? get_option('date_format') : $settings->date_format;
?><div id="post-<?php echo esc_attr($the_id); ?>" <?php post_class('col-md-3 col-sm-6'); ?> itemscope itemtype="<?php FLPostGridModule::schema_itemtype(); ?>" role="contentinfo" aria-label="article">

    <a href="<?php the_permalink(); ?>" class="news-box">

        <?php FLPostGridModule::schema_meta(); ?>

        <figure>

            <div class="img">
                <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail();
                } else {
                    echo wp_get_attachment_image(get_theme_mod('fabric_placeholder_image'), 'post-thumbnail');
                }
                ?>
            </div>

            <figcaption>

                <?php if ($settings->show_date) : ?>
                    <span class="date"><?php echo FLBuilderLoop::post_date($settings->date_format); ?></span>
                <?php endif; ?>

                <?php the_title('<h3 class="entry-title" itemprop="headline">', '</h3>'); ?>

            </figcaption>

        </figure>

    </a>

</div>
