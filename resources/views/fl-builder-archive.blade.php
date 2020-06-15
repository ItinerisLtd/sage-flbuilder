@extends("ItinerisSageFLBuilderViews::layouts.archive")

@section('content')
    @php
    $ids = FLThemeBuilderLayoutData::get_current_page_content_ids();
    if ( 'fl-theme-layout' == get_post_type() && count( $ids ) > 1 ) {
        $post_id = FLBuilderModel::get_post_id();
    } else {
        $post_id = $ids[0];
    }
    FLBuilder::render_content_by_id($post_id, 'div', apply_filters('fl_theme_builder_content_attrs', []));
    @endphp
@endsection
