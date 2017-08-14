<?php
/**
 * Variables for ACTUS Animated Words Slider.
 *
 * @package    Actus_Animated_Words_Slider
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}



// DEFINE AND LOAD VARIABLES
global $actus_aaws_id, $actus_aaws_words, $actus_aaws_options, $actus_aaws_slider_options, $actus_symbols, $actus_excluded_words;

$rnd1 = rand( 1,9 );
$rnd2 = rand( 10,99 );
$rnd = $rnd1.$rnd2;
// Set ID and script parameters array
$actus_aaws_outer_id = "ACTUS-AAWS-" . $rnd;
$actus_aaws_id = "AAWS-" . $rnd;


// DEFAULT OPTIONS FOR THE ADMINISTRATION
$actus_aaws_words   = array();
$actus_aaws_options = array();
$actus_aaws_options['minChars'] = 4;
$actus_aaws_options['minUsed']  = 3;
$actus_aaws_options['wordsPanel1']  = 1;
$actus_aaws_options['wordsPanel2']  = 0;
$actus_aaws_options['wordsPanel3']  = 0;
$actus_aaws_options['imagesPanel1'] = 1;
$actus_aaws_options['imagesPanel2'] = 1;
$actus_aaws_options['imagesPanel3'] = 1;
$actus_aaws_options['imagesPanel4'] = 1;
$actus_aaws_options['tags']         = "";
$actus_aaws_options['otherWords']   = "";
$actus_aaws_options['images']       = array();
$actus_aaws_options['images']['attached']  = array();
$actus_aaws_options['images']['content']   = array();
$actus_aaws_options['images']['galleries'] = array();

// DEFAULT OPTIONS FOR THE SLIDER
$actus_aaws_slider_options = array();
$actus_aaws_slider_options[ 'id' ]      = $actus_aaws_id;
$actus_aaws_slider_options[ 'height' ]  = 300;
$actus_aaws_slider_options[ 'density' ] = 6;
$actus_aaws_slider_options[ 'colorA' ] = '#FFFFFF';
$actus_aaws_slider_options[ 'colorB' ] = '#000000';
$actus_aaws_slider_options[ 'wordsStatus' ] = '1';
$actus_aaws_slider_options[ 'imageZoom' ]   = '1';
$actus_aaws_slider_options[ 'imageRot' ]    = '1';
$actus_aaws_slider_options[ 'max_opacity' ]   = 65;
$actus_aaws_slider_options[ 'font' ]          = 'default';
$actus_aaws_slider_options[ 'font_size' ]     = 1.1;
$actus_aaws_slider_options[ 'transition' ]     = 3;
$actus_aaws_slider_options[ 'slide_time' ]     = 6;
$actus_aaws_slider_options[ 'speed' ]          = 1;
$actus_aaws_slider_options[ 'slides' ]         = [];
$actus_aaws_slider_options[ 'words' ]          = [];
$actus_aaws_slider_options[ 'target' ]         = '';
$actus_aaws_slider_options[ 'position' ]       = 'relative';

// DEFAULT OPTIONS FOR THE SHORTCODE
$actus_aaws_shortcode[ 'height' ]    = 0;
$actus_aaws_shortcode[ 'density' ]   = 0;
$actus_aaws_shortcode[ 'speed' ]     = 0;
$actus_aaws_shortcode[ 'target' ]    = '';
$actus_aaws_shortcode[ 'position' ]  = 'relative';



$actus_symbols = array("’s", ".", ",", "!", "'", '"', "/", "\\", "(", ")", "&", "=", "+", "-", "_", "@", "#", "$", "%", "^", "*", "|", ";", ":", "<", ">" );

$actus_excluded_words = array(
            '',
            'an',
            'as',
            'at',
            'or',
            'by',
            'are',
            'the',
            'to',
            'in',
            'a',
            'and',
            'of',
            'off',
            'her',
            'his',
            'him',
            'him',
            'he',
            'she',
            'it',
            'on',
            'into',
            'is',
            'its',
            'if',
            'then',
            "don't",
            "don’t",
            'when',
            'that',
            'this',
            'their',
            'they',
            'there',
            'where',
            'what',
            'which',
            'who',
            'whom',
            'has',
            'had',
            'have',
            'do',
            'did',
            'done',
            'was',
            'not',
            'but',
            'for',
            'your',
            'me',
            'from',
            'with',
);


