<?php $ac = 0; $the_id = get_the_id(); $collapse = filter_var($settings->collapsed, FILTER_VALIDATE_BOOLEAN); ?>
<div class="accordion content" id="accordion-<?php echo $the_id; ?>-<?php echo $id; ?>" role="tablist" aria-multiselectable="true">
<?php for ( $i = 0; $i < count( $settings->items ); $i++ ) : if ( empty( $settings->items[ $i ] ) ) continue; $isf = ($collapse !== true && $i===0) ? true : false ; ?>
  <div class="panel">
    <h4 class="panel-title">
      <a role="button" data-toggle="collapse" data-parent="#accordion-<?php echo $the_id; ?>-<?php echo $id; ?>" href="#accordion-<?php echo $the_id; ?>-<?php echo $id; ?>-<?php echo $i; ?>" aria-expanded="<?php echo $isf ? 'true' : 'false'; ?>" aria-controls="accordion-<?php echo $the_id; ?>-<?php echo $id; ?>-<?php echo $i; ?>"<?php echo !$isf ? ' class="collapsed"' : '' ?>>
        <?php echo $settings->items[ $i ]->label; ?>
      </a>
    </h4>
    <div <?php if ( ! empty( $the_id ) ) echo ' id="accordion-' . $the_id . '-' . $id . '-' . $i . '"'; ?> class="panel-collapse collapse<?php echo $isf ? ' in' : ''; ?>" role="tabpanel" aria-labelledby="accordion-<?php echo $the_id; ?>-<?php echo $id; ?>-<?php echo $i; ?>">
      <div class="panel-body">
        <?php echo $settings->items[ $i ]->content; ?>
      </div>
    </div>
  </div>
  <?php endfor; ?>
</div>
