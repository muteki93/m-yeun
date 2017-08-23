<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) :

$sidebar_slider = false;

if( etheme_get_option( 'upsell_location' ) == 'sidebar' ) {
	etheme_create_flex_slider( $upsells, esc_html__( 'Our offers', ETHEME_DOMAIN ), false, true );
} else {
	$slider_args = array(
		'title' => esc_html__( 'Our offers', ETHEME_DOMAIN) 
	);
	etheme_create_slider( $args, $slider_args );
}

endif;
wp_reset_postdata();
