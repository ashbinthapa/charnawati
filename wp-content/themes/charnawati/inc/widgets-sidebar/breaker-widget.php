<?php
/**
 * BREAKER NEWS WIDGET CLASS
 */
if ( ! class_exists( 'esn_breaker_news' ) ) {
    /**
     * Class for adding widget
     * @since 1.0.0
     */
	class esn_breaker_news extends WP_Widget {
	  /**
	  * To create the example widget all four methods will be 
	  * nested inside this single instance of the WP_Widget class.
	  **/
		public function __construct() {
			$widget_options = array( 
			  'classname' => 'esn_breaker_news',
			  'description' => 'This widget display the news from breaker section!',
			);
			parent::__construct( 'esn_breaker_news', 'ESN: Breaker News Widget', $widget_options );
		}
		
		/* widget function displays the widget in the front end */
		public function widget( $args, $instance ) {
			echo $args['before_widget'];
			$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$news_count = ! empty( $instance['news_count'] ) ? $instance['news_count'] : '';
			$esn_selected_cat = ! empty( $instance['esn_cat'] ) ? esc_attr( $instance['esn_cat']) : '';
			$hide_image = ! empty( $instance['hide_image'] ) ? $instance['hide_image'] : '';
			$hide_highlight = ! empty( $instance['hide_highlight'] ) ? $instance['hide_highlight'] : '';

		  
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
				echo '<div class="home_breaker_news">';
				while ($news_query->have_posts()): $news_query->the_post();
					if($hide_image == ''):
						if (has_post_thumbnail()) {
							$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
						} else {
							$image_url[0] = get_template_directory_uri() . '/assets/img/no-image-660-365.png';
						}
					endif;
					if($hide_highlight == '') :
						echo '<div class="news-highlight">
								<span>'.$title.'</span>
							</div>';
					endif;
					echo '<div class="news-section">';
						if($hide_image == ''):		
							echo '<div class="img-wrap">	
									<a href="'.get_permalink().'">
										<img src="'.$image_url[0].'"/>
									</a>			
							</div>';
						endif;
						echo '<div class="title-content-wrap">';			
							echo '<div class="news-title">';							
										the_title('<h4 class="title-big"><a href="'.get_permalink().'">','</a></h4>');			
							echo '</div>';
							$content = esn_words_count( get_the_excerpt() ,30);
							echo '<div class="breaker-news-summary">
									<a href="'.get_permalink().'">
										<p>'.esc_html( $content ).'</p>
									</a>
							</div>';
						echo '</div>'; // end of title-content-wrap
					echo '</div>'; // end of new section
				endwhile;
				echo '</div>'; // end of home_breaker_news			
				wp_reset_postdata();
			}
			echo $args['after_widget'];
		}
		
		/* form function displays the widget in the back end */
		public function form( $instance ) {			
			$title = ! empty( $instance['title'] ) ? $instance['title'] : ''; //for title
			$news_count = ! empty( $instance['news_count'] ) ? $instance['news_count'] : ''; //for title
			$esn_selected_cat = ! empty( $instance['esn_cat'] ) ? esc_attr( $instance['esn_cat']) : '';
			$hide_image = ! empty( $instance['hide_image'] ) ? $instance['hide_image'] : '';
			$hide_highlight = ! empty( $instance['hide_highlight'] ) ? $instance['hide_highlight'] : '';
			?>
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
			<p>
				<label for="<?php echo $this->get_field_id( 'news_count' ); ?>">Count:</label>
				<input type="number" id="<?php echo $this->get_field_id( 'news_count' ); ?>" name="<?php echo $this->get_field_name( 'news_count' ); ?>" value="<?php echo esc_attr( $news_count ); ?>" />
			</p>
			<p> 
			    <label for="<?php echo $this->get_field_id( 'hide_image' ); ?>">Hide Image</label>
			    <input class="checkbox" type="checkbox" <?php checked( $instance[ 'hide_image' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'hide_image' ); ?>" name="<?php echo $this->get_field_name( 'hide_image' ); ?>" />
			</p>
			<p> 
			    <label for="<?php echo $this->get_field_id( 'hide_highlight' ); ?>">Hide Breaker Title</label>
			    <input class="checkbox" type="checkbox" <?php checked( $instance[ 'hide_highlight' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'hide_highlight' ); ?>" name="<?php echo $this->get_field_name( 'hide_highlight' ); ?>" />
			</p>
			<?php 
		}
		
		public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = ( isset( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
            $instance['news_count'] = ( isset( $new_instance['news_count'] ) ) ? $new_instance['news_count'] : '';
            $instance['esn_cat'] = ( isset( $new_instance['esn_cat'] ) ) ? esc_attr( $new_instance['esn_cat'] ) : '';
			$instance['hide_image'] = ! empty( $new_instance['hide_image'] ) ? $new_instance['hide_image'] : '';
			$instance['hide_highlight'] = ! empty( $new_instance['hide_highlight'] ) ? $new_instance['hide_highlight'] : '';

            return $instance;
        }
	
	  
	} // class esn_breaker_news ends here
}

if ( ! function_exists( 'esn_breaker_news' ) ) :
    /**
     * Function to Register and load the widget
     *
     * @since 1.0.0
     *
     * @param null
     * @return void
     *
     */
    function esn_breaker_news() {
        register_widget( 'esn_breaker_news' );
    }
endif;
add_action( 'widgets_init', 'esn_breaker_news' );