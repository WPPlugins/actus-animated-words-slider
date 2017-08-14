<?php
/**
 * ACTUS Animated Words Functions
 *
 * @package    Actus_Animated_Words_Slider
 */



/**
 * Counting Words in Text.
 *
 * Counts how many times each word is used in a text.
 *
 * @variable  array   $words_used_temp      Temporary holds words data.
 * @variable  array   $words_array          Temporary holds words data.
 *
 * @parameter string  $text                 The input text.
 * @parameter int     $min_chars            The minimum characters a word should have.
 * @parameter int     $min_used             The minimum times a word should be used in text.
 *
 * @global    array  $actus_excluded_words  Words that will be excluded from words selection.
 * @global    string $actus_symbols         Symbols that will be excluded from words selection.
 *
 * @return array      $words_used           Array contains the result words and the times each one
 *                                          is used in the source text.
 */
if ( ! function_exists( 'actus_words_count' ) ) {
    function actus_words_count( $text = "", $min_chars = 3 , $min_used = 3 ) {
        global $actus_symbols, $actus_excluded_words;
        $min_chars = intval( $min_chars );
        $min_used  = intval( $min_used );
        if ( $min_chars < 2 ) {
            $min_chars = 2;
        }
        // text to lowercase
        $text    = strtolower( $text );
        // remove symbols
        $text    = str_replace( $actus_symbols, " ", $text );
        
        $words_used      = array();
        $words_used_temp = array();
        $words_array     = explode(" ", $text);
        // count words
        foreach ( $words_array as $word ) {
            $word = trim( $word );
            if ( ! in_array( $word, $actus_excluded_words ) && strlen( $word ) >= $min_chars ) {
                if ( ! $words_used_temp[ $word ] ) {
                    $words_used_temp[ $word ] = 0;
                }
                $words_used_temp[ $word ]++;
            }
        }
        // select only words that are above the limit (of times used)
        foreach ( $words_used_temp as $word => $cnt ) {
            if ( $cnt >= $min_used ) {
                $words_used[ $word ] = $cnt;
            }
        }
        // sort array by times used
        arsort( $words_used );
        
        // return array
        return $words_used;
    }
}




/**
 * Get image id
 *
 * Takes an image url and returns its id in the media database.
 *
 * @parameter string  $image_url      The image url.
 *
 * @return    int     $attachment[0]  The image id.
 */
if ( ! function_exists( 'actus_get_image_id' ) ) {
    function actus_get_image_id( $image_url ) {
        global $wpdb;
        
        $attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );
        
        return $attachment[0]; 
    }
}




/**
 * Get post images
 *
 * Extracts all images used in a post.
 *
 * @variable  array  $existing_ids               Ids of images that are already saved.
 * @variable  int    $thumb_id                   The post thumbnail id.
 * @variable  string $current_content            The post content.
 * @variable  array  $matches                    Images found in content.
 * @variable  array  $galleries                  The post galleries.
 * @variable  string $img_type_name              Temporary values.
 * @variable  array  $img_type                   Temporary values.
 * @variable  array  $gallery                    Temporary values.
 * @variable  array  $img                        Temporary values.
 * @variable  array  $tmp                        Temporary values.
 * @variable  array  $tid                        Temporary values.
 * @variable  array  $ids                        Temporary values.
 * @variable  int    $idx                        Temporary values.
 * @variable  string $regex                      Temporary values.
 * @variable  string $prefix                     Temporary values.
 * @variable  array  $image                      Temporary values.
 * @variable  array  $i                          Temporary values.
 *
 * @global    array  $actus_aaws_options         The slider administgration options.
 * @global    array  $actus_aaws_slider_options  The options for the slider animation.
 *
 * @parameter int     $post_id                   The post or page id.
 *
 * @return    array   $post_images               All images used in the post or page.
 */
if ( ! function_exists( 'actus_get_post_images' ) ) {
    function actus_get_post_images( $post_id ) {
        global $actus_aaws_options, $actus_aaws_slider_options;

        
        // Get ids from saved data
        $existing_ids = array();
        foreach( $actus_aaws_options[ 'images' ] as $img_type_name => $img_type ) {
            foreach( $img_type as $img ) {
                $existing_ids[ $img_type_name ][] = $img[ 'id' ];
            }
        }
        
        // Get featured image
        $thumb_id = get_post_thumbnail_id( $post_id );
        if ( $thumb_id != null ) {
            $tmp = wp_get_attachment_image_src( $thumb_id, 'full' );
            if ( $tmp[0] != null ) {
            if ( ! in_array( $thumb_id, $existing_ids[ 'attached' ] ) ) {
                $actus_aaws_options[ 'images' ][ 'attached' ][ 0 ][ 'id' ]  = $thumb_id;
                $actus_aaws_options[ 'images' ][ 'attached' ][ 0 ][ 'idx' ] = 0;
                $actus_aaws_options[ 'images' ][ 'attached' ][ 0 ][ 'url' ] = $tmp[0];
                $actus_aaws_options[ 'images' ][ 'attached' ][ 0 ][ 'status' ] = 2;
            }
            }
        }

        // Get images from post content
        $current_content = get_post_field( 'post_content', $post_id );
        $regex = '/src="([^"]*)"/';
        preg_match_all( $regex, $current_content, $matches );
        $i = sizeof( $actus_aaws_options[ 'images' ][ 'content' ] );
        foreach ( $matches[0] as $image ) {
            if ( $image != null ) {
                $prefix = 'src="';
                $image = preg_replace('/^' . preg_quote($prefix, '/') . '/', '', $image);
                $image = preg_replace('/"$/', '', $image);
                $image = preg_replace('/-\d+[Xx]\d+\./', '.', $image);
                $tid = actus_get_image_id( $image );
            if ( ! in_array( $tid, $existing_ids[ 'content' ] ) ) {
                $actus_aaws_options[ 'images' ][ 'content' ][ $i ][ 'id' ]  = $tid;
                $actus_aaws_options[ 'images' ][ 'content' ][ $i ][ 'idx' ] = $i;
                $actus_aaws_options[ 'images' ][ 'content' ][ $i ][ 'url' ] = $image;
                $actus_aaws_options[ 'images' ][ 'content' ][ $i ][ 'status' ] = 2;
                $existing_ids[ 'content' ][] = $tid;
                $i++;
            }
            }
        }
        
        // Get images from galleries
        $galleries = get_post_galleries( $post_id, false );
        foreach ( $galleries as $idx => $gallery ) {
            $ids = explode( ",", $gallery[ 'ids' ] );
            $i = sizeof( $actus_aaws_options[ 'images' ][ 'galleries' ] );
            foreach ( $ids as $id ) {
                if ( wp_get_attachment_url( $id ) != null ) {
                if ( ! in_array( $tid, $existing_ids[ 'galleries' ] ) ) {
                    $actus_aaws_options[ 'images' ][ 'galleries' ][ $i ][ 'id' ]  = $id;
                    $actus_aaws_options[ 'images' ][ 'galleries' ][ $i ][ 'idx' ] = $i;
                    $actus_aaws_options[ 'images' ][ 'galleries' ][ $i ][ 'url' ] = wp_get_attachment_url( $id );
                    $actus_aaws_options[ 'images' ][ 'galleries' ][ $i ][ 'status' ] = 2;
                    $i++;
                }
                }
            }
        }

        // set and return array
        $post_images = array();
        $post_images[ 'attached' ]  = $actus_aaws_options[ 'images' ][ 'attached' ];
        $post_images[ 'content' ]   = $actus_aaws_options[ 'images' ][ 'content' ];
        $post_images[ 'galleries' ] = $actus_aaws_options[ 'images' ][ 'galleries' ];
        $post_images[ 'uploaded' ]  = $actus_aaws_options[ 'images' ][ 'uploaded' ];
        
        return $post_images;
        
    }
}
    

?>