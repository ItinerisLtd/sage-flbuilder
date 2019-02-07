@unless(empty($settings->text))
    <blockquote class="testimonial-box">
        <q>{{ $settings->text }}</q>
        @unless(empty($module->getCite()))
            <cite>{{ $module->getCite() }}</cite>
        @endunless
    </blockquote><!-- / testimonial-box -->
@endunless