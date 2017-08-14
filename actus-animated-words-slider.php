<?php
/**
 * 
 * @package     Actus_Animated_Words_Slider
 *
 * Plugin Name: ACTUS Animated Words Slider
 * Plugin URI:  http://wp.actus.works/actus-animated-words-slider/
 * Description: An image slider with a unique effect..
 * Version:     1.0.0
 * Author:      Stelios Ignatiadis
 * Author URI:  http://wp.actus.works/
 * Text Domain: actus-aaws
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/** 
 * Define Path Constants
 *
 * @since 0.1.0
 * @constant string ACTUS_THEME_DIR    Directory of the current Theme.
 * @constant string ACTUS_AAWS_NAME    Plugin Basename.
 * @constant string ACTUS_AAWS_DIR     Directory of the Plugin.
 * @constant string ACTUS_AAWS_DIR     URL of the Plugin.
 * @constant string ACTUS_AAWS_VERSION Plugin Version.
 */
function actus_aaws_define_constants() {
    if ( ! defined( 'ACTUS_AAWS_NAME' ) ) {
        define( 'ACTUS_AAWS_NAME', trim( dirname( plugin_basename(__FILE__) ), '/') );
    }
    if ( ! defined( 'ACTUS_AAWS_DIR' ) ) {
        define( 'ACTUS_AAWS_DIR', plugin_dir_path( __FILE__ ) );
    }
    if ( ! defined( 'ACTUS_AAWS_URL' ) ) {
        define( 'ACTUS_AAWS_URL', plugin_dir_url( __FILE__ ) );
    }
    if ( ! defined( 'ACTUS_AAWS_VERSION' ) ) {
        define( 'ACTUS_AAWS_VERSION', '1.0.0' );
    }
}
actus_aaws_define_constants();


// INCLUDE THE FILE THAT DEFINES VARIABLES AND DEFAULTS
require_once ACTUS_AAWS_DIR . '/includes/actus-aaws-variables.php';




// INITIALIZE
add_action( 'init', 'actus_aaws_init' );
add_action( 'current_screen', 'actus_aaws_admin' );



/* ********************************************************************* */
/* *********************************************************** FUNCTIONS */
/* ********************************************************************* */


/**
 * Plugin Initialization.
 *
 * Reads the options from database
 *
 * @global   array  $actus_anit_options        Array of plugin options.
 * @global   array  $actus_anit_default_terms  Array of default terms.
 *
 * @constant string ACTUS_AAWS_DIR             Directory of the Plugin.
 * @constant string ACTUS_AAWS_VERSION         Plugin Version.
 */
function actus_aaws_init() {
    
    
    update_option( 'ACTUS_AAWS_VERSION',    ACTUS_AAWS_VERSION );
    require_once ACTUS_AAWS_DIR . '/includes/actus-aaws-functions.php';
    
    // The Administration Options.
    if ( is_admin() ) {
        require_once ACTUS_AAWS_DIR . '/includes/actus-aaws-admin.php';
        require_once ACTUS_AAWS_DIR . '/includes/actus-aaws-edit.php';
    }

    add_shortcode( 'actus-awslider', 'actus_aaws_shortcode_start' );
} 

 
/**
 * Slider start.
 *
 * Initializes values and starts the slider animation.
 *
 * @since 0.1.0
 * @variable  array  $tmp_load_value                 Temporary holds the option data.
 * @variable  string $actus_aaws_slider_options_str  Temporary holds the option data.
 * @variable  array  $actus_aaws_params              Parameters to send to the script.
 *
 * @global    array  $actus_aaws_slider_options      The options for the slider animation.
 * @global    array  $actus_aaws_shortcode           The options of the slider shortcode.
 * @global    string $actus_aaws_outer_id            The id of the outer frame of the slider.
 * @global    int    $post_id                        The id of the current post or page.
 * @global    int    $post                           The current post.
 *
 * @constant  string ACTUS_AAWS_URL                  URL of the Plugin.
 */
function actus_aaws_start_slider( ) {
    global  $actus_aaws_slider_options,
            $actus_aaws_shortcode,
            $actus_aaws_outer_id,
            $post_id,
            $post;
    
    // Get post or page ID.
    $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
    if ( $post_id == null ) {
        $post_id = $post->ID;
    }
    // Replace defaults with saved values if they exist.
    $tmp_load_value = get_post_meta( $post_id, 'actus_aaws_slider_options' );
    if ( $tmp_load_value != null ) {
        $actus_aaws_slider_options_str = $tmp_load_value[ 0 ];
        $actus_aaws_slider_options = json_decode( $actus_aaws_slider_options_str, true );
    }
    // Override options with shortcode parameters if they exist.
    if ( $actus_aaws_shortcode[ 'height' ] > 0 ) {
        $actus_aaws_slider_options[ 'height' ] = $actus_aaws_shortcode[ 'height' ];
    }
    if ( $actus_aaws_shortcode[ 'density' ] > 0 ) {
        $actus_aaws_slider_options[ 'density' ] = $actus_aaws_shortcode[ 'density' ];
    }
    if ( $actus_aaws_shortcode[ 'speed' ] > 0 ) {
        $actus_aaws_slider_options[ 'speed' ] = $actus_aaws_shortcode[ 'speed' ];
    }
    if ( $actus_aaws_shortcode[ 'words' ] == 'off' ) {
        $actus_aaws_slider_options[ 'wordsStatus' ] = 0;
    }
    $actus_aaws_slider_options[ 'target' ]   = $actus_aaws_shortcode[ 'target' ];
    $actus_aaws_slider_options[ 'position' ] = $actus_aaws_shortcode[ 'position' ];
    
    // Enque styles and scripts
    wp_enqueue_style( 
        'actus-aaws-styles',
        ACTUS_AAWS_URL . 'css/actus-aaws.css',
        false, '1.0.0', 'all'
    );
            
    wp_enqueue_script(
        'velocity',
        ACTUS_AAWS_URL . 'js/velocity.min.js',
        array( 'jquery' ), '0.1.0', true );


    wp_enqueue_script(
        'actus-aaws-script',
        ACTUS_AAWS_URL . 'js/actus-aaws-scripts.js',
        array( 'jquery', 'velocity' ), '0.1.0', true ); 
    
    // Send parameters to scripts
    $actus_aaws_params = array(
        'post_id'    => $post_id,
        'slider_opt' => $actus_aaws_slider_options,
        'outer_id'   => $actus_aaws_outer_id,
        'plugin_dir' => ACTUS_AAWS_URL
    );
    wp_localize_script(
        'actus-aaws-script',
        'actusAawsParams', $actus_aaws_params );
}



/**
 * Slider Administration.
 *
 * Initializes values and starts the slider administration.
 *
 * @since 0.1.0
 * @variable  string $post_content             The content of your post.
 * @variable  array  $post_tags                The tags of your post.
 * @variable  array  $post_tag                 Tag value in iteration.
 * @variable  array  $actus_aaws_params_admin  Parameters to send to the script.
 * @variable  string $actus_aaws_slider_options_str  Temporary holds the option data.
 *
 * @global    array  $actus_aaws_options       The slider administgration options.
 * @global    array  $actus_excluded_words     Words that will be excluded from words selection.
 * @global    string $actus_symbols            Symbols that will be excluded from words selection.
 * @global    string $actus_nonce              Nonce for the administration.
 * @global    int    $post_id                  The id of the current post or page.
 *
 * @constant  string ACTUS_AAWS_DIR            URL of the Plugin.
 * @constant  string ACTUS_AAWS_VERSION        Plugin Version.
 */
function actus_aaws_admin() {
    global  $actus_aaws_options,
            $actus_excluded_words,
            $actus_symbols,
            $actus_nonce,
            $post_id;
    
    
    // ENQUE SCRIPTS FOR POST EDIT OR ADD
    if ( is_admin() && isset( get_current_screen()->id ) ) {
        if ( get_current_screen()->id == "post" || get_current_screen()->id == "page"  ) {
            
            $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
            
            // Start the slider animation (initializes the slider options and functions)
            actus_aaws_start_slider();
            
            // Read post content and tags
            $post_content  = get_post_field( 'post_title', $post_id );
            $post_content .= get_post_field( 'post_content', $post_id );
            $post_content  = wp_strip_all_tags( $post_content );
            $post_tags     = get_the_tags( $post_id );
            $actus_aaws_options[ 'tags' ] = '';
            foreach ( $post_tags as $post_tag ) {
                $actus_aaws_options[ 'tags' ] .= $post_tag->name . ',';
            }
            $actus_aaws_options[ 'tags' ] = rtrim( $actus_aaws_options[ 'tags' ], ',' );
            
            
            // Read saved options and words
            $actus_aaws_options_str = get_post_meta( $post_id, 'actus_aaws_options' );
            if ( $actus_aaws_options_str != null ) {
                $actus_aaws_options = json_decode( $actus_aaws_options_str[ 0 ], true );
            }
            
            // get post images
            //$actus_aaws_options[ 'images' ] =  actus_get_post_images( $post_id );
            actus_get_post_images( $post_id );

            
            // Enque styles and scripts
            wp_enqueue_style( 
                'actus-aaws-admin-edit-styles',
                ACTUS_AAWS_URL . 'css/actus-aaws-admin.css',
                false, '1.0.0', 'all' );


            wp_enqueue_style( 'wp-color-picker' ); 
            
            wp_enqueue_script(
                'actus-aaws-admin-script',
                ACTUS_AAWS_URL . 'js/actus-aaws-scripts-admin.js',
                array( 'jquery', 'actus-aaws-script', 'wp-color-picker' ), '1.0.0', true );

            wp_enqueue_script(
                'actus-aaws-admin-controls',
                ACTUS_AAWS_URL . 'js/actus-aaws-controls-admin.js',
                array( 'jquery', 'actus-aaws-script', 'actus-aaws-admin-script', 'wp-color-picker' ), '1.0.0', true );


            // Send parameters to scripts
            $actus_nonce = wp_create_nonce( 'actus_nonce' );
            $actus_aaws_params_admin = array(
                'ajax_url'   => admin_url( 'admin-ajax.php' ),
                'nonce'      => $actus_nonce,
                'post_id'    => $post_id,
                'content'    => $post_content,
                'options'    => $actus_aaws_options,
                'slider_opt' => $actus_aaws_slider_options,
                'symbols'    => $actus_symbols,
                'excluded'   => $actus_excluded_words,
                'plugin_dir' => ACTUS_AAWS_URL
            );
            wp_localize_script(
                'actus-aaws-admin-script',
                'actusAawsParamsAdmin', $actus_aaws_params_admin );
            
            
            // Initialize and display the administration metaboxes
            // This action is documented in includes/actus-aaws-edit.php
            add_action( 'add_meta_boxes', 'actus_aaws_meta_boxes' );

        }
    }
}








/*
 * Add settings link on plugin page
 *
 * @since 0.1.0
 */
function actus_aaws_settings_link( $links ) { 
  $settings_link = '<a href="admin.php?page=actus-animated-words-slider">Settings</a>'; 
  array_unshift( $links, $settings_link ); 
  return $links; 
}
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'actus_aaws_settings_link' );








/**
 * Executes the animation function when a shortcode is called.
 */
function actus_aaws_shortcode_start( $atts ) {
    global $actus_aaws_outer_id, $actus_aaws_shortcode;
    
	$atts = shortcode_atts(
		array(
			'height'   => $actus_aaws_shortcode[ 'height' ],
			'words'    => $actus_aaws_shortcode[ 'words' ],
			'density'  => $actus_aaws_shortcode[ 'density' ],
			'speed'    => $actus_aaws_shortcode[ 'speed' ],
            'target'   => $actus_aaws_shortcode[ 'target' ],
			'position' => $actus_aaws_shortcode[ 'position' ],
		), $atts, 'actus-awslider' );
    
    $actus_aaws_shortcode[ 'height' ]   = $atts[ 'height' ];
    $actus_aaws_shortcode[ 'words' ]    = $atts[ 'words' ];
    $actus_aaws_shortcode[ 'density' ]  = $atts[ 'density' ];
    $actus_aaws_shortcode[ 'speed' ]    = $atts[ 'speed' ];
    $actus_aaws_shortcode[ 'target' ]   = $atts[ 'target' ];
    $actus_aaws_shortcode[ 'position' ] = $atts[ 'position' ];
    
    $trg = '<div id="' . $actus_aaws_outer_id . '" class="actus-aaws-container"></div>';
    actus_aaws_start_slider();
    
    return $trg;
}



function actus_aaws_widget_start() {
    $a = "test";
    return $a;
}



/**
 * Plugin Widget
 */
class actus_aaws extends WP_Widget {

	// constructor
	function actus_aaws() {
        parent::WP_Widget(
            false, $name = __('ACTUS Animated Words Slider Widget', 'wp_widget_actus_aaws')
        );
	}

	// widget form creation
	function form($instance) {	
        // Check values
        if( $instance) {
             $title = esc_attr($instance['title']);
        } else {
             $title = '';
        }
        ?>

        <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
        <?php
	}

	// widget update
	function update($new_instance, $old_instance) {
        $instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
	}

	// widget display
	function widget($args, $instance) {
		echo actus_aaws_widget_start();
	}
}

// register widget
add_action( 'widgets_init', create_function( '', 'return register_widget("actus_aaws");') );


/**
 * Executes the animation function when a widget is called.
 * This action is documented in includes/actus-anit-main.php
 */

?>