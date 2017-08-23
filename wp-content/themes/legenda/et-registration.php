<?php
/**
 * Template Name: Custom Registration Page
 */
extract(etheme_get_page_sidebar());
//Check whether the user is already logged in
if (!is_user_logged_in() || !$user_ID) {
        extract(etheme_get_page_sidebar());
        get_header();
        $captcha_instance = new ReallySimpleCaptcha();
		$captcha_instance->bg = array( 244, 80, 80 );
		$word = $captcha_instance->generate_random_word();
		$prefix = mt_rand();
		$img_name = $captcha_instance->generate_image( $prefix, $word );
		$captcha_img = ETHEME_CODE_URL.'/inc/really-simple-captcha/tmp/'.$img_name;
    	
        ?>

            <?php et_page_heading() ?>
            
            <div class="container et-registration">
                <div class="page-content sidebar-position-<?php echo $position; ?> responsive-sidebar-<?php echo $responsive; ?>">
                    <div class="row-fluid">
                        <?php if($position == 'left' || ($responsive == 'top' && $position == 'right')): ?>
                            <div class="<?php echo $sidebar_span; ?> sidebar sidebar-left">
                                <?php etheme_get_sidebar($sidebarname); ?>
                            </div>
                        <?php endif; ?>

                        <div class="content <?php echo $content_span; ?>">
                               <?php
                                if(get_option('users_can_register')) {
                                    ?>
                                    <div class="row-fluid">
                                        <div class="span6">
                                        <?php wc_print_notices(); ?>
                                            <h2><?php _e( 'Login', 'woocommerce' ); ?></h2>

                                            <form method="post" class="login">

                                                <?php do_action( 'woocommerce_login_form_start' ); ?>

                                                <p class="form-row form-row-wide">
                                                    <label for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                                                    <input type="text" class="input-text" name="username" id="username" />
                                                </p>
                                                <p class="form-row form-row-wide">
                                                    <label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                                                    <input class="input-text" type="password" name="password" id="password" />
                                                </p>

                                                <?php do_action( 'woocommerce_login_form' ); ?>

                                                <p class="form-row">
                                                    <?php wp_nonce_field( 'woocommerce-login' ); ?>
                                                    <input type="submit" class="button" name="login" value="<?php _e( 'Login', 'woocommerce' ); ?>" /> 
                                                    <label for="rememberme" class="inline">
                                                        <input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
                                                    </label>
                                                </p>
                                                <p class="lost_password">
                                                    <a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
                                                </p>

                                                <?php do_action( 'woocommerce_login_form_end' ); ?>

                                            </form>
                                        </div>
                                        <div class="span6">
                                            <div class="content-box">
                                                <h3 class="title"><span><?php _e('Create Account', ETHEME_DOMAIN); ?></span></h3>
                                                <div id="result"></div> 

                                                <form id="wp_signup_form" action="" method="post" class="register">
                                                    <div class="login-fields">
                                                        <p class="form-row form-row">
                                                            <label class=""><?php _e( "Enter your username", ETHEME_DOMAIN ) ?> <span class="required">*</span></label>
                                                            <input type="text" name="username" class="text input-text" value="" />
                                                        </p>
                                                        <p class="form-row form-row">
                                                            <label class=""><?php _e( "Enter your E-mail address", ETHEME_DOMAIN ) ?> <span class="required">*</span></label>
                                                            <input type="text" name="email" class="text input-text" value="" />
                                                        </p>
                                                        <p class="form-row form-row">
                                                            <label class=""><?php _e( "Enter your password", ETHEME_DOMAIN ) ?> <span class="required">*</span></label>
                                                            <input type="password" name="et_pass" class="text input-text" value="" />
                                                        </p>
                                                        <p class="form-row form-row">
                                                            <label class=""><?php _e( "Re-enter your password", ETHEME_DOMAIN ) ?> <span class="required">*</span></label>
                                                            <input type="password" name="et_pass2" class="text input-text" value="" />
                                                        </p>
                                                    </div>
													<?php wc_get_template( 'checkout/terms.php' ); ?>
													<div class="captcha-block">
														<img src="<?php echo $captcha_img; ?>">
														<input type="text" name="captcha_word" class="captcha-input">
														<input type="hidden" name="captcha_prefix" value="<?php echo $prefix; ?>">
													</div>
                                                    <p class="form-row right">
                                                        <input type="hidden" name="et_register" value="1">
                                                        <button class="button submitbtn fl-l active" type="submit"><span><?php _e( "Register", ETHEME_DOMAIN ) ?></span></button>
                                                        <div class="clear"></div>
                                                    </p>
                                                </form>
                                                <script type="text/javascript">
                                                    jQuery(".submitbtn").click(function() {
                                                        jQuery('#result').html('<img src="<?php echo get_template_directory_uri(); ?>/images/loading.gif" class="loader" />').fadeIn();
                                                        var input_data = jQuery('#wp_signup_form').serialize();
                                                        jQuery.ajax({
                                                            type: "POST",
                                                            dataType: "JSON",
                                                            url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                                                            data: {
                                                                'action':'et_register_action',
                                                                'input_data':input_data,
                                                            },
                                                            success: function(response){
                                                                jQuery('.loader').remove();
                                                                if(response.status == 'error') {
                                                                	var msgHtml = '<span class="error">' + response.msg + '</span>';
	                                                                jQuery('<div>').html(msgHtml).appendTo('div#result').hide().fadeIn('slow');
	                                                                
                                                                } else {
                                                                	var msgHtml = '<span class="success">' + response.msg + '</span>';
	                                                                jQuery('<div>').html(msgHtml).appendTo('div#result').hide().fadeIn('slow');
	                                                                jQuery('#wp_signup_form').find("input[type=text], input[type=password], textarea").val("");
                                                                }
                                                            }
                                                        });
                                                        return false;
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <?php 
												if (have_posts()) :
												   while (have_posts()) :
												      the_post();
												      the_content();
												   endwhile;
												endif;
											 ?>
                                        </div>

                                    </div>

                                    <?php
                                }
                                else _e( '<span class="error">Registration is currently disabled. Please try again later.<span>', ETHEME_DOMAIN );
                                ?>
                        </div>
                        <?php if($position == 'right' || ($responsive == 'bottom' && $position == 'left')): ?>
                            <div class="<?php echo $sidebar_span; ?> sidebar sidebar-right">
                                <?php etheme_get_sidebar($sidebarname); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        <?php
        get_footer();
}
else {
    echo "<script type='text/javascript'>window.location='". home_url( "/" ) ."'</script>";
}
?>