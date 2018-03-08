<?php
$product = wc_get_product();
if ( ! $product ) {
    return;
}
$title = get_the_title();
?>

<li class="products">
    <a href="<?php the_permalink(); ?>">
        <?php echo woocommerce_get_product_thumbnail(); ?>
        <h4 class="woocommerce-loop-product__title"><?php echo $title; ?></h4>
        <span class="price">
            <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span>3.95</span></ins>
		</span>
    </a>
    <?php echo apply_filters( 'woocommerce_loop_add_to_cart_link',
        sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $quantity ) ? $quantity : 1 ),
            esc_attr( $product->get_id() ),
            esc_attr( $product->get_sku() ),
            esc_attr( isset( $class ) ? $class : 'button product_type_simple add_to_cart_button ajax_add_to_cart' ),
            esc_html( $product->add_to_cart_text() )
        ),
        $product ); ?>
</li>
