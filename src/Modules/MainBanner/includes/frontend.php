<?php if (!empty($settings->image_src)) : ?>
<figure class="main-banner <?php echo sanitize_html_class($settings->style); ?>" style="background-image: url('<?php echo esc_url($settings->image_src); ?>');">
    <div class="img">
        <?php echo wp_get_attachment_image($settings->image, 'page-banner'); ?>
    </div><!-- end img -->
</figure><!-- end main-banner -->
<?php endif ?>