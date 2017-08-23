<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
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

global $post, $woocommerce, $product;

$zoom = etheme_get_option('zoom_effect');

$lightbox_rel = 'lightboxGall';
$lightbox_enabled = etheme_get_option('gallery_lightbox');

$has_video = false;

$video_attachments = array();
$videos = et_get_attach_video($product->get_id() ); 
//$videos = explode(',', $videos[0]);
if(isset($videos[0]) && $videos[0] != '') {
	$video_attachments = get_posts( array(
		'post_type' => 'attachment',
		'include' => $videos[0]
	) ); 
}


if(count($video_attachments)>0 || et_get_external_video($product->get_id() ) != '') {
	$has_video = true;
}



?>
<div class="images woocommerce-product-gallery <?php echo ($zoom == 'disable') ? 'zoom-disabled' : '';  ?>">
	<a href="#" class='zoom hide'>Bug Fix</a>
	<?php
		etheme_wc_product_labels();
				
		if ( has_post_thumbnail() || $has_video ) {

			$image = get_the_post_thumbnail_url( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
			$attachment_ids 	= $product->get_gallery_image_ids();
			$image_title 		= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
			$attachment_count   = count( $product->get_gallery_image_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}
			
			?>
			
				<div class="main-image-slider <?php if ($zoom != 'disable') {echo 'zoom-enabled';} ?>">
					
					<ul class="woocommerce-product-gallery__wrapper slides">
						<?php if ( has_post_thumbnail()): ?>
						
						<?php

							$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
							$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
							$image_title       = get_post_field( 'post_excerpt', $post_thumbnail_id );
							
							$attributes = array(
								'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
								'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
								'data-src'                => $full_size_image[0],
								'data-large_image'        => $full_size_image[0],
								'data-large_image_width'  => $full_size_image[1],
								'data-large_image_height' => $full_size_image[2],
							);

						 ?>

						<li class="woocommerce-product-gallery__image">
							<?php if ($lightbox_enabled && $zoom != 'disable'): ?>
								<a href="<?php echo $image_link; ?>" itemprop="image" class="zoom-link woocommerce-main-image " rel="<?php echo $lightbox_rel; ?>">
									<i class="icon-resize-full"></i>
								</a>
							<?php endif ?>
							<?php if($zoom != 'disable' || $lightbox_enabled): ?><a href="<?php echo $image_link; ?>" class="main-image " <?php if($zoom == 'disable' && $lightbox_enabled): ?>rel="<?php echo $lightbox_rel; ?>"<?php endif; ?> id="main-zoom-image"><?php endif; ?>
									<?php echo get_the_post_thumbnail( $post->ID, 'shop_single', $attributes ); ?>
							<?php if($zoom != 'disable' || $lightbox_enabled): ?></a><?php endif; ?>
						</li>
							<?php if ($attachment_ids): ?>
								<?php foreach ($attachment_ids as $key => $value): ?>
									<li>
										<?php
											$img = wp_get_attachment_image_url( $value, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
											$lightbox_img = wp_get_attachment_image_url( $value, 'full' );
										?>

										<?php if ($lightbox_enabled && $zoom != 'disable'): ?>
											<a href="<?php echo $lightbox_img; ?>" class="zoom-link " rel="<?php echo $lightbox_rel; ?>"><i class="icon-resize-full"></i></a>
										<?php endif ?>

										<?php if($zoom != 'disable' || $lightbox_enabled): ?>
											<a href="<?php echo $lightbox_img; ?>" <?php if($zoom == 'disable' && $lightbox_enabled): ?>rel="<?php echo $lightbox_rel; ?>"<?php endif; ?> class="main-image ">
										<?php endif ?>
											<?php echo wp_get_attachment_image( $value, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), false, $attributes ); ?>
											<?php //echo get_the_post_thumbnail( $value, 'shop_single', $attributes ); ?>

										<?php if($zoom != 'disable' || $lightbox_enabled): ?></a><?php endif ?>
									</li>
								<?php endforeach ?>						
							<?php endif ?>
						<?php endif; ?>
						
						
						<?php if(et_get_external_video( $product->get_id() )): ?>
							<li>
								<?php echo et_get_external_video( $product->get_id() ); ?>
							</li>
						<?php endif; ?>
						
			
						<?php if(count($video_attachments)>0): ?>
								<li>
									<video controls="controls">
										<?php foreach($video_attachments as $video):  ?>
											<?php $video_ogg = $video_mp4 = $video_webm = false; ?>
											<?php if($video->post_mime_type == 'video/mp4' && !$video_mp4): $video_mp4 = true; ?>
												<source src="<?php echo $video->guid; ?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
											<?php endif; ?>
											<?php if($video->post_mime_type == 'video/webm' && !$video_webm): $video_webm = true; ?>
												<source src="<?php echo $video->guid; ?>" type='video/webm; codecs="vp8, vorbis"'>
											<?php endif; ?>
											<?php if($video->post_mime_type == 'video/ogg' && !$video_ogg): $video_ogg = true; ?>
												<source src="<?php echo $video->guid; ?>" type='video/ogg; codecs="theora, vorbis"'>
												<?php _e('Video is not supporting by your browser', ETHEME_DOMAIN); ?>
												<a href="<?php echo $video->guid; ?>"><?php _e('Download Video', ETHEME_DOMAIN); ?></a>
											<?php endif; ?>
										<?php endforeach; ?>
									</video>
								</li>
						<?php endif; ?>
						
						<?php if ( !has_post_thumbnail()): ?>
							<?php if ($attachment_ids): ?>
								<?php foreach ($attachment_ids as $key => $value): ?>
									<li>
										<?php $value = wp_get_attachment_image_url( $value, 'full' ); ?>
										<?php if ($lightbox_enabled && $zoom != 'disable'): ?>
											<a href="<?php echo $value; ?>" class="zoom-link zoom" rel="<?php echo $lightbox_rel; ?>"><i class="icon-resize-full"></i></a>
										<?php endif ?>
										<a href="<?php echo $value; ?>" <?php if($zoom == 'disable'): ?>rel="<?php echo $lightbox_rel; ?>"<?php endif; ?> class="main-image zoom"><img src="<?php echo $value; ?>" title="<?php $image_title ?>"></a></li>
								<?php endforeach ?>						
							<?php endif ?>
						<?php endif; ?>
						

					</ul>

				</div>
				<?php if((has_post_thumbnail() && ( $has_video || $attachment_ids)) || ( $has_video && $attachment_ids)): ?>
				<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery('.main-image-slider').flexslider({
							animation: "slide",
							slideshow: false,
							animationLoop: false,
							controlNav: false,
							smoothHeight: true,
							<?php if ($zoom != 'disable') {
								?>
									touch: false,
								<?php
							} ?>
							sync:".product-thumbnails-slider"
						});
					});
					

				</script>
				<?php endif; ?>

				<?php if ($zoom != 'disable') {
					?>	
						<script type="text/javascript">

							if(jQuery(window).width() > 768){
								jQuery(document).ready(function(){
									jQuery('.main-image-slider .main-image').swinxyzoom({mode:'<?php echo $zoom ?>', controls: false, size: '100%', dock: { position: 'right' } }); // dock window slippy lens
								});
							} else {
								jQuery('.main-image-slider a').click(function(e){
									e.preventDefault();
								});
							}
					
						</script>
					<?php
				} ?>

				<?php do_action( 'woocommerce_product_thumbnails' ); ?>
				
			<?php

		} else {

			echo wc_placeholder_img( apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );

		}
	?>

	

</div>