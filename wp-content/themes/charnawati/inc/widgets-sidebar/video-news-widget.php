<?php
/**
 * Video News Widget Class
 */
if ( ! class_exists( 'video_news' ) ) {
    /**
     * Class for adding widget
     * @since 1.0.0
     */
	class video_news extends WP_Widget {
	  /**
	  * To create the example widget all three methods will be 
	  * nested inside this single instance of the WP_Widget class.
	  **/
		public function __construct() {
			$widget_options = array( 
			  'classname' => 'video_news',
			  'description' => 'This widget display video news!',
			);
			parent::__construct( 'video_news', 'ESN: Video News Widget', $widget_options );
		}
		
		/* widget function displays the widget in the front end */
		public function widget( $args, $instance ) {
			$news_count = ! empty( $instance['news_count'] ) ? $instance['news_count'] : '';
			$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$esn_selected_cat = ! empty( $instance['esn_cat'] ) ? esc_attr( $instance['esn_cat']) : '';   
			if( $esn_selected_cat != -1 ){
	            $sticky = get_option( 'sticky_posts' );
				$esn_cat_post_args = array(
					'posts_per_page'      => $news_count,
					'cat'				  => $esn_selected_cat,
					'no_found_rows'       => true,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
					'post__not_in' => $sticky
				);
			}
			$news_query = new WP_Query($esn_cat_post_args);
			if ($news_query->have_posts()){
				echo $args['before_widget'] . 
					$args['before_title'] .
						'<a class="hvr-shutter-out-horizontal" href="category/'.get_cat_name($esn_selected_cat).'"><img class="title-icon" src="/wp-content/uploads/2019/09/icon.png">'. $title.'</a>'.
					$args['after_title'];
					$count = 0;
					echo '<div class="video-news-wrapper">';
						while ($news_query->have_posts()): $news_query->the_post();
							if (has_post_thumbnail()) {
								$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
							} else {
								$image_url[0] = get_template_directory_uri() . '/assets/img/no-image-660-365.png';
							}
							if( $count == 0 ){
								echo '<div class="video-first-news-wrapper">';
									echo '<div class="video-frist-news-img-wrap">';	
										echo '<a href="'.get_permalink().'">';
											echo '<img src="'.$image_url[0].'"/>';
										echo '</a>';		
									echo '</div>';
									echo '<div class="video-firts-news-title news-title">';
										the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');
									echo '</div>';
								echo '</div>';
								echo '<div class="video-rest-news-wrapper">';
							}else{
								echo '<div class="video-rest-news-main">';
										echo '<div class="video-rest-news-img-wrap">';	
											echo '<a href="'.get_permalink().'">';
												echo '<img src="'.$image_url[0].'"/>';
											echo '</a>';		
										echo '</div>';
										echo '<div class="video-rest-news-title news-title">';
											the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');	
										echo '</div>';
								echo '</div>';			
							}
						$count++;
						endwhile;
								echo '</div>'; // end video-rest-news-wrapper"
					echo '</div>'; // end video-news-wrapper
				echo $args['after_widget'];
			}
		}
		
		/* form function displays the widget in the back end */
		public function form( $instance ) {
			$news_count = ! empty( $instance['news_count'] ) ? $instance['news_count'] : '';
			$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$esn_selected_cat = ! empty( $instance['esn_cat'] ) ? esc_attr( $instance['esn_cat']) : '';	
			?> 
			<p>
				<label for="<?php echo $this->get_field_id( 'news_count' ); ?>">News Count:</label>
				<input type="number" id="<?php echo $this->get_field_id( 'news_count' ); ?>" name="<?php echo $this->get_field_name( 'news_count' ); ?>" value="<?php echo esc_attr( $news_count ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
				<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('esn_cat'); ?>"><?php _e('Select Category', 'esn'); ?></label>
				<?php
				$esn_dropown_cat = array(
					'show_option_none'   => __('From Recent Posts','esn'),
					'orderby'            => 'name',
					'order'              => 'asc',
					'show_count'         => 1,
					'hide_empty'         => 1,
					'echo'               => 1,
					'selected'           => $esn_selected_cat,
					'hierarchical'       => 1,
					'name'               => $this->get_field_name('esn_cat'),
					'id'                 => $this->get_field_name('esn_cat'),
					'class'              => 'widefat',
					'taxonomy'           => 'category',
					'hide_if_empty'      => false,
				);
				wp_dropdown_categories($esn_dropown_cat);
				?>
			</p>
			<?php 
		}
		
		public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['news_count'] = ( isset( $new_instance['news_count'] ) ) ? $new_instance['news_count'] : '';
            $instance['title'] = ( isset( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
            $instance['esn_cat'] = ( isset( $new_instance['esn_cat'] ) ) ? esc_attr( $new_instance['esn_cat'] ) : '';

            return $instance;
        }
	
	  
	} // class video_news ends here
}

if ( ! function_exists( 'video_news' ) ) :
    /**
     * Function to Register and load the widget
     *
     * @since 1.0.0
     *
     * @param null
     * @return void
     *
     */
    function video_news() {
        register_widget( 'video_news' );
    }
endif;
add_action( 'widgets_init', 'video_news' );

