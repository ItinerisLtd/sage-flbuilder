@if(!empty($settings->photo_gallery) && is_numeric($settings->photo_gallery))
    <div class="gallery-section">
        @if($settings->show_title)
            <h2>{{ get_the_title($settings->photo_gallery) }}</h2>
        @endif
        @if($settings->show_summary)
            {!! wpautop(get_the_excerpt($settings->photo_gallery)) !!}
        @endif
        <div class="images-carousel row row-flex">
            <?php foreach ($module->images() as $item ) : ?>
            <div class="slide">
                <a href="{{ $item['image']['url'] }}" title="{!! $item['caption'] !!} ">
                    {!! wp_get_attachment_image($item['image']['id'], 'gallery-thumb', false, ['data-mfp-src' => $item['image']['url']]) !!}
                </a>
            </div><!-- end slide -->
            <?php endforeach; ?>
        </div><!-- end images-carousel -->
    </div>
@endif
