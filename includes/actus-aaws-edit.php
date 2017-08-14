<?php
/**
 * Slider administration displayed in the edit post page.
 *
 * @package    Actus_Animated_Words_Slider
 */



/**
 * Create Metaboxes
 *
 * Initialize and display the slider administration metaboxes.
 *
 * @variable string  $actus_black              The logo url.
 * @variable string  $metabox_title            The metabox title.
 * @variable string  $pg_type                  The page type.
 *
 * @global   int     $post                      The current post.
 *
 * @constant string ACTUS_AAWS_URL             URL of the Plugin.
 */
function actus_aaws_meta_boxes() {
    
    $actus_black = ACTUS_AAWS_URL . 'img/actus_white_20.png';
    $metabox_title = "<img src='$actus_black' class='actus-metabox-logo'>";
    $metabox_title .= esc_html__( 'ACTUS Animated Words Slider', 'actus-aaws' );
    
    $pg_type = 'post';
    if ( get_current_screen()->id == "page" ) {
        $pg_type = 'page';
    }
    
    add_meta_box(
        'actus-aaws-box',
        $metabox_title,
        'actus_aaws_box_content', 
        $pg_type,
        'normal',         // Context
        'default'         // Priority
    ); 
    
}


/**
 * Metaboxes Content
 *
 * Initialize and display the slider administration metaboxes.
 *
 * @variable string  $post_images                All the images of the post.
 * @variable string  $image                      Image value in iteration.
 * @variable string  $chkbx                      The checkbox icon url.
 * @variable string  $clss                       Defines the inactive class.
 *
 * @global    array  $actus_aaws_options         The slider administgration options.
 * @global    array  $actus_aaws_slider_options  The options for the slider animation.
 *
 * @constant string ACTUS_AAWS_URL               URL of the Plugin.
 */
function actus_aaws_box_content( $post ) {
    global  $actus_aaws_options,
            $actus_aaws_slider_options;

    $post_images = $actus_aaws_options[ 'images' ];
    ?>

    <!-- SLIDER PREVIEW -->
    <h3 class="actus-aaws-preview-title">SLIDER PREVIEW</h3>
    <div id='actus-aaws-preview'></div>


    <!-- SLIDER FLOW -->
    <h3 class="actus-aaws-slider-flow-title">SLIDER FLOW</h3>
    <div id='actus-aaws-slider-flow' class='actus-aaws-box-slider-flow-panel'>
        <div style="clear:both"></div>
    </div>


    <!-- SLIDER OPTIONS -->
    <h3 class="actus-aaws-slider-options-title">SLIDER OPTIONS</h3>
    <div class='actus-aaws-box-slider-options'>
        
        <div class='actus-aaws-option-box actus-sixth'>
            <input class="actus-aaws-height" 
                   alt="height"
                   name="actus_aaws_height"
                   type="number"
                   value="<?php echo $actus_aaws_slider_options['height'] ?>">
            <p>height</p>
        </div>
        
        <div class='actus-aaws-option-box actus-sixth <?php echo $clss; ?>'>
            <input class="actus-aaws-transition"
                   alt="transition"
                   name="actus_aaws_transition"
                   type="number"
                   value="<?php echo $actus_aaws_slider_options['transition'] ?>">
            <p>transition time</p>
        </div>
        
        
        
        <div class='actus-aaws-option-box actus-sixth <?php echo $clss; ?>'>
            <input class="actus-aaws-slide-time"
                   alt="slide_time"
                   name="actus_aaws_slide_time"
                   type="number"
                   value="<?php echo $actus_aaws_slider_options['slide_time'] ?>">
            <p>slide time</p>
        </div>
        
        <?php
        $chkbx = ACTUS_AAWS_URL . 'img/checkbox1.png';
        if ( $actus_aaws_slider_options['imageZoom'] == 1 ) {
            $chkbx = ACTUS_AAWS_URL . 'img/checkbox2.png';
        } ?>
        <div class='actus-aaws-option-box actus-sixth  actus-aaws-options-toggle'>
            <img src='<?php echo $chkbx; ?>'>
            <input class="actus-aaws-image-zoom"
                   alt="imageZoom"
                   name="actus_aaws_image_zoom" type="hidden"
                   value="<?php echo $actus_aaws_slider_options['imageZoom'] ?>">
            <p>image zoom</p>
        </div>
        
        <?php
        $chkbx = ACTUS_AAWS_URL . 'img/checkbox1.png';
        if ( $actus_aaws_slider_options['imageRot'] == 1 ) {
            $chkbx = ACTUS_AAWS_URL . 'img/checkbox2.png';
        } ?>
        <div class='actus-aaws-option-box actus-sixth  actus-aaws-options-toggle'>
            <img src='<?php echo $chkbx; ?>'>
            <input class="actus-aaws-image-rot"
                   alt="imageRot"
                   name="actus_aaws_image_rot" type="hidden"
                   value="<?php echo $actus_aaws_slider_options['imageRot'] ?>">
            <p>image rotation</p>
        </div>
        
        
        
        
        
        <?php
        $chkbx = ACTUS_AAWS_URL . 'img/checkbox1.png';
        $clss = 'inactive';
        if ( $actus_aaws_slider_options['wordsStatus'] == 1 ) {
            $chkbx = ACTUS_AAWS_URL . 'img/checkbox2.png';
            $clss = '';
        } ?>
        <div class='actus-aaws-option-box actus-sixth last actus-aaws-options-toggle actus-aaws-words-options-toggle'>
            <img src='<?php echo $chkbx; ?>'>
            <input class="actus-aaws-words-status"
                   alt="wordsStatus"
                   name="actus_aaws_words_status" type="hidden"
                   value="<?php echo $actus_aaws_slider_options['wordsStatus'] ?>">
            <p>words</p>
        </div>
        
        
        
        <div style="clear:both"></div>
        
        
        
        <div class='actus-aaws-option-box actus-sixth actus-aaws-words-option <?php echo $clss; ?>'>
            <input class="actus-aaws-max-opacity"
                   alt="max_opacity"
                   name="actus_aaws_max_opacity"
                   min="5" max="100"
                   type="range"
                   value="<?php echo $actus_aaws_slider_options['max_opacity'] ?>">
            <p>opacity</p>
        </div>
        
        <div class='actus-aaws-option-box actus-sixth actus-aaws-words-option <?php echo $clss; ?>'>
            <input class="actus-aaws-speed"
                   alt="speed"
                   name="actus_aaws_speed"
                   min="0.1" max="6" step="0.1";
                   type="range"
                   value="<?php echo $actus_aaws_slider_options['speed'] ?>">
            <p>speed</p>
        </div>
        
        <div class='actus-aaws-option-box actus-sixth actus-aaws-words-option <?php echo $clss; ?>'>
            <input class="actus-aaws-font-size"
                   alt="font_size"
                   name="actus_aaws_font_size"
                   min="0.1" max="3" step="0.1"
                   type="range"
                   value="<?php echo $actus_aaws_slider_options['font_size'] ?>">
            <p>font size</p>
        </div>
        
        
        <div class='actus-aaws-option-box actus-sixth actus-aaws-words-option <?php echo $clss; ?>'>
            <input class="actus-color-pick"
                   spellcheck="false"
                   alt="colorA"
                   name="actus_aaws_colorA"
                   type="text"
                   data-default-color="#ffffff"
                   value="<?php echo $actus_aaws_slider_options['colorA'] ?>">
            <p>color A</p>
        </div>
        
        <div class='actus-aaws-option-box actus-sixth actus-aaws-words-option <?php echo $clss; ?>'>
            <input class="actus-color-pick"
                   spellcheck="false"
                   alt="colorB"
                   name="actus_aaws_colorB"
                   type="text"
                   data-default-color="#000000"
                   value="<?php echo $actus_aaws_slider_options['colorB'] ?>">
            <p>color B</p>
        </div>
        
        <div class='actus-aaws-option-box actus-sixth last actus-aaws-words-option <?php echo $clss; ?>'>
            <input class="actus-aaws-density"
                   alt="density"
                   name="actus_aaws_density"
                   type="number"
                   value="<?php echo $actus_aaws_slider_options['density'] ?>">
            <p>density</p>
        </div>
        
        
        
        
        <div style="clear:both"></div>
        
        
        
        <div class='actus-aaws-option-box actus-half actus-aaws-words-option'>
     
        </div>
        
        <div class='actus-aaws-option-box actus-half last actus-aaws-words-option'>
            <input class="actus-aaws-font" 
                   alt="height"
                   name="actus_aaws_font"
                   type="text"
                   value="<?php echo $actus_aaws_slider_options['font'] ?>">
            <p>font</p>
        </div>
        
        
        
        
        <div style="clear:both"></div>
        
    </div>


    <!-- IMAGES -->
    <h3 class="actus-aaws-images-frame-title">SELECT IMAGES</h3>
    <div class='actus-aaws-box-images-frame'>
        
        <!-- ATTACHED IMAGES -->
        <?php
        $clss = '';
        $icn  = 'img/checkbox1.png';
        if ( $actus_aaws_options['imagesPanel1'] == 1 ) {
            $clss = 'active';
            $icn  = 'img/checkbox2white.png';
        } ?>
        <div class='actus-aaws-box-images-panel <?php echo $clss ?>'
             id='imagesPanel1' alt='attached'>
            <div class='actus-aaws-box-images-panel-L'>
                <img src="<?php echo ACTUS_AAWS_URL . $icn; ?>">
                <p>attached images</p>
            </div>
            <div class='actus-aaws-box-images-panel-R'>
                <div id='actus-aaws-images-attached'>
                <?php
                    foreach( $post_images[ 'attached' ] as $image ) {
                        $clss = '';
                        if ( $image[ 'status' ] == 0 ) {
                            $clss = 'inactive';
                        }
                        echo "<div class='actus-aaws-thumb $clss' ".
                                  "data-id='" . $image[ 'id' ] . "' ".
                                  "data-idx='" . $image[ 'idx' ] . "' ".
                                  "data-status='" . $image[ 'status' ] . "' ".
                                  "data-url='" . $image[ 'url' ] . "'>";
                        echo    "<img src='" . $image[ 'url' ] . "'>";
                        echo "</div>";
                    }
                    foreach( $post_images[ 'uploaded' ] as $image ) {
                        $clss = '';
                        if ( $image[ 'status' ] == 0 ) {
                            $clss = 'inactive';
                        }
                        echo "<div class='actus-aaws-thumb $clss' ".
                                  "data-id='" . $image[ 'id' ] . "' ".
                                  "data-idx='" . $image[ 'idx' ] . "' ".
                                  "data-status='" . $image[ 'status' ] . "' ".
                                  "data-url='" . $image[ 'url' ] . "'>";
                        echo    "<img src='" . $image[ 'url' ] . "'>";
                        echo "</div>";
                    }
                ?>                   
                    <div class="actus-aaws-add-image">
                        <span class="dashicons dashicons-plus"></span>
                        <p>ADD IMAGE</p>
                    </div>
                    <div style="clear:both"></div>
                </div>
                
            </div>
            <div style="clear:both"></div>
        </div>
        
        <!-- POST CONTENT IMAGES -->
        <?php

        $clss = '';
        $icn  = 'img/checkbox1.png';
        if ( $actus_aaws_options['imagesPanel2'] == 1 ) {
            $clss = 'active';
            $icn  = 'img/checkbox2white.png';
        } ?>
        <div class='actus-aaws-box-images-panel <?php echo $clss ?>'
             id='imagesPanel2' alt='content'>
            <div class='actus-aaws-box-images-panel-L'>
                <img src="<?php echo ACTUS_AAWS_URL . $icn; ?>">
                <p>content images</p>
            </div>
            <div class='actus-aaws-box-images-panel-R'>
                <div id='actus-aaws-images-content'>
                <?php
                    foreach( $post_images[ 'content' ] as $image ) {
                        $clss = '';
                        if ( $image[ 'status' ] == 0 ) {
                            $clss = 'inactive';
                        }
                        echo "<div class='actus-aaws-thumb $clss' ".
                                  "data-id='" . $image[ 'id' ] . "' ".
                                  "data-idx='" . $image[ 'idx' ] . "' ".
                                  "data-status='" . $image[ 'status' ] . "' ".
                                  "data-url='" . $image[ 'url' ] . "'>";
                        echo    "<img src='" . $image[ 'url' ] . "'>";
                        echo "</div>";
                    }
                    echo '<div style="clear:both"></div>';
                ?>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
        
        <!-- GALLERIES IMAGES -->
        <?php
        $clss = '';
        $icn  = 'img/checkbox1.png';
        if ( $actus_aaws_options['imagesPanel3'] == 1 ) {
            $clss = 'active';
            $icn  = 'img/checkbox2white.png';
        } ?>
        <div class='actus-aaws-box-images-panel <?php echo $clss ?>'
             id='imagesPanel3' alt='galleries'>
            <div class='actus-aaws-box-images-panel-L'>
                <img src="<?php echo ACTUS_AAWS_URL . $icn; ?>">
                <p>from galleries</p>
            </div>
            <div class='actus-aaws-box-images-panel-R'>
                <div id='actus-aaws-images-galleries'>
                <?php
                    foreach( $post_images[ 'galleries' ] as $image ) {
                        $clss = '';
                        if ( $image[ 'status' ] == 0 ) {
                            $clss = 'inactive';
                        }
                        echo "<div class='actus-aaws-thumb $clss' ".
                                  "data-id='" . $image[ 'id' ] . "' ".
                                  "data-idx='" . $image[ 'idx' ] . "' ".
                                  "data-status='" . $image[ 'status' ] . "' ".
                                  "data-url='" . $image[ 'url' ] . "'>";
                        echo    "<img src='" . $image[ 'url' ] . "'>";
                        echo "</div>";
                    }
                    echo '<div style="clear:both"></div>';
                ?>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
        
    </div> <!-- actus-aaws-box-images-frame -->
        

    <!-- WORDS -->
    <h3 class="actus-aaws-words-frame-title">WORDS TO BE ANIMATED</h3>
    <div class='actus-aaws-box-words-frame'>
        
        
        <!-- POST CONTENT -->
        <?php
        $clss = '';
        $icn  = 'img/checkbox1.png';
        if ( $actus_aaws_options['wordsPanel1'] == 1 ) {
            $clss = 'active';
            $icn  = 'img/checkbox2white.png';
        } ?>
        <div class='actus-aaws-box-words-panel <?php echo $clss ?>' id='wordsPanel1'>
            <div class='actus-aaws-box-words-panel-L'>
                <img src="<?php echo ACTUS_AAWS_URL . $icn; ?>">
                <p>post content</p>
                <span class="dashicons dashicons-admin-generic actus-aaws-post-words-settings-button"></span>
            </div>
            <div class='actus-aaws-box-words-panel-R'>
                <div id='actus-aaws-post-words'></div>
            </div>
            <div class='actus-aaws-box-words-panel-R actus-aaws-post-words-settings-frame'>
                <p>minimum<br>characters</p>
                <input type="number" id="actus-aaws-input-min-chars" value="<?php echo $actus_aaws_options['minChars'] ?>">
                <p>minimum<br>times used</p>
                <input type="number" id="actus-aaws-input-min-used" value="<?php echo $actus_aaws_options['minUsed'] ?>">
                <img class='actus-aaws-select-toggle' alt='1'
                     src="<?php echo ACTUS_AAWS_URL . 'img/checkbox2white.png'; ?>">
                <p class='actus-aaws-select-toggle' alt='0'>select/deselect all</p>
                <div style="clear:both"></div>
            </div>
            <div style="clear:both"></div>
        </div>
        
        
        <!-- POST TAGS -->
        <?php
        $clss = '';
        $icn  = 'img/checkbox1.png';
        if ( $actus_aaws_options['wordsPanel2'] == 1 ) {
            $clss = 'active';
            $icn  = 'img/checkbox2white.png';
        } ?>
        <div class='actus-aaws-box-words-panel <?php echo $clss ?>' id='wordsPanel2'>
            <div class='actus-aaws-box-words-panel-L'>
                <img src="<?php echo ACTUS_AAWS_URL . $icn; ?>">
                <p>post tags</p>
            </div>
            <div class='actus-aaws-box-words-panel-R'>
                <div id='actus-aaws-tags'></div>
            </div>
            <div style="clear:both"></div>
        </div>
        
        
        <!-- OTHER WORDS -->
        <?php
        $clss = '';
        $dis  = 'disabled';
        $icn  = 'img/checkbox1.png';
        if ( $actus_aaws_options['wordsPanel3'] == 1 ) {
            $clss = 'active';
            $dis  = '';
            $icn  = 'img/checkbox2white.png';
        } ?>
        <div class='actus-aaws-box-words-panel <?php echo $clss ?>' id='wordsPanel3'>
            <div class='actus-aaws-box-words-panel-L'>
                <img src="<?php echo ACTUS_AAWS_URL . $icn; ?>">
                <p>other words</p>
            </div>
            <div class='actus-aaws-box-words-panel-R'>
                <div class='actus-aaws-other-words-frame'></div>
                <div class='actus-aaws-add-words-box'>
                    <input type="text" <?php echo $dis ?>
                           placeholder="type words or phrases (comma seperated)"
                           id="actus-aaws-add-words-input"
                           name="actus-aaws-other-words">
                    <span class="dashicons dashicons-plus"></span>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>

        
        <!-- CUSTOM FIELDS -->
        <input type="hidden" 
               id="actus_aaws_options"
               name="actus_aaws_options"
               value=""/>
        <input type="hidden" 
               id="actus_aaws_slider_options"
               name="actus_aaws_slider_options"
               value=""/>
 
    </div>

    <!-- ALL WORDS -->
    <div id='actus-aaws-all-words' class='actus-aaws-box-words-panel'>
        <div style="clear:both"></div>
    </div>
        


    <!-- FOOTER -->
    <div class="actus-admin-footer">
        <div class="actus">created by <a href="http://wp.actus.works" target="_blank">ACTUS anima</a></div>
        <div class="actus-sic">code &amp; design:  <a href="mailto:sic@actus.works" target="_blank">Stelios Ignatiadis</a></div>
    </div>


    <?php
}




/**
 * Create Save nonce
 */
add_action( 'post_submitbox_start', 'actus_aaws_save_nonce_create' );
function actus_aaws_save_nonce_create() {
    wp_nonce_field( 'actus_aaws_save_nonce', 'actus_aaws_save_nonce' );
}


/**
 * Save
 *
 * Save slider options during post or page save.
 *
 * @variable string  $post_id   The id of the current post or page.
 *
 * @global    int    $post      The current post.
 */
add_action( 'save_post', 'actus_aaws_save' );
function actus_aaws_save() {
    global $post;
    $post_id = $post->ID;
    
    /*
    // Authorization Check
    if ( empty( $post ) || empty( $post_id ) || empty( $_POST ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( is_int( wp_is_post_revision( $post ) ) ) return;
    if ( is_int( wp_is_post_autosave( $post ) ) ) return;
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }
    */
    
    // Check if our nonce is set.
    if ( isset( $_POST['actus_aaws_save_nonce'] ) ) {
        // Verify that the nonce is valid.
        if ( wp_verify_nonce( $_POST['actus_aaws_save_nonce'], 'actus_aaws_save_nonce' ) ) {
            
            // SAVE options (actus_aaws_options)
            if ( isset( $_POST['actus_aaws_options'] ) ) {
                $data = sanitize_text_field( $_POST['actus_aaws_options'] );
                update_post_meta( $post_id, 'actus_aaws_options', $data );
            }
            // SAVE slide options (actus_aaws_slider_options)
            if ( isset( $_POST['actus_aaws_slider_options'] ) ) {
                $data = sanitize_text_field( $_POST['actus_aaws_slider_options'] );
                update_post_meta( $post_id, 'actus_aaws_slider_options', $data );
            }
            
        }
    }
    
    
}

