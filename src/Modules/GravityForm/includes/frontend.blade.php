@php
    $id = absint($settings->form_id);
    $ajax = isset($settings->enable_ajax) ? (bool) $settings->enable_ajax : false;
    $tabIndex = isset($settings->tab_index) ? absint($settings->tab_index) : 10;
    $show_title = (bool) $settings->show_title;
    $show_description = (bool) $settings->show_descr;
@endphp

@if(!empty($settings->form_id))
    @if($settings->show_custom_title && ! empty($settings->title))
        <h3>{{ $settings->title }}</h3>
    @endif

    {!! gravity_form($id, $show_title, $show_description, false, null, $ajax, $tabIndex, false) !!}
@endif
