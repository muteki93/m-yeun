<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

$class = '';

if(etheme_get_option('ajax_addtocart') && $product->is_purchasable() && $product->is_in_stock() > 0 && $product->get_type() == 'simple') {
	$class .= 'etheme_add_to_cart_button ajax_add_to_cart ';
}
		
echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="add_to_cart_button button %s product_type_%s">%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( $product->get_id() ),
		esc_attr( $product->get_sku() ),
		$class,
		esc_attr( $product->get_type() ),
		esc_html( $product->add_to_cart_text() )
	),
$product );