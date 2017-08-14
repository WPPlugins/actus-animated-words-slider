/**
 * @summary The slider administration.
 *
 * Executed during post/page add or edit.
 * Initializes the slider preview and all the data and options needed for the slider setup.
 *
 * @since 0.1.0
 *
 * @global array  $varname Short description.
 * @fires target:event
 * @listens target:event
 *
 * @var   string  ID       The unique ID of this instance.
 * @var   string  terms    The terms to be animated.
 * @var   string  opts     The plugin options.
 * @var   string  selector The plugin selector name - #id.
 * @var   string  path     The plugin directory.
 *
 * @global array   actus_aaws_options       The slider administration options.
 * @global array   actus_aaws_post_content  The post content.
 * @global array   actus_aaws_other         Your custom words.
 * @global array   actusAawsParamsAdmin     Parameters received from PHP call.
 * @global array   actus_aaws_admin         Flag set when you are in slider administration.
 *
 * @see    js/actus-aaws-scripts.js
 * @global actus_aaws_slider_options, actus_aaws_slides;
*/

    var actus_aaws_options      = {};
    var actus_aaws_post_content = [];
    var actus_aaws_tags         = [];
    var actus_aaws_other        = [];
    var actus_aaws_admin        = 1;
    

    if ( actusAawsParamsAdmin.content !== null ) {
        actus_aaws_post_content = actusAawsParamsAdmin.content;
    }

    if ( actusAawsParamsAdmin.options !== null ) {
        actus_aaws_options = actusAawsParamsAdmin.options;
        if ( typeof( actus_aaws_options.otherWords ) !== "undefined" ) {
            actus_aaws_tags  = actus_aaws_options.tags;
            actus_aaws_tags  = actus_aaws_tags.split(',');
            actus_aaws_other = actus_aaws_options.otherWords;
            actus_aaws_other = actus_aaws_other.split(',');
        }
    }
    
    // prototype replaceAll
    String.prototype.replaceAll = function (stringFind, stringReplace) {
        var ex = new RegExp(stringFind.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1"), "g");
        return this.replace(ex, stringReplace);
    };
    
    
(function( $ ){

    // INIT IMAGES & SLIDER    
    actus_aaws_init_admin();
    actus_aaws_refresh_slider_flow( function(){
        actus_aaws_slider( '#actus-aaws-preview', 0 );
    });
    
    
    // INIT WORDS
    actus_aaws_refresh_post_words( function() {
        actus_aaws_refresh_tags( function() {
            actus_aaws_refresh_other_words( function() {
                actus_aaws_refresh_all_words( actus_aaws_update_options );
            });
        });
    });

    // INIT WORDS ΑΝΙΜΑΤΙΟΝ
    actus_aaws_words_animation( actus_aaws_slider_options.id, "#actus-aaws-preview" );
    
    
})(jQuery);
   
    


var $ = jQuery.noConflict();
    

/**
 * @summary Stringifies the options arrays and assigns them to the inputs (to be saved).
 *
 * @since 0.1.0
 *
 * @var    string  actus_aaws_slider_options_str  stringified slider options array.
 * @var    string  actus_aaws_options_str         stringified options array.
 *
 * @global actus_aaws_slider_options, actus_aaws_options;
 */
function actus_aaws_update_options() {
    actus_aaws_options_str        = JSON.stringify( actus_aaws_options );
    actus_aaws_slider_options_str = JSON.stringify( actus_aaws_slider_options );
    $( '#actus_aaws_options' ).val( actus_aaws_options_str );
    $( '#actus_aaws_slider_options' ).val( actus_aaws_slider_options_str );
}

    
/**
 * @summary Initializes slider administration.
 */
function actus_aaws_init_admin() {

    $('.actus-color-pick').wpColorPicker({
        change: function(event, ui){
            $( this ).val( ui.color.toString() );
            alt = event.target[ 'alt' ];
            actus_aaws_slider_options[ alt ] = ui.color.toString();
            actus_aaws_update_options();
        }
    });
    $('.wp-picker-container a').attr( 'title', '' );
}



/**
 * @summary Refreshes the slider flow panel.
 *
 * @since 0.1.0
 *
 * @var    string  actus_aaws_slider_options_str  stringified slider options array.
 * @var    string  arrowRightUrl                  The url of the arrow icon.
 * @var    string  arrowRight                     The html of the arrow icon.
 * @var    string  image_box                      The html of the image box.
 * @var    string  imgType                        category of image.
 * @var    int     imgIdx                         image index.
 *
 * @global actusAawsParamsAdmin, actus_aaws_slider_options, actus_aaws_options;
 * @global actus_aaws_slides;
 *
 * @param  string  callback                       The callback function.
 */
function actus_aaws_refresh_slider_flow( callback ) {
    callback = callback || function(){};
    // define slider arrow
    arrowRightUrl = actusAawsParamsAdmin.plugin_dir + "img/arrow_right.jpg";
    arrowRight  = '<div class="actus-aaws-arrow">';
    arrowRight += '<img src="' + arrowRightUrl + '">';
    arrowRight += '</div>';

    $( '#actus-aaws-slider-flow' ).empty();

    // Read new images
    i = actus_aaws_slides.length;
    $( '.actus-aaws-box-images-panel.active .actus-aaws-thumb[data-status="2"]' )
        .each( function(){
        if ( $( this ).data( 'url' ) != '' ) {
            imgIdx  = $( this ).data( 'idx' );
            imgType = $( this ).closest('.actus-aaws-box-images-panel').attr( 'alt' );
            actus_aaws_options['images'][ imgType ][ imgIdx ][ 'status' ] = 1;
            actus_aaws_slides[ i ] = {};
            actus_aaws_slides[ i ].id     = $( this ).data( 'id' );
            actus_aaws_slides[ i ].url    = $( this ).data( 'url' );
            $( this ).attr( 'data-status', 1 );
            i++;
        }
    })
    // update slider options
    actus_aaws_slider_options.slides = actus_aaws_slides;
    actus_aaws_slider_options_str    = JSON.stringify( actus_aaws_slider_options );
    $( '#actus_aaws_slider_options' ).val( actus_aaws_slider_options_str );


    // hide preview if no slides available
    if ( actus_aaws_slides.length > 0 ) {
        $( '#actus-aaws-preview' ).slideDown( 300 );
    } else {
        $( '.actus-aaws-box-images-frame' ).slideDown( 300 );
        var inf = '<div class="actus-aaws-info">' +
                  'You have no images in your post.' +
                  '</div>';
        $('#actus-aaws-slider-flow').append( inf );

    }
    // populate SLIDER FLOW
    $.each( actus_aaws_slides, function( i, image ){
        image_box = "<div class='actus-aaws-thumb' " +
                              "data-id='" + image.id + "' " +
                              "data-url='" + image.url + "'>" +
                        "<img src='" + image.url + "'>" +
                        arrowRight +
                    "</div>";
         $( '#actus-aaws-slider-flow' ).append( image_box );
    })
    $('#actus-aaws-slider-flow .actus-aaws-thumb')
        .last().find( '.actus-aaws-arrow').hide();
    $( '#actus-aaws-slider-flow' ).append( '<div style="clear:both"></div>' );


    // Make Images Dragable and Sortable
    $( "#actus-aaws-slider-flow" ).sortable({
        stop: function( event, ui ) {

            actus_aaws_slides = [];
            var i = 0;
            $( '#actus-aaws-slider-flow .actus-aaws-thumb' ).each( function(){
                actus_aaws_slides[ i ] = {};
                actus_aaws_slides[ i ].id  = $( this ).data( 'id' );
                actus_aaws_slides[ i ].url = $( this ).data( 'url' );
                i++;
            })
            actus_aaws_slider_options.slides = actus_aaws_slides;
            clearTimeout( sliderTiming );
            $( '.actus-aaws-slide' ).remove();
            actus_aaws_refresh_slider_flow( function(){
                actus_aaws_slider( '#actus-aaws-preview', 0 );
            });

        }
    });
    $( "#actus-aaws-slider-flow" ).disableSelection();

    callback();



}



/**
 * @summary Refreshes the post words panel.
 *
 * @since 0.1.0
 *
 * @var    array   actus_aaws_post_words          Words used in post content.
 * @var    string  actus_aaws_words_str           Words comma seperated list.
 * @var    string  wordH                          The html of the word element.
 *
 * @global actus_aaws_options, actus_aaws_words, actus_aaws_slides;
 *
 * @param  string  callback                       The callback function.
 */
function actus_aaws_refresh_post_words( callback ) {
    callback = callback || function(){};

    // get words from content (most used)
    actus_aaws_post_words = actus_words_count ( 
        actus_aaws_post_content,
        actus_aaws_options.minChars,
        actus_aaws_options.minUsed
    );
    // populate panel
    actus_aaws_words_str = '';
    $( '#actus-aaws-post-words' ).empty();
    $.each( actus_aaws_post_words, function( w, cnt ) {
        if ( w != "" ) {
            actus_aaws_words_str += w + ',';
            var c = '';
            if ( $.inArray( w, actus_aaws_words ) === -1 &&
                 actus_aaws_words.length > 0 &&
                 actus_aaws_words != null &&
                 actus_aaws_options.wordsPanel1 == 1 ) {
                c = 'inactive';
            }
            wordH = "<div class='actus-aaws-admin-word " + c + "' alt='" + w + "'>" + 
                    w + ' <span>'+cnt+'</span>' + "</div>";
            $( '#actus-aaws-post-words' ).append( wordH );
        }
    })
    actus_aaws_words_str = actus_aaws_words_str.slice(0, -1);
    //$( '#actus_aaws_words' ).val( actus_aaws_words_str );
    callback();

}

    
// REFRESH TAGS
// ************
function actus_aaws_refresh_tags( callback ) {
    callback = callback || function(){};
    actus_aaws_tags_str = '';
    $( '#actus-aaws-tags' ).empty();
    $.each( actus_aaws_tags, function( i, t ) {
        if ( t != "" ) {
            var c = '';
            if ( $.inArray( t, actus_aaws_words ) === -1 &&
                 actus_aaws_words.length > 0 &&
                 actus_aaws_words != null &&
                 actus_aaws_options.wordsPanel2 == 1 ) {
                c = 'inactive';
            }
            wordH = "<div class='actus-aaws-admin-word " + c + "' alt='" +
                    t + "'>" + t + "</div>";
            $( '#actus-aaws-tags' ).append( wordH );
            actus_aaws_tags_str += t + ',';
        }
    })
    actus_aaws_tags_str = actus_aaws_tags_str.slice(0, -1);
    callback();
}


// REFRESH OTHER WORDS
// *******************
function actus_aaws_refresh_other_words( callback ) {
    callback = callback || function(){};


    actus_aaws_other_str = '';
    $( '.actus-aaws-other-words-frame' ).empty();
    $.each( actus_aaws_other, function( i, w ) {
        if ( w != "" ) {
            actus_aaws_other_str += w + ',';
            var c = '';
            if ( $.inArray( w, actus_aaws_words ) === -1 &&
                 actus_aaws_words.length > 0 &&
                 actus_aaws_words != null &&
                 actus_aaws_options.wordsPanel3 == 1 ) {
                c = 'inactive';
            }
            wordH = "<div class='actus-aaws-admin-word " + c + "' alt='" + w + "'>" + 
                    w + "</div>";
            $( '.actus-aaws-other-words-frame' ).append( wordH );
        }
    })
    actus_aaws_other_str = actus_aaws_other_str.slice(0, -1);
    callback();

}



// REFRESH ALL WORDS
// *****************
function actus_aaws_refresh_all_words( callback ) {
    callback = callback || function(){};
    actus_aaws_words = [];
    actus_aaws_words_str = '';
    $( '#actus-aaws-all-words' ).empty();
    $( '.actus-aaws-box-words-panel.active .actus-aaws-admin-word' )
        .not( '.inactive' ).each( function(){
        w = $( this ).attr( 'alt' );
        wordH = "<div class='actus-aaws-admin-word'>" + w + "</div>";
        $( '#actus-aaws-all-words' ).append( wordH );
        actus_aaws_words_str += w + ',';
        actus_aaws_words.push( w );
    })
    $( '#actus-aaws-all-words' ).append( '<div style="clear:both"></div>' );


    // update slider options
    actus_aaws_slider_options.words = actus_aaws_words;
    actus_aaws_slider_options_str = JSON.stringify( actus_aaws_slider_options );
    $( '#actus_aaws_slider_options' ).val( actus_aaws_slider_options_str );


    callback();
}


// COUNT WORDS
// *****************
function actus_words_count( txt, minChars, minUsed ) {
    var txt = txt || '';
    var minChars = minChars || 4;
    var minUsed  = minUsed  || 3;
    var words_used = {};
    var words_used_temp = [];
    var words_array = [];

    txt = txt.toLowerCase();
    // remove symbols
    $.each( actusAawsParamsAdmin.symbols, function( i, symb ) {
        txt = txt.replaceAll( symb, '' );
    })
    // create words array from text
    words_array = txt.split(' ');

    $.each( words_array, function( i, word ) {
        word = $.trim( word );
        // check for excluded words and minChars
        if ( $.inArray( word, actusAawsParamsAdmin.excluded ) === -1 && 
             word.length >= minChars ) {
            // add value to times used
            if ( typeof( words_used_temp[ word] ) === "undefined" ) {
                words_used_temp[ word ] = 0;
            }
            words_used_temp[ word ]++;
            // check for minimum times used
            if ( words_used_temp[ word ] >= minUsed ) {
                words_used[ word ] = words_used_temp[ word ];
            }
        } 
    })

    // Sort array
    actus_aaws_tmp = Object.keys( words_used ).sort( function( a, b ) {
        return words_used[ b ] - words_used[ a ]
    });
    words_used_tmp = {};
    $.each( actus_aaws_tmp, function( i, v ) {
        words_used_tmp[ v ] = words_used[ v ];
    })
    words_used = words_used_tmp;


    return words_used;

}



/**
 * sanitizes text
 */
function actus_sanitize_text( input ) {
    var output = input.replace(/<script[^>]*?>.*?<\/script>/gi, '').
                 replace(/<[\/\!]*?[^<>]*?>/gi, '').
                 replace(/<style[^>]*?>.*?<\/style>/gi, '').
                 replace(/<![\s\S]*?--[ \t\n\r]*>/gi, '');
    return output;
};
    
    
    
    
    
    