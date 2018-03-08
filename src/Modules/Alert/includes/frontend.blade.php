@if(!empty($settings->text))
    <div class="alert {{ $settings->style }}" role="alert">
        {!! wpautop($settings->text) !!}
    </div>
@endif