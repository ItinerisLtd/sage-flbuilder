<!doctype html>
<html @php language_attributes(); @endphp>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @php wp_head(); @endphp
  </head>

  <body @php body_class(); @endphp>
    @php
      wp_body_open();
      do_action('get_header');
    @endphp

    <div id="app">
      @include('layouts.app')
    </div>

    @php
      do_action('get_footer');
      wp_footer();
    @endphp
  </body>
</html>
