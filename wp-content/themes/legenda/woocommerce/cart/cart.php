
<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>


<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post" class="cart-items woocommerce-cart-form">

	<?php do_action( 'woocommerce_before_cart_table' ); ?>
	<div class="row-fluid">
		<div class="span8 cart-table-section">
			<table class="shop_table table cart shop_table_responsive woocommerce-cart-form__contents" cellspacing="0">
				<thead>
					<tr>
						<th class="product-thumbnail hidden-phone a-center">&nbsp;</th>
						<th class="product-name"><?php esc_html_e( 'Product', ETHEME_DOMAIN ); ?></th>
						<th class="product-price a-center"><?php esc_html_e( 'Price', ETHEME_DOMAIN ); ?></th>
						<th class="product-quantity a-center"><?php esc_html_e( 'Quantity', ETHEME_DOMAIN ); ?></th>
						<th class="product-subtotal a-center"><?php esc_html_e( 'Total', ETHEME_DOMAIN ); ?></th>
						<th class="product-remove">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php do_action( 'woocommerce_before_cart_contents' ); ?>

					<?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
							?>

							<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">


								<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
			                        <div class="product-thumbnail">
			                            <?php
			                                    $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

			                                    if ( ! $_product->is_visible() )
			                                            echo $thumbnail;
			                                    else
			                                            printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
			                            ?>
			                        </div>
								</td>
								<td class="product-details">
			                        <div class="cart-item-details">
			                            <?php
			                                    if ( ! $_product->is_visible() )
			                                            echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
			                                    else
			                                            echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink(), $_product->get_name() ), $cart_item, $cart_item_key );

			                                    // Meta data
			                                    echo WC()->cart->get_item_data( $cart_item );

			                    // Backorder notification
			                    if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
			                            echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
			                            ?>
			                            <span class="mobile-price">
			                            	<?php
												echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
											?>
			                            </span>
			                        </div>
								</td>

								<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
									<?php
										echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
									?>
								</td>

								<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
									<?php
										if ( $_product->is_sold_individually() ) {
											$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
										} else {
											$product_quantity = woocommerce_quantity_input( array(
												'input_name'  => "cart[{$cart_item_key}][qty]",
												'input_value' => $cart_item['quantity'],
												'max_value'   => $_product->get_max_purchase_quantity(),
												'min_value'   => '0'
											), $_product, false );
										}

										echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
									?>
								</td>

								<td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
									<?php
										echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
									?>
								</td>
								<td class="product-remove">
									<?php
										echo apply_filters( 'woocommerce_cart_item_remove_link', 
											sprintf( 
												'<a href="%s" class="btn remove-item remove" aria-label="%s" data-product_id="%s" data-product_sku="%s" title="%s">X</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
											__( 'Remove this item', ETHEME_DOMAIN ),esc_attr( $product_id ),esc_attr( $_product->get_sku() ),__( 'Remove this item', ETHEME_DOMAIN ) ), $cart_item_key );

									?>
								</td>
							</tr>
							<?php
						}
					}

					do_action( 'woocommerce_cart_contents' );
					?>
					<tr>
						<td colspan="6" class="actions">
							<input type="submit" class="button" name="update_cart" value="<?php esc_html_e( 'Update Cart', ETHEME_DOMAIN ); ?>" /> 
							
						</td>
					</tr>

					
				</tbody>
			</table>
			<?php do_action( 'woocommerce_after_cart_table' ); ?>
				<div class="row-fluid cart-options-row">
					<div class="span5">
						<?php if ( wc_coupons_enabled() ) { ?>
								<div class="coupon">
			
									<?php wp_nonce_field( 'woocommerce-coupon' ); ?>
									<label for="coupon_code"><?php esc_html_e( 'Coupon', ETHEME_DOMAIN ); ?>:</label> <input name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_html_e( 'Coupon code', ETHEME_DOMAIN ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', ETHEME_DOMAIN ); ?>" />
			
									<?php do_action('woocommerce_cart_coupon'); ?>
							
								</div>
						<?php } ?>	
						<?php do_action( 'woocommerce_cart_actions' ); ?>
						<?php wp_nonce_field( 'woocommerce-cart' ); ?>
						<?php do_action( 'woocommerce_after_cart_contents' ); ?>
					</div>
					<div class="span7">
						<?php woocommerce_shipping_calculator(); ?>
					</div>
				</div>
		</div><!-- END .span8 cart-table-section -->

		<div class="span4 cart-totals-section">
			<div class="cart-totals-block">
				
			<?php
				/**
				 * woocommerce_cart_collaterals hook.
				 *
				 * @hooked woocommerce_cross_sell_display
				 * @hooked woocommerce_cart_totals - 10
				 */
			 	do_action( 'woocommerce_cart_collaterals' );
			?>

				<div class="clear"></div>
			</div>
			<?php dynamic_sidebar('cart-sidebar'); ?>
		</div><!-- END .pan4 cart-totals-section -->
	</div><!-- END .row-fluid -->

</form>


<?php woocommerce_cross_sell_display(); ?>

<?php do_action( 'woocommerce_after_cart' ); ?>