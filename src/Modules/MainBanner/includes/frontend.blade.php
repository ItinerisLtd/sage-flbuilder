@if(!empty($settings->slides))
	<div class="visual">
		<div class="visual-slider">
			@php($module->renderButtons())
		</div>
	</div><!-- / visual -->
@endif