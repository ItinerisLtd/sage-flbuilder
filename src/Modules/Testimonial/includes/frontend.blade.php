@if(!empty($settings->text))
    <blockquote class="testimonial-box">
        <q>{{ $settings->text }}</q>
        @if(!empty($settings->cite_1) || !empty($settings->cite_2))
            <cite>{!! !empty($settings->cite_1) ? "<b>$settings->cite_1</b>" : '' !!}{{ !empty($settings->cite_1) && !empty($settings->cite_2) ? ',  ' : '' }}{{ $settings->cite_2 }}</cite>
        @endif
    </blockquote><!-- / testimonial-box -->
@endif