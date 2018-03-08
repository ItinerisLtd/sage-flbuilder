<?php
/**
 * Generic Bootstrap button widget
 *
 * @package Fabric
 */

?>
<?php if ( ! empty( $settings->link ) && ! empty( $settings->text ) ) : ?>
<a href="<?php echo esc_url( $settings->link ); ?>" class="btn <?php echo \App\sanitize_html_classes( $settings->style ); ?>" target="<?php echo esc_attr( $settings->target ); ?>"><?php echo esc_html( $settings->text ); ?></a>
<?php endif; ?>
