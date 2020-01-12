<?php
/**
 * Return content of fixed lenth
 *
 * @since 1.0.0
 *
 * @param string $esn_content
 * @param int $length
 * @return string
 *
 */
if ( ! function_exists( 'esn_words_count' ) ) :
    function esn_words_count( $esn_content = null, $length = 16 ) {
        $length = absint( $length );
        $source_content = preg_replace( '`\[[^\]]*\]`', '', $esn_content );
        $trimmed_content = wp_trim_words( $source_content, $length, '...' );
        return $trimmed_content;
    }
endif;

/**
 * Function FOR Counting Post
 *
 * @since 1.0.0
 *
 * @param string $postID
 */
function esn_set_post_views($postID) {
    $count_key = 'esn_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function esn_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    esn_set_post_views($post_id);
}
add_action( 'wp_head', 'esn_track_post_views');

/*
 * FUNCTION FOR FACEBOOK COMMENTS PLUGIN
 *
 */

if ( !function_exists('fb_comment_post_below') ) :
	function fb_comment_post_below () { ?>
		<h2 class="widget-title"><a class="hvr-shutter-out-horizontal">प्रतिक्रिया दिनुहोस्</a></h2>
		<div id="fb-root"></div>
		<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v4.0"></script>

		<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="5"></div>
	<?php 
	}
endif;

add_action( 'show_fb_comment_box', 'fb_comment_post_below');