@php
    $id = absint($settings->form_id);
    $title = (bool) ($settings->show_title ? true : false);
    $description = (bool) ($settings->show_descr ? true : false);
    $ajax = (bool) ($settings->enable_ajax ? true : false);
    $tabIndex = (int) ($settings->tab_index ? 1 : 0);
@endphp

@if(!empty($settings->form_id))
    {!! gravity_form($id, $title, $description, false, null, $ajax, $tabIndex, false) !!}
@endif
