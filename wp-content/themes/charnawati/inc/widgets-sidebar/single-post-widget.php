<?php
/**
 * BREAKER NEWS WIDGET CLASS
 */
if ( ! class_exists( 'esn_single_post_widget' ) ) {
    /**
     * Class for adding widget
     * @since 1.0.0
     */
	class esn_single_post_widget extends WP_Widget {
	  /**
	  * To create the example widget all four methods will be 
	  * nested inside this single instance of the WP_Widget class.
	  **/
		public function __construct() {
			$widget_options = array( 
			  'classname' => 'esn_single_post_widget',
			  'description' => 'This widget display the single news!',
			);
			parent::__construct( 'esn_single_post_widget', 'ESN: Single Post News Widget', $widget_options );
		}
		
		/* widget function displays the widget in the front end */
		public function widget( $args, $instance ) {
			echo $args['before_widget'];
			$esn_selected_cat = ! empty( $instance['esn_cat'] ) ? esc_attr( $instance['esn_cat']) : '';

		  
			if( $esn_selected_cat != -1 ){
	            $sticky = get_option( 'sticky_posts' );
				$esn_cat_post_args = array(
					'posts_per_page'      => 1,
					'cat'				  => $esn_selected_cat,
					'no_found_rows'       => true,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
					'post__not_in' => $sticky
				);
			}						
			$news_query = new WP_Query($esn_cat_post_args);
			if ($news_query->have_posts()){
				echo '<div class="home_single_post_news">';
				while ($news_query->have_posts()): $news_query->the_post();
					if (has_post_thumbnail()) {
						$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
					} else {
						$image_url[0] = get_template_directory_uri() . '/assets/img/no-image-660-365.png';
					}
					echo '<div class="single-news-section">';
						echo '<div class="single-title-content-wrap">';			
							echo '<div class="news-title">';							
								the_title('<h4 class="title-big"><a href="'.get_permalink().'">','</a></h4>');		
							echo '</div>';
							$content = esn_words_count( get_the_excerpt() ,30);
							echo '<div class="single-post-news-summary">
									<a href="'.get_permalink().'">
										<p>'.esc_html( $content ).'</p>
									</a>
							</div>';
							echo '<div class="button-wrapper">
								<button type="button">पुरा पढ्नुहोस</button>
								</div>';
						echo '</div>'; // end of title-content-wrap
						echo '<div class="img-wrap">	
							<a href="'.get_permalink().'">
							<img src="'.$image_url[0].'"/>
							</a>			
							</div>';
					echo '</div>'; // end of new section
				endwhile;
				echo '</div>'; // end of home_single_post_news			
				wp_reset_postdata();
			}
			echo $args['after_widget'];
		}
		
		/* form function displays the widget in the back end */
		public function form( $instance ) {
			$esn_selected_cat = ! empty( $instance['esn_cat'] ) ? esc_attr( $instance['esn_cat']) : '';
			?>
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
            $instance['esn_cat'] = ( isset( $new_instance['esn_cat'] ) ) ? esc_attr( $new_instance['esn_cat'] ) : '';

            return $instance;
        }
	
	  
	} // class esn_single_post_widget ends here
}

if ( ! function_exists( 'esn_single_post_widget' ) ) :
    /**
     * Function to Register and load the widget
     *
     * @since 1.0.0
     *
     * @param null
     * @return void
     *
     */
    function esn_single_post_widget() {
        register_widget( 'esn_single_post_widget' );
    }
endif;
add_action( 'widgets_init', 'esn_single_post_widget' );

