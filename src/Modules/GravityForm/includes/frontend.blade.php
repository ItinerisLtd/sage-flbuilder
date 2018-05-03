@php
    $id = absint($settings->form_id);
    $title = (bool) ($settings->show_title ?? true);
    $description = (bool) ($settings->show_descr ?? true);
    $ajax = (bool) ($settings->enable_ajax ?? false);
    $tabIndex = (int) ($settings->tab_index ?? 1);
@endphp

@if(!empty($settings->form_id))
    {!! gravity_form($id, $title, $description, false, null, $ajax, $tabIndex, false) !!}
@endif
