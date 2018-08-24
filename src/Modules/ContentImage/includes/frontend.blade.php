@if(!empty($settings->image))
    <div class="img-big">
        {!! wp_get_attachment_image($settings->image, 'post-image') !!}
    </div>
@endif
