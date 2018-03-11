<?php

use Itineris\SageFLBuilder\AbstractHelper;
use function App\sage;

/** @var AbstractHelper $helper */
$helper = sage(AbstractHelper::class);

$video = $settings->source == 'module' ? $settings->module : $settings->custom;
$video_url = $settings->source == 'module' ? $helper->fabricGf('video_url', $video) : $video;
$thumbnail = $settings->thumbnail;
?>
<div class="video-box" style="background-image: url(<?php
echo (! empty($thumbnail)) ?
    wp_get_attachment_image_url($thumbnail, 'content-image') :
    $helper->videoThumb($video_url, false, 0, get_the_title());
?>);">
    <a href="<?php
    echo $helper->videoEmbed(
        $video_url,
        true
    );
    ?>" class="btn-play type2 magnific-popup"><?php
        _e('play', 'fabric');
        ?></a>
</div>
