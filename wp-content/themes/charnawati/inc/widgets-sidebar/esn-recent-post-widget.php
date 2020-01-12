<?php
/**
 * Recent Post News Widget Class
 */
if ( ! class_exists( 'esn_recentpost_widget' ) ) {
    /**
     * Class for adding widget
     * @since 1.0.0
     */
	class esn_recentpost_widget extends WP_Widget {
	  /**
	  * To create the example widget all four methods will be 
	  * nested inside this single instance of the WP_Widget class.
	  **/
		public function __construct() {
			$widget_options = array( 
			  'classname' => 'esn_recentpost_widget',
			  'description' => 'This widget display news of recent post in side bar!',
			);
			parent::__construct( 'esn_recentpost_widget', 'ESN: Recent Post News Widget', $widget_options );
		}
		
		/* widget function displays the widget in the front end */
		public function widget( $args, $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : ''; //for title
			$num_post = ! empty( $instance['num_post'] ) ? $instance['num_post'] : ''; //for num_post
		  
			$sticky = get_option( 'sticky_posts' );
			$esn_cat_post_args = array(
				'posts_per_page'      => $num_post,
				'no_found_rows'       => true,
				'order' => 'ASC',
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'post__not_in' => $sticky
			);		
			echo '<div class="recent-news-wrapper">';
				$news_query = new WP_Query($esn_cat_post_args);
				if ($news_query->have_posts()){
					$count_number = 1;
					echo $args['before_widget'] . 
						$args['before_title'] .
							'<a class="hvr-shutter-out-horizontal" href="category/'.get_cat_name($esn_selected_cat).'"><img class="title-icon" src="http://dial100.test/wp-content/uploads/2019/09/icon.png">'. $title.'</a>'.
						$args['after_title'];
					echo '<div class="recent-news-section">';					
						while ($news_query->have_posts()): $news_query->the_post();	
							echo '<div class="side-section-news">';						
								the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');
							echo '</div>';
							$count_number++;
						endwhile;
					echo '</div>'; // end of recent-news-section			
					wp_reset_postdata();
					echo $args['after_widget'];
				}
			echo '</div>'; // end of recent-news-wrapper
		}
		
		/* form function displays the widget in the back end */
		public function form( $instance ) {			
			$title = ! empty( $instance['title'] ) ? $instance['title'] : ''; //for title
			$num_post = ! empty( $instance['num_post'] ) ? $instance['num_post'] : ''; //for num_post
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title for recent post:</label>
				<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
			</p>	
				<p>
				<label for="<?php echo $this->get_field_id( 'num_post' ); ?>">Enter the Number of posts :</label>
				<input type="text" id="<?php echo $this->get_field_id( 'num_post' ); ?>" name="<?php echo $this->get_field_name( 'num_post' ); ?>" value="<?php echo esc_attr( $num_post); ?>" />
			</p>
			<?php 
		}
		
		public function update( $new_instance, $old_instance ) {
             $instance = $old_instance;
          	$instance['title'] = ( isset( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
            $instance['num_post'] = ( isset( $new_instance['num_post'] ) ) ? esc_attr( $new_instance['num_post'] ) : '';

            return $instance;
        }
	
	  
	} // class esn_recentpost_widget ends here
}

if ( ! function_exists( 'esn_recentpost_widget' ) ) :
    /**
     * Function to Register and load the widget
     *
     * @since 1.0.0
     *
     * @param null
     * @return void
     *
     */
    function esn_recentpost_widget() {
        register_widget( 'esn_recentpost_widget' );
    }
endif;
add_action( 'widgets_init', 'esn_recentpost_widget' );

