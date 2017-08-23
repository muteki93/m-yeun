<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . esc_html( _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) ) . ' ', '</span>' ); ?>
	
	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>