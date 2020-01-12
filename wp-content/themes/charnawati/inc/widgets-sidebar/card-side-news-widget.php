<?php
/**
 * Card & Side News Widget Class
 */
if ( ! class_exists( 'card_side_news' ) ) {
    /**
     * Class for adding widget
     * @since 1.0.0
     */
	class card_side_news extends WP_Widget {
	  /**
	  * To create the example widget all four methods will be 
	  * nested inside this single instance of the WP_Widget class.
	  **/
		public function __construct() {
			$widget_options = array( 
			  'classname' => 'card_side_news',
			  'description' => 'This widget display news as cards and in side bar!',
			);
			parent::__construct( 'card_side_news', 'ESN: Card & Side News Widget', $widget_options );
		}
		
		/* widget function displays the widget in the front end */
		public function widget( $args, $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$news_count = ! empty( $instance['news_count'] ) ? $instance['news_count'] : '';
			$esn_selected_cat = ! empty( $instance['esn_cat'] ) ? esc_attr( $instance['esn_cat']) : '';
			$title1 = ! empty( $instance['title1'] ) ? $instance['title1'] : '';
			$news_count1 = ! empty( $instance['news_count1'] ) ? $instance['news_count1'] : '';
			$esn_selected_cat1 = ! empty( $instance['esn_cat1'] ) ? esc_attr( $instance['esn_cat1']) : '';		   
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
			if( $esn_selected_cat1 != -1 ){
	            $sticky = get_option( 'sticky_posts' );
				$esn_cat_post_args1 = array(
					'posts_per_page'      => $news_count1,
					'cat'				  => $esn_selected_cat1,
					'no_found_rows'       => true,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
					'post__not_in' => $sticky
				);
			}
			echo '<div class="card-news-side-wrapper">';
				$news_query = new WP_Query($esn_cat_post_args);
				if ($news_query->have_posts()){
					echo $args['before_widget'] . 
						$args['before_title'] .
							'<a class="hvr-shutter-out-horizontal" href="category/'.get_cat_name($esn_selected_cat).'"><img class="title-icon" src="http://dial100.test/wp-content/uploads/2019/09/icon.png">'. $title.'</a>'.
						$args['after_title'];
						$count = 0;
						echo '<div class="card_news_wrapper">';
							while ($news_query->have_posts()): $news_query->the_post();
								if (has_post_thumbnail()) {
									$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
								} else {
									$image_url[0] = get_template_directory_uri() . '/assets/img/no-image-660-365.png';
								}
								if( $count == 0 ){
									echo '<div class="news-section-card-first box-shadow">';	
											echo '<div class="frist-card-img-wrap">	
													<a href="'.get_permalink().'">
														<img src="'.$image_url[0].'"/>
													</a>			
											</div>';
										echo '<div class="first-card-title-content-wrap">';			
											echo '<div class="news-title">';							
														the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');			
											echo '</div>';
											$content = esn_words_count( get_the_excerpt() ,20);
											echo '<div class="first-card-breaker-news-summary">
													<a href="'.get_permalink().'">
														<p>'.esc_html( $content ).'</p>
													</a>
											</div>';
										echo '</div>'; // end of title-content-wrap
									echo '</div>'; // end of new section
									echo '<div class="rest-card-section-wrapper">'; // end of new section
								}else{
									echo '<div class="news-section-card-rest box-shadow">';	
											echo '<div class="rest-card-img-wrap">	
													<a href="'.get_permalink().'">
														<img src="'.$image_url[0].'"/>
													</a>			
											</div>';
										echo '<div class="rest-card-title-content-wrap">';			
											echo '<div class="news-title">';							
														the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');			
											echo '</div>';
										echo '</div>'; // end of title-content-wrap
									echo '</div>'; // end of new section						
								}
								$count++;
							endwhile;
						echo '</div></div>'; 			
						wp_reset_postdata();
					echo $args['after_widget'];
				} //  end if news_query1	
				$news_query1 = new WP_Query($esn_cat_post_args1);
				if ($news_query1->have_posts()){
				echo $args['before_widget'] . 
					$args['before_title'] .
						'<a class="hvr-shutter-out-horizontal" href="category/'.get_cat_name($esn_selected_cat1).'"><img class="title-icon" src="http://dial100.test/wp-content/uploads/2019/09/icon.png">'. $title1.'</a>'.
					$args['after_title'];
					echo '<div class="side_news_wrapper">';
						echo '<div class="side_news_list_wrapper">';
						while ($news_query1->have_posts()): $news_query1->the_post();
								if (has_post_thumbnail()) {
									$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
								} else {
									$image_url[0] = get_template_directory_uri() . '/assets/img/no-image-660-365.png';
								}
								echo '<div class="side-section-news">';	
								echo '<div class="side-section-news-title-content-wrap">';
									echo '<div class="news-title">';						
											the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');
									echo '</div>';
								echo '</div>'; // end of title-content-wrap
							echo '</div>'; // end of new section	
						endwhile;
					echo '</div>'; //end of side_news_wrapper
				echo $args['after_widget'];
				}
			echo '</div>'; // end of card-news-side-wrapper
		}
		
		/* form function displays the widget in the back end */
		public function form( $instance ) {			
			$title = ! empty( $instance['title'] ) ? $instance['title'] : ''; //for title
			$news_count = ! empty( $instance['news_count'] ) ? $instance['news_count'] : ''; //for title
			$esn_selected_cat = ! empty( $instance['esn_cat'] ) ? esc_attr( $instance['esn_cat']) : '';			
			$title1 = ! empty( $instance['title1'] ) ? $instance['title1'] : ''; //for title1
			$news_count1 = ! empty( $instance['news_count1'] ) ? $instance['news_count1'] : ''; //for news_count1
			$esn_selected_cat1 = ! empty( $instance['esn_cat1'] ) ? esc_attr( $instance['esn_cat1']) : '';
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
			</p><p>
				<label for="<?php echo $this->get_field_id( 'title1' ); ?>">Title for Side News:</label>
				<input type="text" id="<?php echo $this->get_field_id( 'title1' ); ?>" name="<?php echo $this->get_field_name( 'title1' ); ?>" value="<?php echo esc_attr( $title1 ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('esn_cat1'); ?>"><?php _e('Select Category for Side News:', 'esn'); ?></label>
				<?php
				$esn_dropown_cat1 = array(
					'show_option_none'   => __('From Recent Posts','esn'),
					'orderby'            => 'name',
					'order'              => 'asc',
					'show_count'         => 1,
					'hide_empty'         => 1,
					'echo'               => 1,
					'selected'           => $esn_selected_cat1,
					'hierarchical'       => 1,
					'name'               => $this->get_field_name('esn_cat1'),
					'id'                 => $this->get_field_name('esn_cat1'),
					'class'              => 'widefat',
					'taxonomy'           => 'category',
					'hide_if_empty'      => false,
				);
				wp_dropdown_categories($esn_dropown_cat1);
				?>
			</p> 
			<p>
				<label for="<?php echo $this->get_field_id( 'news_count1' ); ?>">Count for Side News:</label>
				<input type="number" id="<?php echo $this->get_field_id( 'news_count1' ); ?>" name="<?php echo $this->get_field_name( 'news_count1' ); ?>" value="<?php echo esc_attr( $news_count1 ); ?>" />
			</p>
			<?php 
		}
		
		public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = ( isset( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
            $instance['news_count'] = ( isset( $new_instance['news_count'] ) ) ? $new_instance['news_count'] : '';
            $instance['esn_cat'] = ( isset( $new_instance['esn_cat'] ) ) ? esc_attr( $new_instance['esn_cat'] ) : '';
            $instance['title1'] = ( isset( $new_instance['title1'] ) ) ? sanitize_text_field( $new_instance['title1'] ) : '';
            $instance['news_count1'] = ( isset( $new_instance['news_count1'] ) ) ? $new_instance['news_count1'] : '';
            $instance['esn_cat1'] = ( isset( $new_instance['esn_cat1'] ) ) ? esc_attr( $new_instance['esn_cat1'] ) : '';

            return $instance;
        }
	
	  
	} // class card_side_news ends here
}

if ( ! function_exists( 'card_side_news' ) ) :
    /**
     * Function to Register and load the widget
     *
     * @since 1.0.0
     *
     * @param null
     * @return void
     *
     */
    function card_side_news() {
        register_widget( 'card_side_news' );
    }
endif;
add_action( 'widgets_init', 'card_side_news' );

