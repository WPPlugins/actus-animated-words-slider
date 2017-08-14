/**
 * @summary Creates the slider and Animates the images and words.
 *
 * Executed everytime a shortcode or widget is called and when administrating a slider.
 *
 * @since 0.1.0
 *
 *
 * @global array   actusAawsParams            Parameters received from PHP call.
 * @global array   actus_aaws_slider_options  The slider options.
 * @global array   actus_aaws_slides          The slides parameters.
 * @global array   actus_aaws_words           The words to be animated.
 * @global string  actus_aaws_words_div       The id of the words container.
 * @global string  actus_aaws_slides_div      The id of the slides container.
 * @global array   actus_aaws_args            The arguments for the words animation.
*/


var $ = jQuery.noConflict();

var actus_aaws_slider_options = {};
var actus_aaws_slides         = [];
var actus_aaws_words          = [];
var actus_aaws_words_div      = '';
var actus_aaws_slides_div     = '';
var actus_aaws_args           = {};

if ( actusAawsParams.slider_opt !== null ) {
    actus_aaws_slider_options = actusAawsParams.slider_opt;
    actus_aaws_slides = actus_aaws_slider_options.slides;
    actus_aaws_words  = actus_aaws_slider_options.words;
}



    
(function( $ ){


        
    if ( typeof( actus_aaws_admin ) == 'undefined' ) {
        //actus_aaws_refresh_slider_flow( function(){
            actus_aaws_slider( '', 0 );
            actus_aaws_words_animation( actus_aaws_slider_options.id, '' );
        //});
    }
    

})(jQuery);
    
    














/**
 * @summary Creates the slider box and starts the animation of the images.
 *
 * @since 0.1.0
 *
 * @var    string  aawsid        The unique id of the slider.
 *
 * @global actus_aaws_slider_options, actus_aaws_slides, actusAawsParams;
 * @global actus_aaws_words_div, actus_aaws_slides_div;
 *
 * @param  string  target        The id of the target element.
 * @param  int     idx           The index of the slide.
 * @param  string  callback      The callback function.
 */
function actus_aaws_slider( target, idx, callback ) {
    callback = callback || function(){};
    idx = idx || 0;
    target = target || '';
    if ( target == '' ) {
        target = "#" + actusAawsParams.outer_id;
    }
    // attach the slider to a target if one is specified in a shortcode
    if ( actus_aaws_slider_options.target != '' ) {
        $( target ).prependTo( actus_aaws_slider_options.target );
   }
    // absolute position the slider to a target
    if ( actus_aaws_slider_options.position == 'absolute' ) {
        $( target ).css({
            position: 'absolute',
            width: '100%'
        });
    }
    // return if there are no slides
    if ( typeof( actus_aaws_slides ) == "undefined" ) return;
    if ( actus_aaws_slides.length < 1 ) return;
    
    // create the slider box
    aawsid = actus_aaws_slider_options.id;
    if ( $( target ).length > 0 ) {
        if ( $( '#' + aawsid ).length == 0 ) {
            $( target ).append( '<div class="actus-aaws-frame" id="' + aawsid + '"></div>' );
            $( '#' + aawsid ).append( '<div id="actus-aaws-words"></div>' );
            $( '#' + aawsid ).append( '<div id="actus-aaws-slides"></div>' );
        }
    }
    actus_aaws_words_div  = target + ' #actus-aaws-words';
    actus_aaws_slides_div = target + ' #actus-aaws-slides';
    // set the slider height
    $( target ).css( 'height', actus_aaws_slider_options.height );

    
    // Animate the first slide and loop through available slides
    idx++;
    if ( typeof( actus_aaws_slides[ idx-1 ] ) == "undefined" ) {
        idx = 1;
    }
    actus_aaws_slide( actus_aaws_slides[ idx-1 ], function(){ 
        actus_aaws_slider( target, idx, callback );
    });

}


/**
 * @summary Animating the Slide
 *
 * @since 0.1.0
 *
 * @var    int     trans         The transition time.
 * @var    int     dtime         The delay time.
 * @var    string  slide         The slide html.
 * @var    string  zooA          The starting value for image scaling.
 * @var    string  zooB          The ending value for image scaling.
 * @var    string  rotA          The starting value for image rotation.
 * @var    string  rotB          The ending value for image rotation.
 * @var    string  sliderTiming  The timeout for slide clearing at the end.
 *
 * @global actus_aaws_slider_options, actus_aaws_slides, actusAawsParams;
 * @global actus_aaws_words_div, actus_aaws_slides_div;
 *
 * @param  array   image         The image data.
 * @param  string  callback      The callback function.
 */
function actus_aaws_slide( image, callback ) {
    image = image || [];
    trans = actus_aaws_slider_options[ 'transition' ] * 1000;  // transition time
    dtime = actus_aaws_slider_options[ 'slide_time' ] * 1000;  // delay time
    
    // return if there are no image data
    if ( image.length == 0 ) return;
    
    // set slide html
    slide = '<div class="actus-aaws-slide faded" ' +
            '     id="actus-aaws-slide-' + image.id + '"' +
            '     data-id="' + image.id + '"' +
            '     data-url="' + image.url + '">' +
                '<img src="' + image.url + '">' +
            '</div>';

    // set zomm and rotation values
    zooA = '1';
    zooB = '1';
    if ( actus_aaws_slider_options['imageZoom'] == '1' ) {
        zooA = '1.75';
        zooB = '1.2';
    }
    rotA = '0deg';
    rotB = '0deg';
    if ( actus_aaws_slider_options['imageRot'] == '1' ) {
        rotA = '20deg';
        rotB = '-5deg';
        if ( actus_aaws_slider_options['imageZoom'] == '0' ) {
            zooA = '1.2';
            zooB = '1.2';
            rotA = '7.5deg';
            rotB = '-7.5deg';
        }
    }
    // add slide to the slider
    $( actus_aaws_slides_div ).append( slide );
    // animate the slide
    $( '#actus-aaws-slide-' + image.id ).velocity({
        opacity: [ 1, [0,0,0,1.62] ],
        scale: [ zooA, [0,0,1,1], zooB ],
        rotateZ: [ rotA, [0,0,1,1], rotB ],
        translateZ: 0
    }, (trans+dtime+trans+1), function() {

    });
    // clear the slide at the end of the animation
    sliderTiming = setTimeout( function(){
        $( '.actus-aaws-slide' ).not( '#actus-aaws-slide-' + image.id ).remove();
        callback();
    }, (trans+dtime) );

}





/**
 * @summary Sets the random values needed for the words animation.
 *
 * @since 0.1.0
 *
 * @var    int     minTime       Mininun duration of the animation
 * @var    int     maxTime       Maximum duration of the animation
 * @var    array   opts          Alias for the slider options.
 * @var    array   terms         Alias for the words to be animated.
 * @var    int     sliderHeight  Temporary data.
 * @var    int     tmpRand       Temporary data.
 *
 * @global actus_aaws_slider_options, actus_aaws_words, actus_aaws_args;
 *
 * @param string   iid           The unique ID of the current instance.
 * @param string   callback      The callback function.
*/
function actus_aaws_random( iid, callback ) {
    callback = callback || function(){};
    var minTime  =  7 * 1000;  // mininun duration of the animation
    var maxTime  = 30 * 1000;  // maximum duration of the animation
    var opts     = actus_aaws_slider_options;
    var terms    = actus_aaws_words;
    
    // Random Color
    tmpRand = Math.floor( ( Math.random() * 3 ) + 1);
    actus_aaws_args[ iid ].randomColor = 'colorA';
    if ( tmpRand == 2 ) {
        actus_aaws_args[ iid ].randomColor = 'colorB';
    }
    
    // Random Word
    actus_aaws_args[ iid ].randomTerm =
        terms [ Math.floor( ( Math.random() * terms.length ) + 1) ];
    
    // Random Font Size
    var sliderHeight = parseInt( opts.height );
    opts.min_font_size = sliderHeight / 15;
    opts.max_font_size = sliderHeight;
    randomFontSizeTmp =
        Math.floor( Math.random() * ( opts.max_font_size - opts.min_font_size ) +
        opts.min_font_size );
    actus_aaws_args[ iid ].randomFontSize = randomFontSizeTmp * opts.font_size;

    // Random Opacity
    actus_aaws_args[ iid ].randomOpacity =
        ( Math.floor( ( Math.random() * (opts.max_opacity - 5) ) + 5 ) ) / 100;

    // Random Vertical Position
    actus_aaws_args[ iid ].randomVpos =
        Math.floor( ( Math.random() *
        ( opts.height - ( actus_aaws_args[ iid ].randomFontSize / 3.75 ) ) ) -
        ( actus_aaws_args[ iid ].randomFontSize / 5 ) );

    // Random Speed
    actus_aaws_args[ iid ].randomSpeed =
        Math.floor( Math.random() * ( maxTime - minTime + 1 ) + minTime );
    actus_aaws_args[ iid ].randomSpeed = actus_aaws_args[ iid ].randomSpeed / opts.speed;

    // Random Direction
    actus_aaws_args[ iid ].randomDirection = Math.floor( ( Math.random() * 2 ) + 1 );
    
    
    callback();
}
 




/**
 * @summary Sets the background and the height of the plugin.
 *
 * @since 0.1.0
 *
 * @var    int     randomFreq    Time until next timeout.
 * @var    int     visibleTags   The number of currently visible tags.
 *
 * @global actus_aaws_slider_options, actus_aaws_words, actus_aaws_args, actusAawsParams;
 *
 * @param string   iid           The unique ID of the current instance.
 * @param  string  target        The id of the target element.
*/
function actus_aaws_words_animation( iid, target ) {
    
    // return if words animation is turned off
    if ( actus_aaws_slider_options[ 'wordsStatus' ] == '0' ) return;
    
    var randomFreq;
    target = target || '';
    if ( target == '' ) {
        target = "#" + actusAawsParams.outer_id;
    }
    if ( typeof( actus_aaws_args ) === "undefined" ) {
        actus_aaws_args = {};
    }
    if ( typeof( actus_aaws_args[ iid ] ) === "undefined" ) {
        actus_aaws_args[ iid ] = {};
    }
    if ( typeof( actus_aaws_args[ iid ].visibleTags ) === "undefined" ) {
        actus_aaws_args[ iid ].visibleTags = 0;
    }

    // set random values
    actus_aaws_random( iid, function(){
        // if maximum visible tags limit is not exceeded animate word
        if ( actus_aaws_args[ iid ].visibleTags < parseInt( actus_aaws_slider_options.density ) ) {
            actus_aaws_animate_word( iid, target );
        }
    });
        
    // set random time until next word animation (different according to density value)
    randomFreq = Math.floor((Math.random() * 5500) + 700);
    if ( actus_aaws_slider_options.density > 8 ) {
        randomFreq = Math.floor((Math.random() * 3000) + 350);
    }
    if ( actus_aaws_slider_options.density > 20 ) {
        randomFreq = Math.floor((Math.random() * 1000) + 150);
    }
    
    // animate the next word after random amount of time
    window.setTimeout(function() { 
        actus_aaws_words_animation( iid );
    }, randomFreq );

}





/**
 * @summary Animates a word.
 *
 * @since 0.1.0
 *
 * @var    string  termID      The word element id.
 * @var    string  termH       The word element html.
 * @var    string  cur         The current word element.
 * @var    string  cur_color   The color of the current word element.
 * @var    string  curW        The width of the current word element.
 * @var    string  cloudW      The width of the slider.
 * @var    string  startX      The starting position of the word element.
 * @var    string  endX        The ending position of the word element.
 *
 * @global actus_aaws_words_div;
 *
 * @param string   iid         The unique ID of the current instance.
 * @param  string  target      The id of the target element.
*/
function actus_aaws_animate_word( iid, target ) {
    target = target || '';
    var termID, termH, cur, cur_color, curW, cloudW, startX, endX;

    // if word data exist
    if ( typeof( actus_aaws_args[ iid ].randomTerm ) !== 'undefined' ) {

        // increase visible tags
        actus_aaws_args[ iid ].visibleTags = actus_aaws_args[ iid ].visibleTags + 1;

        // set the word element
        termID = 'T-' + $.now();
        termH  = '<p id="' + termID + '" class="actus-animated-tag">' + 
                 actusUpper( actus_aaws_args[ iid ].randomTerm ) + '</p>';
        $( actus_aaws_words_div ).append( termH );
        cur = $( actus_aaws_words_div + ' .actus-animated-tag' ).last();
        // set the color of the element
        cur_color = actus_aaws_slider_options[ actus_aaws_args[ iid ].randomColor ];
        // set the position of the element
        cloudW = $( actus_aaws_words_div ).width();
        $( '#' + termID ).css({ 'font-size': actus_aaws_args[ iid ].randomFontSize + 'px' });
        curW = cur.width();
        startX = 0 - curW;
        endX   = cloudW;
        if ( actus_aaws_args[ iid ].randomDirection == 2 ) {
            startX = cloudW;
            endX   = 0 - curW - 20;
        }
        
        // set the starting css values
        $( '#' + termID ).css({ 
            'transform': 'translateX(' + startX + 'px)',
            'top'      : actus_aaws_args[ iid ].randomVpos,
            'opacity'  : actus_aaws_args[ iid ].randomOpacity,
            'color'    : cur_color
        });
        
          
        // Animate the word
        window.setTimeout( function( tagID ) {  
            $( '#' + termID ).show();
            $( '#' + termID ).velocity({
                translateX: [ endX + 'px', [0,0,1,1], startX + 'px' ],
                translateZ: 0
            }, actus_aaws_args[ iid ].randomSpeed + 'ms', function() {
                $( this ).remove();
                actus_aaws_args[ iid ].visibleTags = actus_aaws_args[ iid ].visibleTags - 1;
                if ( actus_aaws_args[ iid ].visibleTags < 0 ) {
                    actus_aaws_args[ iid ].visibleTags = 0;
                }
            })
        }, 100, termID );

    
    }
}



    


/**
 * @summary Converts a string to uppercase removing accents on Greek alphabet.
 *
 * @since 0.1.0
 *
 * @param  string  string  The string to be converted.
 *
 * @return string  string  The converted string.
*/
function actusUpper( string ) {
// **************************************************************
    string = string.replace(/[ΰ]/g,"ϋ");
    string = string.replace(/[ΐ]/g,"ϊ");
    string = string.toUpperCase();
    string = string.replace(/[Ά]/g,"Α");
    string = string.replace(/[Έ]/g,"Ε");
    string = string.replace(/[Ή]/g,"Η");
    string = string.replace(/[Ύ]/g,"Υ");
    string = string.replace(/[Ώ]/g,"Ω");
    string = string.replace(/[Ί]/g,"Ι");
    string = string.replace(/[Ό]/g,"Ο");

    return string;
}   


