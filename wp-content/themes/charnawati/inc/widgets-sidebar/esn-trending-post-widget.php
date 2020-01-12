<?php
/**
 * Recent Post News Widget Class
 */
if ( ! class_exists( 'esn_trending_posts_widget' ) ) {
    /**
     * Class for adding widget
     * @since 1.0.0
     */
	class esn_trending_posts_widget extends WP_Widget {
	  /**
	  * To create the example widget all four methods will be 
	  * nested inside this single instance of the WP_Widget class.
	  **/
		public function __construct() {
			$widget_options = array( 
			  'classname' => 'esn_trending_posts_widget',
			  'description' => 'This widget display news of trending post in side bar!',
			);
			parent::__construct( 'esn_trending_posts_widget', 'ESN: Trending Post News Widget', $widget_options );
		}
		
		/* widget function displays the widget in the front end */
		public function widget( $args, $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : ''; //for title
			$num_post = ! empty( $instance['num_post'] ) ? $instance['num_post'] : ''; //for num_post
		  	$sticky = get_option( 'sticky_posts' );
			
			$popularpost = new WP_Query( array( 
				'posts_per_page' => $num_posts,
				'meta_key' => 'esn_post_views_count',
				'orderby' => 'meta_value_num',
				'order' => 'DESC' 
				)
			 );
			echo '<div class="trending-news-wrapper">';
				$news_query = new WP_Query($popularpost);
				if ($news_query->have_posts()){
					echo $args['before_widget'] . 
						$args['before_title'] .
							'<a class="hvr-shutter-out-horizontal" href="category/'.get_cat_name($esn_selected_cat).'"><img class="title-icon" src="http://dial100.test/wp-content/uploads/2019/09/icon.png">'. $title.'</a>'.
						$args['after_title'];
					echo '<div class="recent-news-section">';					
						while ( $popularpost->have_posts() ) : $popularpost->the_post();	
							echo '<div class="side-section-news">';						
								the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');
							echo '</div>';
						endwhile;
					echo '</div>'; // end of recent-news-section			
					wp_reset_postdata();
					echo $args['after_widget'];
				}
			echo '</div>'; // end of trending-news-wrapper
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
	
	  
	} // class esn_trending_posts_widget ends here
}

if ( ! function_exists( 'esn_trending_posts_widget' ) ) :
    /**
     * Function to Register and load the widget
     *
     * @since 1.0.0
     *
     * @param null
     * @return void
     *
     */
    function esn_trending_posts_widget() {
        register_widget( 'esn_trending_posts_widget' );
    }
endif;
add_action( 'widgets_init', 'esn_trending_posts_widget' );

