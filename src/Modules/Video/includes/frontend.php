<?php
$video      = $settings->source == 'module' ? $settings->module : $settings->custom;
$video_url  = $settings->source == 'module' ? \App\fabric_gf('video_url', $video) : $video;
$thumbnail  = $settings->thumbnail;
?>
<div class="video-box" style="background-image: url(<?php
echo (!empty($thumbnail)) ?
    wp_get_attachment_image_url($thumbnail, 'content-image') :
    \App\video_thumb($video_url, false, 0, get_the_title());
?>);">
    <a href="<?php
    echo \App\video_embed(
        $video_url,
        true
    );
    ?>" class="btn-play type2 magnific-popup"><?php
        _e('play', 'fabric');
    ?></a>
</div>
