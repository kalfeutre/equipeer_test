<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
	
	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/favicon-16x16.png">
	
	<link rel="mask-icon" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="theme-color" content="#51b6bc">
	
	<?php wp_head(); ?>
    
    <?php
        global $post;
        $_rs_locale    = get_bloginfo('language');
        $_rs_post_id   = $post->ID;
        $_rs_link      = get_permalink();
        $_rs_post_type = $post->post_type;
        // image
        $photo_1_id  = @get_post_meta( $_rs_post_id, 'photo_1', true );
        $video_1_url = @get_post_meta( $_rs_post_id, 'video_main', true );
        if (($photo_1_id || $video_1_url) && $_rs_post_type == 'equine') {
            // Equine
            $_rs_date   = get_the_modified_date($format = 'c', $_rs_post_id);
            $_rs_video  = ($video_1_url != '') ? $video_1_url : false; // https://www.youtube.com/watch?v=dyG4BvTcaD8
            $_rs_image  = wp_get_attachment_url($photo_1_id);
            $_rs_img_w  = 600;
            $_rs_img_h  = 411;
            $_rs_title  = __('Horse sale', EQUIPEER_ID) . ' : ' . do_shortcode('[equine-single-title]') . ' | EQUIPEER';
            $_rs_desc   = equipeer_get_post_meta($_rs_post_id, 'impression', '--'); 
            ?>
            <meta property="og:title" content="<?php echo $_rs_title; ?>" />
            <meta property="og:locale" content="<?php echo str_replace("-", "_", $_rs_locale); ?>" />
            <meta property="og:description" content="<?php echo $_rs_desc; ?>" />
            <meta property="og:type" content="<?php if ($_rs_video) echo 'video'; else echo 'article'; ?>" />
            <meta property="article:modified_time" content="<?php echo $_rs_date; ?>" />
            <meta property="og:site_name" content="Equipeer" />
            <?php if ($_rs_video) { ?>
            
            <meta property="og:url" content="<?php echo $video_1_url; ?>" />
            <!--<meta property="og:url" content="https://www.youtube.com/watch?v=UK-XrKAjvnQ" />-->
            <meta property='og:video' content="<?php echo $video_1_url; ?>" />
            <meta property="og:video:type" content="application/x-shockwave-flash"> <!-- you need this because your player is a SWF player -->
            <meta property="og:video:width" content="730"> <!-- player width -->
            <meta property="og:video:height" content="500"> <!-- player height -->
            <meta property="og:video:secure_url" content="<?php echo $video_1_url; ?>"> <!-- required for users whom use SSL (actually Facebook forces everyone to use SSL so you're required to use og:video:secure_url) so get a one -->

            
            <meta property="og:image" content="<?php echo $_rs_image; ?>" />
            <?php } else { ?>
            <meta property="og:image" content="<?php echo $_rs_image; ?>" />
            <meta property="og:image:width" content="<?php echo $_rs_img_w; ?>" />
            <meta property="og:image:height" content="<?php echo $_rs_img_h; ?>" />
            <?php } ?>
            <?php
        } else {
            $_rs_date   = date('c'); // 2004-02-12T15:19:21+00:00
            $_rs_video  = false;
            $_rs_image  = "https://equipeer.com/medias/2019/12/logo-equipeer-sport-1.png";
            $_rs_img_w  = 600;
            $_rs_img_h  = 128;
            $_rs_title   = get_the_title();
        }
    
    ?>
	
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo get_option( 'equine_google_place_api_key' ); ?>&libraries=places" async defer></script>
    
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/vendor/rgpd/tarteaucitron.js"></script>

	<script type="text/javascript">
		tarteaucitron.init({
		  "privacyUrl": "<?php echo get_site_url(); ?>/politique-de-confidentialite", /* Privacy policy url */
	
		  "hashtag": "#equipeercook", /* Open the panel with this hashtag */
		  "cookieName": "equipeercook", /* Cookie name */
	
		  "orientation": "bottom", /* Banner position (top - middle - bottom) */
		  "showAlertSmall": false, /* Show the small banner on bottom right */
		  "cookieslist": true, /* Show the cookie list */
	
		  "adblocker": false, /* Show a Warning if an adblocker is detected */
		  "AcceptAllCta" : true, /* Show the accept all button when highPrivacy on */
		  "highPrivacy": true, /* Disable auto consent */
		  "handleBrowserDNTRequest": false, /* If Do Not Track == 1, disallow all */
	
		  "removeCredit": true, /* Remove credit link */
		  "moreInfoLink": true, /* Show more info link */
		  "useExternalCss": false, /* If false, the tarteaucitron.css file will be loaded */
	
		  //"cookieDomain": ".my-multisite-domaine.fr", /* Shared cookie for multisite */
						  
		  "readmoreLink": "<?php echo get_site_url(); ?>/politique-de-confidentialite" /* Change the default readmore link */
		});
	</script>
	<script type="text/javascript">
		// Multiple GTAG (Google Analytics)
		//tarteaucitron.user.multiplegtagUa = ['UA-83935600-2', 'UA-850265119'];
		//(tarteaucitron.job = tarteaucitron.job || []).push('multiplegtag');
		//tarteaucitron.user.gtagUa = 'UA-83935600-2';
		tarteaucitron.user.gtagUa = 'UA-850265119';
        tarteaucitron.user.gtagMore = function () { /* add here your optionnal gtag() */ };
        (tarteaucitron.job = tarteaucitron.job || []).push('gtag');
		// Google Tag Manager
		//tarteaucitron.user.googletagmanagerId = 'GTM-XXXX';
        //(tarteaucitron.job = tarteaucitron.job || []).push('googletagmanager');
		// Google Adsense
		(tarteaucitron.job = tarteaucitron.job || []).push('adsense');
		// Google Font
		tarteaucitron.user.googleFonts = 'Roboto';
        (tarteaucitron.job = tarteaucitron.job || []).push('googlefonts');
		// Facebook PIXEL
        tarteaucitron.user.facebookpixelId = '482367365547015'; tarteaucitron.user.facebookpixelMore = function () { /* add here your optionnal facebook pixel function */ };
        (tarteaucitron.job = tarteaucitron.job || []).push('facebookpixel');
		// ReCaptcha
		(tarteaucitron.job = tarteaucitron.job || []).push('recaptcha');
		// AddThis
		tarteaucitron.user.addthisPubId = 'YOUR-PUB-ID';
        (tarteaucitron.job = tarteaucitron.job || []).push('addthis');
		// Youtube / Vimeo
		(tarteaucitron.job = tarteaucitron.job || []).push('youtube');
		(tarteaucitron.job = tarteaucitron.job || []).push('vimeo');
	</script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-83935600-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());      
        gtag('config', 'UA-83935600-2');
        var eq575  = (window.screen.width < 576) ? 'mobile' : 'notmobile';
        var eqlang = "<?php if (ICL_LANGUAGE_CODE == 'fr') echo 'fr'; else echo 'en'; ?>";
    </script>

</head>

<body <?php body_class(); ?> onload="eq_initialize()">

    <div class="eq-overlay-ajax d-none"><div class="eq-overlay-ajax-text"><?php echo __('In progress...', EQUIPEER_ID) . '<br><img src="' . get_stylesheet_directory_uri() . '/assets/images/equipeer-wait-ajax.gif" alt="">'; ?></div></div>

    <?php
    // =====================================================================================
    // ============================== S P L A S H S C R E E N ==============================
    // =====================================================================================
    $is_splash = (function_exists("eqpubGetSplashscreen")) ? eqpubGetSplashscreen() : false;
    if ( $is_splash && array_keys( $is_splash, true )) { ?>
        <style>
        .splash {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 2147483647!important;
            width: 100%;
            background: #000;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .splash .splash-header, .splash .splash-footer {
            margin-top: 10px;
            margin-bottom: 10px;
            text-align: center;
            color: #fff;
        }
        .splash .splash-content {
            /*width: 70%;*/
            text-align: center;
        }
        </style>
        <section id="equipeer-splashscreen">
            <div class="splash">
                <div id="splash-wrap">
                    <div class="splash-header">
                        <a href="javascript:closeSplashscreen()" class="">
                            <?php echo __("Continue to Equipeer SPORT", EQUIPEER_ID); ?>
                        </a>
                    </div>
                    <center>
                        <div class="splash-content">
                            <a href="<?php echo $is_splash['link']; ?>" target="_blank">
                                <?php echo $is_splash['desktop']; ?>
                                <?php echo $is_splash['mobile']; ?>
                            </a>
                        </div>
                    </center>
                    <div class="splash-footer">
                        <a href="javascript:closeSplashscreen()" class="">
                            <?php _e("Continue to Equipeer SPORT", EQUIPEER_ID) ?>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <script>
            jQuery(document).ready(function() {
                // Breakpoint max-width: 575px
                var window_height = window.screen.height;
                var window_width  = window.screen.width;
                jQuery('#equipeer-splashscreen').slideUp(500).delay(<?php echo intval($is_splash['delay']*1000); ?>).fadeIn(400);
            });
            function closeSplashscreen() {
                jQuery('#equipeer-splashscreen').fadeOut(500);
            }
        </script>
    <?php }
    
    // -------------------------------------------------------------------------------------
    // ------------------------ U S E R   N O T   C O N N E C T E D ------------------------
    // -------------------------------------------------------------------------------------
    global $wp_query;
    // .page-id-X
    $pages_excludes = array(
         7 // Reset password
        ,6 // Login
        ,8 // Register
        ,2005 // Deposer une annonce (non connecte)
    );
    // Current page ID
    $current_page_id = $wp_query->post->ID;
    // Show Splash user not connected if there is no splash PUB and pages excluded
    if ( !is_user_logged_in() && !$is_splash && !in_array( $current_page_id, $pages_excludes ) ) {
        $is_splash_user = (function_exists("equipeer_splash_user")) ? equipeer_splash_user() : false;
        if ( $is_splash_user && array_keys( $is_splash_user, true ) ) {
            $_delay    = ($is_splash_user['delay'] < 1 || !$is_splash_user['delay']) ? 1000 : $is_splash_user['delay']*1000;
            $_title    = ($is_splash_user['title'] == '') ? __( "You're not logged in?", EQUIPEER_ID ) : trim($is_splash_user['title']);
            $_text     = ($is_splash_user['text'] == '') ? __( 'More Features', EQUIPEER_ID ) : trim($is_splash_user['text']);
            ?>
            <script>
                jQuery(document).ready(function() {
                    // use setTimeout() to execute
                    setTimeout(is_splash_user, <?php echo $_delay; ?>);
                    // Function: Is Splash User
                    function is_splash_user() {
                        var _swal_title        = "<?php echo $_title; ?>";
                        var _swal_text         = "<?php echo $_text; ?>";
                        var _swal_cancel       = "<?php _e( 'Close', EQUIPEER_ID ); ?>";
                        var _swal_connect      = "<?php _e( 'Sign in', EQUIPEER_ID ); ?>";
                        var _swal_connect_url  = "<?php echo get_site_url() . '/login/'; ?>";
                        var _swal_register     = "<?php _e( 'Sign up', EQUIPEER_ID ); ?>";
                        var _swal_register_url = "<?php echo get_site_url() . '/register/'; ?>";
                        Swal.fire({
                            title: _swal_title,
                            html: _swal_text + '<br><div class="swal2-div"><button type="button" role="button" tabindex="0" class="swal2-styled swal2-link" onclick="documentLocation(\'login\')">' + _swal_connect + '</button>' + '<button type="button" role="button" tabindex="0" class="swal2-styled swal2-link equipeer-link" onclick="documentLocation(\'register\')">' + _swal_register + '</button></div>',
                            icon: "info",
                            showCloseButton: true,
                            showCancelButton: false,
                            showConfirmButton: false,
                        });
                    }
                });
            </script>
        <?php } ?>
    <?php } ?>

    <div id="page" class="site">
        
        <div class="eq-overlay eq-no-overlay"></div>
        <div class="eq-overlay-menu eq-no-overlay"></div>
        
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wp-bootstrap-starter' ); ?></a>
        
        <?php if (!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' ) && !is_page_template( 'blank-page-login-register.php' )): ?>
        <header class="top-line">
            
            <!-- Social networks -->
            <?php if ( get_theme_mod( 'facebook_link' ) ) { ?><a target="_blank" class="social-network" title="<?php _e( 'Follow us on', 'wp-bootstrap-starter' ); ?> Facebook" href="<?php echo trim(get_theme_mod( 'facebook_link' )); ?>"><i class="fab fa-facebook-square"></i></a><?php } ?>
            <?php if ( get_theme_mod( 'twitter_link' ) ) { ?><a target="_blank" class="social-network" title="<?php _e( 'Follow us on', 'wp-bootstrap-starter' ); ?> Twitter" href="<?php echo trim(get_theme_mod( 'twitter_link' )); ?>"><i class="fab fa-twitter"></i></a><?php } ?>
            <?php if ( get_theme_mod( 'instagram_link' ) ) { ?><a target="_blank" class="social-network" title="<?php _e( 'Follow us on', 'wp-bootstrap-starter' ); ?> Instagram" href="<?php echo trim(get_theme_mod( 'instagram_link' )); ?>"><i class="fab fa-instagram"></i></a><?php } ?>
            <?php if ( get_theme_mod( 'linkedin_link' ) ) { ?><a target="_blank" class="social-network" title="<?php _e( 'Follow us on', 'wp-bootstrap-starter' ); ?> Linkedin" href="<?php echo trim(get_theme_mod( 'linkedin_link' )); ?>"><i class="fab fa-linkedin"></i></a><?php } ?>
            
            <?php if ( get_theme_mod( 'phone_link' ) && get_theme_mod( 'phone_text' ) ) { ?><div class="phone">Tel : <a href="tel:<?php echo trim(get_theme_mod( 'phone_link' )); ?>"><?php echo trim(get_theme_mod( 'phone_text' )); ?></a></div><?php } ?>
            
            <!--<div class="mobile-menu-btn"><i class="fa fa-bars"></i> Меню</div>-->
            <!--<nav class="main-menu top-menu">
                <ul>
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>-->
            
        </header>
        
        <?php get_template_part( 'template-parts/menu-masthead', 'sticky' ); ?>
        
        <header id="masthead-print">
            <img src="https://equipeer.com/medias/2019/12/logo-equipeer-sport-email-600.png" alt="Equipeer">
        </header>
        
        <header id="masthead" class="site-header navbar-static-top <?php echo wp_bootstrap_starter_bg_class(); ?>" role="banner">
        
            <div class="container">
                
                <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
                
                    <?php get_template_part( 'template-parts/menu-masthead', 'navbar-brand' ); ?>
                    <?php get_template_part( 'template-parts/menu-masthead', 'navbar-collapse' ); ?>
                    
                </nav>
                
            </div>
            
        </header><!-- #masthead -->
        
        <?php if (is_front_page() && !get_theme_mod( 'header_banner_visibility' )): ?>
        
            <div id="page-sub-header-mobile" <?php if (has_header_image()) { ?>style="background-image: url('<?php header_image(); ?>');" <?php } ?>></div>
        
            <div id="page-sub-header" <?php if (has_header_image()) { ?>style="background-image: url('<?php header_image(); ?>');" <?php } ?>>
        
                <div class="container">
        
                    <h2>
                        <?php
                            if (get_theme_mod( 'header_banner_title_setting' )) {
                                echo get_theme_mod( 'header_banner_title_setting' );
                            } else {
                                echo 'EQUIPEER';
                            }
                        ?>
                    </h2>
                    
                    <?php
                        if (get_theme_mod( 'header_banner_tagline_setting' )) {
                            echo '<p>' . get_theme_mod( 'header_banner_tagline_setting' ) . '</p>';
                        } else {
                            echo esc_html__('To customize the contents of this header banner and other elements of your site, go to Dashboard > Appearance > Customize', 'wp-bootstrap-starter');
                        }
                    ?>
                    
                    <?php if ( !get_theme_mod( 'home_search_one_button' ) ) { ?>
                        <article class="home-search-block">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fas fa-search"></i> </span>
                                 </div>
                                <input name="" class="form-control leftmenu" placeholder="<?php _e( 'I want to find a horse, a pony or a reference ...', 'wp-bootstrap-starter' ); ?>" type="text" readonly>
                            </div> <!-- form-group// -->
                            <a class="eq-button eq-button-red" href="<?php echo get_site_url(); ?>/annonces/"><?php _e( 'See all ads', 'wp-bootstrap-starter' ); ?></a>
                        </article>
                    <?php } else { ?>
                        <article class="home-search-block">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fas fa-search"></i> </span>
                                 </div>
                                <input name="" class="form-control leftmenu" placeholder="<?php _e( 'I want to find a horse, a pony or a reference ...', 'wp-bootstrap-starter' ); ?>" type="text" readonly>
                            </div> <!-- form-group// -->
                            <div class="row">
                                <div class="col-6">
                                    <a class="eq-button eq-button-blue" href="#"><?php _e( 'Submit your ad', 'wp-bootstrap-starter' ); ?></a>
                                </div>
                                <div class="col-6">
                                    <a class="eq-button eq-button-red" href="<?php echo get_site_url(); ?>/annonces/"><?php _e( 'See all ads', 'wp-bootstrap-starter' ); ?></a>
                                </div>
                            </div>
                        </article>
                    <?php } ?>
                    
                    <a href="#content" class="page-scroller"><i class="fa fa-fw fa-angle-down"></i></a>
                    
                </div>
                
            </div>
            
            <?php
                $is_pub = (function_exists("eqpubGetPublicity")) ? eqpubGetPublicity() : false;
                if ( $is_pub && array_keys( $is_pub, true )) { ?>
                
                    <article class="eq-pub-desktop">
                        <a href="<?php echo $is_pub['link']; ?>" target="_blank" rel="nofollow">
                            <?php echo $is_pub['desktop']; ?>
                        </a>
                    </article>
                
            <?php } ?>
                
            <!-- Mobile -->
            <?php if ( !get_theme_mod( 'home_search_one_button' ) ) { ?>
            
                <article class="home-search-block eq-pub-mobile">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fas fa-search"></i> </span>
                         </div>
                        <input name="" class="form-control leftmenu" placeholder="<?php _e( 'I want to find a horse, a pony or a reference ...', 'wp-bootstrap-starter' ); ?>" type="text">
                    </div> <!-- form-group// -->
                    <h4>
                        <?php
                        if (get_theme_mod( 'header_banner_title_setting' )) {
                            echo get_theme_mod( 'header_banner_title_setting' );
                        } else {
                            echo 'EQUIPEER';
                        }
                        ?>
                    </h4>
                    
                    <?php
                    if (get_theme_mod( 'header_banner_tagline_setting' )) {
                        echo '<p>' . get_theme_mod( 'header_banner_tagline_setting' ) . '</p>';
                    } else {
                        echo esc_html__('To customize the contents of this header banner and other elements of your site, go to Dashboard > Appearance > Customize', 'wp-bootstrap-starter');
                    }
                    ?>
                    <a class="eq-button eq-button-red" href="<?php echo get_site_url(); ?>/annonces/"><?php _e( 'See all ads', 'wp-bootstrap-starter' ); ?></a>
                </article>
                
            <?php } else { ?>
            
                <article class="home-search-block eq-pub-mobile">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fas fa-search"></i> </span>
                         </div>
                        <input name="" class="form-control leftmenu" placeholder="<?php _e( 'I want to find a horse, a pony or a reference ...', 'wp-bootstrap-starter' ); ?>" type="text">
                    </div> <!-- form-group// -->
                    <h4>
                        <?php
                        if (get_theme_mod( 'header_banner_title_setting' )) {
                            echo get_theme_mod( 'header_banner_title_setting' );
                        } else {
                            echo 'EQUIPEER';
                        }
                        ?>
                    </h4>
                    
                    <?php
                    if (get_theme_mod( 'header_banner_tagline_setting' )) {
                        echo '<p>' . get_theme_mod( 'header_banner_tagline_setting' ) . '</p>';
                    } else {
                        echo esc_html__('To customize the contents of this header banner and other elements of your site, go to Dashboard > Appearance > Customize', 'wp-bootstrap-starter');
                    }
                    ?>
                    <div class="row">
                        <div class="col-12 sm-6 mb-3">
                            <a class="eq-button eq-button-blue" href="<?php echo get_site_url(); ?>/deposez-votre-annonce/"><?php _e( 'Submit your ad', 'wp-bootstrap-starter' ); ?></a>
                        </div>
                        <div class="col-12 sm-6">
                            <a class="eq-button eq-button-red" href="<?php echo get_site_url(); ?>/annonces/"><?php _e( 'See all ads', 'wp-bootstrap-starter' ); ?></a>
                        </div>
                    </div>
                </article>
            <?php } ?>
    
            <?php if ( $is_pub && array_keys( $is_pub, true ) ) { ?>
    
                <article class="eq-pub-mobile">
                    <a href="<?php echo $is_pub['link']; ?>" target="_blank" rel="nofollow">
                        <?php echo $is_pub['mobile']; ?>
                    </a>
                </article>
            
            <?php } ?>
    
        <?php endif; ?>
        
        <?php if ( !is_front_page() ) { ?>
            <div id="content-header" class="">
                <h1>
                    <?php
                        // Check if equine (post type)
                        if ( get_post_type( get_the_ID() ) == 'equine' ) {
                            if (is_post_type_archive())
                                echo trim( get_bloginfo( 'description' ) );
                            else
                                equipeer_head_text_horse( get_the_ID(), true );
    
                        } else {
                            // Page / Post
                            echo esc_html( get_the_title() );
                        }
                        
                    ?>
                </h1>
            </div>
            <?php if ( get_post_type( get_the_ID() ) == 'equine' && !is_post_type_archive() ) { ?>
                <div id="content-header-2" class="<?php echo get_post_type(); ?> mob-plnsc">
                    <?php
                        // -------------------------------------------
                        // --- MOBILE PREV/LIST/NEXT/SELECTION or CHAT
                        // --- body.single-equine
                        // -------------------------------------------
                        echo do_shortcode('[equine-prev-list-next-mob]');
                    ?>
                </div>
                <script>
                    jQuery(document).ready( function() {
                       //var notification_text = jQuery('#content-header-2 #yobro-new-message > div > div > div > a').text();
                       jQuery('#content-header-2 #yobro-new-message > div > div > div > a').text('');
                    });
                    // ============================================================
                    // ===== Behavior Scroll PREV/LIST/NEXT/SELECTION or CHAT =====
                    // ============================================================
                    var mobLastScrollTop = 0;
                    jQuery(window).scroll(function() {
                        // Interaction avec le menu mobile
                        if (jQuery(window).scrollTop() > 150) {
                            // Apparition du menu
                            jQuery('#content-header-2').addClass('content-header-2');
                                var mobst = jQuery(this).scrollTop();
                                if (mobst > mobLastScrollTop) {
                                    // Direction is DOWN
                                   jQuery( '.mob-plnsc' ).css( 'top', '55px' );
                                } else if( mobst == mobLastScrollTop ) {
                                    // Do nothing 
                                    // In IE this is an important condition because there seems to be some instances where the last scrollTop is equal to the new one
                                } else {
                                    // Direction is UP
                                   jQuery( '.mob-plnsc' ).css( 'top', '0' );
                                }
                                mobLastScrollTop = mobst;
                        } else {
                            // Repositionnement en relatif
                            jQuery('#content-header-2').removeClass('content-header-2');
                        }
                    });
                </script>
            <?php } ?>
        <?php } ?>
        
        <?php
            $content_model = basename( get_page_template() );
            $content_class = ($content_model == 'questionnaire-achat.php') ? "mt-0 mb-0 questionnaire-achat-bg" : "mt-2 mb-5";
        ?>
        <div id="content" class="site-content <?php echo $content_class; ?>">
            <div class="container">
                <div class="row">
                    <?php endif; ?>