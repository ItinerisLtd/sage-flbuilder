@extends('ItinerisSageFLBuilderViews::layouts.archive')

@section('content')
  @php FLBuilder::render_content_by_id($post_id, 'div', apply_filters('fl_theme_builder_content_attrs', [])); @endphp
@endsection
