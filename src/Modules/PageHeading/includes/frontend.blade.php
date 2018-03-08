@php($tag = $settings->tag)
<section class="intro-section">
  <{!! $tag !!}>{{ $settings->title }}</{!! $tag !!}>
  {!! wpautop($settings->text) !!}
</section><!-- end intro-section -->
