@php
    $id = absint($settings->form_id);
    $ajax = (bool) $settings->enable_ajax;
    $tabIndex = (int) $settings->tab_index;
    $show_title = (bool) $settings->show_title;
@endphp

@if(!empty($settings->form_id))
    {!! !empty($settings->title) && $settings->show_custom_title ? '<h3>'.$settings->title.'</h3>' : '' !!}
    {!! gravity_form($id, $show_title, $description, false, null, $ajax, $tabIndex, false) !!}
@endif
