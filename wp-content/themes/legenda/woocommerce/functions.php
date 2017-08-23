<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'et-font-awesome',get_stylesheet_directory_uri().'/css/font-awesome.css', array( 'fonts' ) );
}


// **********************************************************************// 
// ! Promo Popup
// **********************************************************************// 
add_action('after_page_wrapper', 'et_promo_popup');
if(!function_exists('et_promo_popup')) {
    function et_promo_popup() {
        if(!etheme_get_option('promo_popup')) return;
        $bg = etheme_get_option('pp_bg');
        $padding = etheme_get_option('pp_padding');
        ?>
            <a class="etheme-popup " href="#etheme-popup">Open modal</a>
            
            <div id="etheme-popup" class="white-popup-block mfp-hide">
                <?php echo do_shortcode(etheme_get_option('pp_content')); ?>
                <a class="popup-modal-dismiss" href="#"><i class="icon-remove"></i></a>
                <p class="checkbox-label">
                    <input type="checkbox" value="do-not-show" name="showagain" id="showagain" class="showagain" />
                    <label for="showagain">다시 보지 않기</label>
                </p>
            </div>
            <style type="text/css">
                #etheme-popup {
                    width: <?php echo (etheme_get_option('pp_width') != '') ? etheme_get_option('pp_width') : 770 ; ?>px;
                    height: <?php echo (etheme_get_option('pp_height') != '') ? etheme_get_option('pp_height') : 350 ; ?>px;
                    <?php if(!empty($bg['background-color'])): ?>  background-color: <?php echo $bg['background-color']; ?>;<?php endif; ?>
                    <?php if(!empty($bg['background-image'])): ?>  background-image: url(<?php echo $bg['background-image']; ?>) ; <?php endif; ?>
                    <?php if(!empty($bg['background-attachment'])): ?>  background-attachment: <?php echo $bg['background-attachment']; ?>;<?php endif; ?>
                    <?php if(!empty($bg['background-repeat'])): ?>  background-repeat: <?php echo $bg['background-repeat']; ?>;<?php  endif; ?>
                    <?php if(!empty($bg['background-color'])): ?>  background-color: <?php echo $bg['background-color']; ?>;<?php  endif; ?>
                    <?php if(!empty($bg['background-position'])): ?>  background-position: <?php echo $bg['background-position']; ?>;<?php endif; ?>
                }
            </style>
        <?php
    }
}

// 로그인 사용자는 장바구니 보기 페이지로 이동
// 비로그인 사용자는 로그인 페이지로 이동
// Redirects loginned users to the "View Cart" page and non-loginned users (guests) to the "Login" page when clicking on the "Add to Cart" button in WordPress. After filling in the login information, the users will be redirected to the previous WooCommerce product page again. You can also change the link which will be redirected as you wish.

add_filter ('add_to_cart_redirect', 'redirect_to_checkout');

function redirect_to_checkout() {
if ( is_user_logged_in() ) {
return get_permalink( wc_get_page_id( 'cart' ) );

}
else {
$redirect = home_url() . '/register/?redirect_to=' . urlencode( $_SERVER['REQUEST_URI'] );
return $redirect;
}
}


//한국 원화표시
add_filter( 'woocommerce_currencies', 'add_my_currency' );
 
function add_my_currency( $currencies ) {
     $currencies['KRW'] = __( '대한민국', 'woocommerce' );
     return $currencies;
}

add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);
 
function add_my_currency_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'KRW': $currency_symbol = '원'; break;
     }
     return $currency_symbol;
}

if(!function_exists('etheme_top_links')) {
    function etheme_top_links() {
        ?>
            <ul class="links">
                <?php if ( is_user_logged_in() ) : ?>
                    <?php if(class_exists('Woocommerce')): ?> <li class="my-account-link"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php _e( 'Your Account', ETHEME_DOMAIN ); ?></a>
                    <div class="submenu-dropdown">
                        <?php  if ( has_nav_menu( 'account-menu' ) ) : ?>
                            <?php wp_nav_menu(array(
                                'theme_location' => 'account-menu',
                                'before' => '',
                                'after' => '',
                                'link_before' => '',
                                'link_after' => '',
                                'depth' => 4,
                                'fallback_cb' => false
                            )); ?>
                        <?php else: ?>
                            <h4 class="a-center">Set your account menu in <em>Apperance &gt; Menus</em></h4>
                        <?php endif; ?>
                    </div>
                </li><?php endif; ?>
                        <li class="logout-link"><a href="<?php echo wp_logout_url(home_url()); ?>"><?php _e( 'Logout', ETHEME_DOMAIN ); ?></a></li>
                <?php else : ?>
                    <?php 
                        $reg_id = etheme_tpl2id('et-registration.php'); 
                        $reg_url = get_permalink($reg_id);
                    ?>    
                    
                    <?php if(!empty($reg_id)): ?><li class="register-link"><a href="<?php echo $reg_url; ?>"><?php _e( '로그인 / 회원가입', ETHEME_DOMAIN ); ?></a></li><?php endif; ?>
                <?php endif; ?>
            </ul>
        <?php
    }
}

function enqueue_and_register_my_scripts(){
	if ( is_page( 'estimate' ) ){
	wp_enqueue_script( 'estimate', get_stylesheet_directory_uri() . '/js/estimate.js', array( 'jquery' ) );
	}
}
add_action( 'wp_enqueue_scripts', 'enqueue_and_register_my_scripts' );


add_filter('woocommerce_save_account_details_required_fields', 'woocommerce_save_account_details_required_fields', 10, 1);

function woocommerce_save_account_details_required_fields($fields = array()) {
        unset($fields['account_last_name']);
        return $fields;
}

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields_03' );
 
function custom_override_checkout_fields_03( $fields ) {
     unset($fields['billing']['billing_last_name']); 
     unset($fields['billing']['billing_state']); 
     return $fields;
}


// 상품 추가 화면 필드 표시 액션
add_action( 'woocommerce_product_options_general_product_data', 'woo_add_custom_general_fields' );
 
function woo_add_custom_general_fields() {
 
  global $woocommerce, $post;
  
  echo '<div class="options_group">';
// 텍스트 필드
woocommerce_wp_text_input( 
  array( 
    'id'          => 'shipping_cost', 
    'label'       => __( '배송비', 'woocommerce' ), 
    'placeholder' => '금액 입력',
    'desc_tip'    => 'true',
    'description' => __( '이곳에 배송비를 입력하세요', 'woocommerce' ) 
  )
);   
// 국가 선택상자
woocommerce_wp_select( 
array( 
  'id'      => 'product_origin', 
  'label'   => __( '원산지', 'woocommerce' ), 
  'options' => array(
    '한국'   => __( '한국', 'woocommerce' ),
    '중국'   => __( '중국', 'woocommerce' ),
    '일본'   => __( '일본', 'woocommerce' )
    )
  )
);
  // 이 줄 위에 코드를 입력하세요....
  echo '</div>';
}

// 필드 저장 액션
add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );

function woo_add_custom_general_fields_save( $post_id ){
// 텍스트 필드
$woocommerce_text_field = $_POST['shipping_cost'];
if( !empty( $woocommerce_text_field ) )
  update_post_meta( $post_id, 'shipping_cost', esc_attr( $woocommerce_text_field ) );  
// 국가 선택상자
$woocommerce_select = $_POST['product_origin'];
if( !empty( $woocommerce_select ) )
  update_post_meta( $post_id, 'product_origin', esc_attr( $woocommerce_select ) );
    
  // 이 줄 위에 코드를 입력하세요....
}