@if(!empty($settings->form_id))
    {{ gravity_form(absint($settings->form_id), $settings->show_title, $settings->show_descr, false, null, $settings->enable_ajax, $settings->tab_index, false) }}
@endif
