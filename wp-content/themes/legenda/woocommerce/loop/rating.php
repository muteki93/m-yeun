<?php
/**
 * Loop Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' )
	return;
?>

<?php if ( $rating_html = wc_get_rating_html( $product->get_average_rating() ) ) : ?>
	<div class="woocommerce-product-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
		<span class="rating-label"><?php esc_html_e( 'Rating:', ETHEME_DOMAIN ); ?></span>
		<?php echo $rating_html; ?>
	</div>
<?php endif; ?>