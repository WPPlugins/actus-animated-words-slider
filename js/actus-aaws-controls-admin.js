/**
 * @summary Handles all the reactions in the slider administration.
 *
*/

(function( $ ){
    
    
    
    // IMAGES FRAME TOGGLE
    // ******************
    $( 'body' ).on( 'click', '.actus-aaws-images-frame-title', function() {
        $( '.actus-aaws-box-images-frame' ).slideToggle( 250 );
    })
    

    // IMAGES PANEL TOGGLE
    // ************
    $( 'body' ).on( 'click', '.actus-aaws-box-images-panel-L img', function() {
        panelID = $( this ).parent().parent().attr( 'id' );
        $( '#' + panelID ).toggleClass( 'active' );
        chckbx_url = actusAawsParamsAdmin.plugin_dir + "img/checkbox1.png";
        $( '#' + panelID ).find( 'input' ).attr( 'disabled', 'disabled' );
        actus_aaws_options[ panelID ] = 0;
        if ( $( '#' + panelID ).hasClass( 'active' ) ) {
            chckbx_url = actusAawsParamsAdmin.plugin_dir + "img/checkbox2white.png";
            $( '#' + panelID ).find( 'input' ).removeAttr( 'disabled' );
            actus_aaws_options[ panelID ] = 1;
        }
        $( this ).attr( 'src', chckbx_url );
        if ( typeof( sliderTiming ) !== 'undefined' ) {
            clearTimeout( sliderTiming );
        }
        $( '.actus-aaws-slide' ).remove();
        actus_aaws_refresh_slider_flow( function(){
            actus_aaws_slider( '#actus-aaws-preview', 0 );
        });
    }) 
    
    
    // IMAGE TOGGLE
    // ************
    $( 'body' ).on( 'click', '.actus-aaws-box-images-frame .actus-aaws-thumb', function() {
        var imgSt   = parseInt( $( this ).data( 'status' ) );
        var imgId   = $( this ).data( 'id' );
        var imgIdx  = $( this ).data( 'idx' );
        var imgType = $( this ).closest('.actus-aaws-box-images-panel').attr( 'alt' );
        

        if ( imgSt == 0 ) {
            imgSt = 1;
            $( this ).removeClass( 'inactive' );
            $( this ).clone().appendTo( '#actus-aaws-slider-flow' );
        } else {
            imgSt = 0;
            $( this ).addClass( 'inactive' );
            $('#actus-aaws-slider-flow .actus-aaws-thumb[data-id="' + imgId + '"]')
            .remove();
        }
        $( this ).data( 'status', imgSt ); 
        $( this ).attr( 'data-status', imgSt );
        
        actus_aaws_options[ 'images' ][ imgType ][ imgIdx ][ 'status' ] = imgSt;
        actus_aaws_update_options();
        
        actus_aaws_slides = [];
        i = 0;
        $( '#actus-aaws-slider-flow .actus-aaws-thumb' )
            .each( function(){
            if ( $( this ).data( 'url' ) != '' ) {
                actus_aaws_slides[ i ] = {};
                actus_aaws_slides[ i ].id     = $( this ).data( 'id' );
                actus_aaws_slides[ i ].url    = $( this ).data( 'url' );
                i++;
            }
        })

        
        if ( typeof( sliderTiming ) !== 'undefined' ) {
            clearTimeout( sliderTiming );
        }
        $( '.actus-aaws-slide' ).remove();
        actus_aaws_refresh_slider_flow( function(){
            actus_aaws_slider( '#actus-aaws-preview', 0 );
        });
    }) 
    
    
    
    // ADD IMAGE
    // *********
    $( 'body' ).on( 'click', '.actus-aaws-add-image', function() {
        
        //actus_schools_images_count = jQuery( '.actus-schools-image' ).length;

        // MEDIA LIBRARY SETUP
        actus_aaws_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Select Image',
            button: {
                text: 'Add Image'
            },
            multiple: false
        });
        // SELECT IMAGE
        actus_aaws_uploader.on('select', function() {
            var attachment = actus_aaws_uploader.state().get('selection').first().toJSON();
            var img_id     = attachment['id'];
            var img_url    = attachment['url'];
            image_box = "<div class='actus-aaws-thumb' " +
                                  "data-id='" + img_id + "' " +
                                  "data-url='" + img_url + "'>" +
                            "<img src='" + img_url + "'>" +
                        "</div>";

            $ ( '.actus-aaws-add-image' ).before( image_box );
 

            actus_aaws_options['images']['attached'].push({ 
                id: img_id,
                idx: actus_aaws_options['images']['attached'].length,
                url: img_url,
                status: 1
            })
            actus_aaws_slides.push({ 
                id: img_id,
                url: img_url
            })
            actus_aaws_slider_options.slides = actus_aaws_slides;
            
            
            actus_aaws_update_options();
            
            
            if ( typeof( sliderTiming ) !== 'undefined' ) {
                clearTimeout( sliderTiming );
            }
            $( '.actus-aaws-slide' ).remove();
            actus_aaws_refresh_slider_flow( function(){
                actus_aaws_slider( '#actus-aaws-preview', 0 );
            });
        });
        // MEDIA LIBRARY OPEN
        actus_aaws_uploader.on('open', function(){
            var selection = actus_aaws_uploader.state().get('selection');
        });
        actus_aaws_uploader.open();
        return false;
    });

    
    
    
    // SLIDER FLOW TOGGLE
    // ******************
    $( 'body' ).on( 'click', '.actus-aaws-slider-flow-title', function() {
        $( '#actus-aaws-slider-flow' ).slideToggle( 250 );
    })
    
    
    
    // WORDS FRAME TOGGLE
    // ******************
    $( 'body' ).on( 'click', '.actus-aaws-words-frame-title', function() {
        $( '.actus-aaws-box-words-frame' ).slideToggle( 250 );
    })
    
    
    // WORDS PANEL TOGGLE
    // ************
    $( 'body' ).on( 'click', '.actus-aaws-box-words-panel-L img', function() {
        panelID = $( this ).parent().parent().attr( 'id' );
        $( '#' + panelID ).toggleClass( 'active' );
        chckbx_url = actusAawsParamsAdmin.plugin_dir + "img/checkbox1.png";
        $( '#' + panelID ).find( 'input' ).attr( 'disabled', 'disabled' );
        actus_aaws_options[ panelID ] = 0;
        if ( $( '#' + panelID ).hasClass( 'active' ) ) {
            chckbx_url = actusAawsParamsAdmin.plugin_dir + "img/checkbox2white.png";
            $( '#' + panelID ).find( 'input' ).removeAttr( 'disabled' );
            actus_aaws_options[ panelID ] = 1;
        }
        $( this ).attr( 'src', chckbx_url );
        actus_aaws_refresh_all_words( actus_aaws_update_options );
    }) 
    
    
    // WORD TOGGLE
    // ***********
    $( 'body' ).on( 'click', '.actus-aaws-box-words-panel.active .actus-aaws-admin-word', function() {
        $( this ).toggleClass( 'inactive' );
        
        if ( $(this).closest( '.actus-aaws-box-words-panel' ).attr( 'id' ) == 'wordsPanel3' ) {
            actus_aaws_options[ 'otherWords' ] = '';
            $( '#wordsPanel3 .actus-aaws-admin-word' ).not( '.inactive' ).each( function(){
                w = $( this ).attr( 'alt' );
                actus_aaws_options[ 'otherWords' ] += w + ',';
            })
            actus_aaws_options[ 'otherWords' ] = actus_aaws_options[ 'otherWords' ].slice(0, -1);
            actus_aaws_update_options();
        }
        
        actus_aaws_refresh_all_words( actus_aaws_update_options );
    }) 
    
    
    // WORDS ADD
    // *********
    $( 'body' ).on( 'click', '.actus-aaws-box-words-panel.active .actus-aaws-add-words-box .dashicons', function() {
        v = $( this ).siblings( 'input' ).val();
        if ( v!="" ) {
            $( this ).siblings( 'input' ).val( "" );
            v = actus_sanitize_text( v );
            actusOtherWordsAr = v.split(',');
            $.each( actusOtherWordsAr, function ( i, w ){
                w = $.trim( w );
                wordH = "<div class='actus-aaws-admin-word' alt='" + w + "'>" + w + "</div>";
                $( '.actus-aaws-other-words-frame' ).append( wordH );
                $( '#actus-aaws-all-words' ).append( wordH );
            })
            
            
            actus_aaws_options[ 'otherWords' ] = '';
            $( '#wordsPanel3 .actus-aaws-admin-word' ).not( '.inactive' ).each( function(){
                w = $( this ).attr( 'alt' );
                actus_aaws_options[ 'otherWords' ] += w + ',';
                actus_aaws_other.push( w );
            })
            actus_aaws_options[ 'otherWords' ] = actus_aaws_options[ 'otherWords' ].slice(0, -1);
            actus_aaws_refresh_all_words( actus_aaws_update_options );
        }
    })
    
    
    // POST WORDS SETTINGS
    // *******************
    $( 'body' ).on( 'click', '.actus-aaws-post-words-settings-button', function() {
        $( '.actus-aaws-post-words-settings-frame' ).toggleClass( 'open' );
    })
    
    
    // POST WORDS SETTINGS INPUT
    // *************************
    $( 'body' ).on( 'change', '.actus-aaws-post-words-settings-frame input', function() {
        actus_aaws_options.minChars = $( '#actus-aaws-input-min-chars' ).val();
        actus_aaws_options.minUsed  = $( '#actus-aaws-input-min-used' ).val();
        
        if ( actus_aaws_options.minChars < 2 ) {
            actus_aaws_options.minChars = 2;
            $( '#actus-aaws-input-min-used' ).val( 2 );
        }
        if ( actus_aaws_options.minUsed < 1 ) {
            actus_aaws_options.minUsed = 1;
            $( '#actus-aaws-input-min-used' ).val( 1 );
        }
        actus_aaws_refresh_post_words( function() {
            actus_aaws_refresh_tags( function() {
                actus_aaws_refresh_other_words( function() {
                    actus_aaws_refresh_all_words( actus_aaws_update_options );
                });
            });
        });
        actus_aaws_update_options();
    })
    
    
    // POST WORDS SELECT TOGGLE
    // ************************
    $( 'body' ).on( 'click', '.actus-aaws-select-toggle', function() {
        v = $( this ).attr( 'alt' );
        if ( v == '1' ) {
            $( this ).attr( 'alt', '0' );
            $( '#wordsPanel1 .actus-aaws-admin-word' ).removeClass( 'inactive' );
        } else {
            $( this ).attr( 'alt', '1' );
            $( '#wordsPanel1 .actus-aaws-admin-word' ).addClass( 'inactive' );
        }
        actus_aaws_refresh_all_words( actus_aaws_update_options );
    });
    
    
    
    // SLIDER OPTIONS TOGGLE
    // *********************
    $( 'body' ).on( 'click', '.actus-aaws-slider-options-title', function() {
        $( '.actus-aaws-box-slider-options' ).slideToggle( 250 );
    })
    
    // OPTIONS TOGGLES
    // ***************
    $( 'body' ).on( 'click', '.actus-aaws-options-toggle', function() {
        var alt = $( this ).find( 'input' ).attr( 'alt' );
        var v   = $( this ).find( 'input' ).val();
        
        if ( v == '1' ) {
            v = '0';
            chckbx_url = actusAawsParamsAdmin.plugin_dir + "img/checkbox1.png";
            if ( $( this ).hasClass( 'actus-aaws-words-options-toggle' )  ){
                $( '.actus-aaws-words-option' ).addClass( 'inactive' );
            }
        } else {
            v = '1';
            chckbx_url = actusAawsParamsAdmin.plugin_dir + "img/checkbox2.png";
            if ( $( this ).hasClass( 'actus-aaws-words-options-toggle' )  ){
                $( '.actus-aaws-words-option' ).removeClass( 'inactive' );
                actus_aaws_slider_options[ alt ] = v;
                actus_aaws_words_animation( actus_aaws_slider_options.id, "#actus-aaws-preview" );
            }
        }
        $( this ).find( 'input' ).val( v );
        $( this ).find( 'img' ).attr( 'src', chckbx_url );
        
        actus_aaws_slider_options[ alt ] = v;
        actus_aaws_update_options();
    })
    
    
    
    // OPTIONS INPUT CHANGE
    // ********************
    $( 'body' ).on( 'change', '.actus-aaws-option-box input', function() {
        var name = $( this ).attr( 'name' );
        var alt  = $( this ).attr( 'alt' );
        var v    = $( this ).val();
        

        actus_aaws_slider_options[ alt ] = v;
        actus_aaws_update_options();
    })
    
    
    
    
    
    
    
    
    
    
    
    

})(jQuery);