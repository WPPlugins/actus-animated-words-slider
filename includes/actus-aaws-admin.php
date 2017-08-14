<?php
/**
 * The administration options.
 *
 * @package    Actus_Animated_Words_Slider
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}




/*
 * Adds ACTUS menu on admin panel
 */
if ( !function_exists( 'actus_menu' ) ) {
    function actus_menu(){
        add_menu_page( 
            'ACTUS Plugins',
            'ACTUS',
            'manage_options',
            'actus-plugins',
            'actus_plugins_page',
            ACTUS_AAWS_URL . 'img/actus_white_20.png',
            66
        );
    }
    if ( is_admin() ) {
        add_action( 'admin_menu', 'actus_menu' );
    }
}
/*
 * Adds submenu on Appearance menu
 */
if ( !function_exists( 'actus_aaws_submenu' ) ) {
    function actus_aaws_submenu() {
        add_submenu_page(
            'actus-plugins', 
            'ACTUS Animated Words Slider Options', 
            'ACTUS Animated Words Slider', 
            'manage_options', 
            'actus-animated-words-slider', 
            'actus_animated_words_admin_page'
        );
    }
    if ( is_admin() ) {
        add_action( 'admin_menu', 'actus_aaws_submenu' );
    }
}




/*
 * The ACTUS plugins page content
 */
if ( !function_exists( 'actus_plugins_page' ) ) {
    function actus_plugins_page() {
        
        // Enque styles
        wp_enqueue_style( 
            'actus-admin-styles',
            ACTUS_AAWS_URL . 'css/actus-admin.css',
            false, '1.0.0', 'all' );

        $actus_plugins_url = 'http://wp.actus.works/dev/actus-plugins.php';
        $actus_plugins     = file_get_contents( $actus_plugins_url, 0, null, null );
        echo $actus_plugins;
        $actus_w = ACTUS_AAWS_URL . 'img/actus_white.png'; 
        ?>
        <div id="actus-plugins-local">
            <div class="actus-plugins-top">
                <div class="actus-sep-16"></div>
                <img class="actus-plugins-logo" src="<?php echo $actus_w ?>">
                <h1>ACTUS WordPress Plugins</h1>
                <div class="actus-sep-16"></div>
            </div>
            
            <div class="actus-plugins-main"></div>
            
            <div class="actus-plugins-bottom">
                <div class="actus-sep-16"></div>
                <a href="http://wp.actus.works/" target="_blank">
                    <h1>http://wp.actus.works/</h1>
                </a>
                <div class="actus-sep-16"></div>
            </div>
        </div>
        <?php
    }
}

/*
 * The ACTUS Animated Words Slider administration page content
 */
if ( !function_exists( 'actus_animated_words_admin_page' ) ) {
    function actus_animated_words_admin_page() {
        
        // Enque styles
        wp_enqueue_style( 
            'actus-admin-styles',
            ACTUS_AAWS_URL . 'css/actus-admin.css',
            false, '1.0.0', 'all' );

        $actus_w   = ACTUS_AAWS_URL . 'img/actus_white.png';
        $actus_b   = ACTUS_AAWS_URL . 'img/actus_black.png';
        $actus_2   = ACTUS_AAWS_URL . 'img/actus_2.png';
        $actus_t   = ACTUS_AAWS_URL . 'img/title.png';
        $actus_i   = ACTUS_AAWS_URL . 'img/info.png';
        $actus_h   = ACTUS_AAWS_URL . 'img/help.png';
        $aaws_logo = ACTUS_AAWS_URL . 'img/aaws_logo_w100.png';
        $actus_ss1 = ACTUS_AAWS_URL . 'img/ss01.jpg';
        ?>

        <!-- ACTUS ADMIN -->
        <div class="actus-admin">
            
            <!-- HEADER -->
            <div class="actus-admin-header">
                <img src="<?php echo $actus_2; ?>">
                <img class="actus-admin-header-title" src="<?php echo $actus_t; ?>">
                <img class="actus-admin-header-logo" src="<?php echo $aaws_logo; ?>">
                <div class='actus-plugin-version'>v<?php echo ACTUS_AAWS_VERSION; ?></div>
            </div>

            <!-- INFORMATION -->
            <div class="actus-admin-info actus-admin-info-1">
                <div class="actus-admin-info-icon">
                    <img src="<?php echo $actus_i; ?>">
                </div>
                <div class="actus-admin-info-text">
                    <p>An image slider with animated words.</p>
                    <p>Extracts the most used words in your content and all the images you use and creates an elegant animated slider, unique for every post or page.</p>
                </div>
                <div style="clear:both"></div>
            </div>
            
            <!-- HELP -->
            <div class="actus-admin-info actus-admin-help">
                <div class="actus-admin-info-icon">
                    <img src="<?php echo $actus_h; ?>">
                </div>
                <div class="actus-admin-info-text">
                    <p>Use our widget or the shortcode <b>[actus_awslider]</b> to embed ACTUS Animated Words Slider anywhere in your website.</p>
                    <p>Refine the slider in the edit post/page.</p>
                </div>
                <div style="clear:both"></div>
            </div>
            
            <!-- MAIN -->
            <div class="actus-admin-main">
                <div class="actus-admin-screenshot">
                    <img src="<?php echo $actus_ss1; ?>">
                </div>
            </div>

            <!-- INFORMATION -->
            <div class="actus-admin-info actus-admin-info-1">
                <div class="actus-admin-info-icon">
                    <img src="<?php echo $actus_i; ?>">
                </div>
                <div class="actus-admin-info-text">
                    <div class="actus-sep-8"></div>
                    <div class="actus-sep-4"></div>
                    <p>Visit our website <a href='http://wp.actus.works'>ACTUS WordPress Plugins</a> to see more about our plugins.</p>
                </div>
                <div style="clear:both"></div>
            </div>
            
            <!-- FOOTER -->
            <div class="actus-admin-footer">
                <div class="actus">created by <a href="http://wp.actus.works" target="_blank">ACTUS anima</a></div>
                <div class="actus-sic">code &amp; design:  <a href="mailto:sic@actus.works" target="_blank">Stelios Ignatiadis</a></div>
            </div>
            
            <!-- ACTUS -->
            <div class="actus-admin-channel">send us your comments and suggestions to <a href="mailto:sic@actus.works" target="_blank">sic@actus.works</a></div>

        </div> <!-- ACTUS ADMIN -->
        <?php
    }
}



?>