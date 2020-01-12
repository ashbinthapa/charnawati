<?php
/**
 * Card & Side News Widget Class
 */
if ( ! class_exists( 'esn_full_width_six_thumb_news_widget' ) ) {
    /**
     * Class for adding widget
     * @since 1.0.0
     */
	class esn_full_width_six_thumb_news_widget extends WP_Widget {
	  /**
	  * To create the example widget all four methods will be 
	  * nested inside this single instance of the WP_Widget class.
	  **/
		public function __construct() {
			$widget_options = array( 
			  'classname' => 'esn_full_width_six_thumb_news_widget',
			  'description' => 'This widget display six news as thumb news in full width!',
			);
			parent::__construct( 'esn_full_width_six_thumb_news_widget', 'ESN: Six News Thumb Full Width Widget', $widget_options );
		}
		
		/* widget function displays the widget in the front end */
		public function widget( $args, $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$esn_selected_cat = ! empty( $instance['esn_cat'] ) ? esc_attr( $instance['esn_cat']) : '';	   
			if( $esn_selected_cat != -1 ){
	            $sticky = get_option( 'sticky_posts' );
				$esn_cat_post_args = array(
					'posts_per_page'      => 6,
					'cat'				  => $esn_selected_cat,
					'no_found_rows'       => true,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
					'post__not_in' => $sticky
				);
			}
			echo '<div class="six-thumb-news-main-wrapper">';
				$news_query = new WP_Query($esn_cat_post_args);
				if ($news_query->have_posts()){
					echo $args['before_widget'] . 
						$args['before_title'] .
							'<a class="hvr-shutter-out-horizontal" href="category/'.get_cat_name($esn_selected_cat).'"><img class="title-icon" src="http://dial100.test/wp-content/uploads/2019/09/icon.png">'. $title.'</a>'.
						$args['after_title'];
						$count = 0;
						echo '<div class="six-thumb-news-wrapper">';
							while ($news_query->have_posts()): $news_query->the_post();
								if (has_post_thumbnail()) {
									$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
								} else {
									$image_url[0] = get_template_directory_uri() . '/assets/img/no-image-660-365.png';
								}
								if ($count <= 2) {
									if( $count == 0 ){
										echo '<div class="three-thumb-wrapper-only">';
											echo '<div class="first-thumb-news-wrapper">';	
												echo '<div class="frist-thumb-img-wrap">	
														<a href="'.get_permalink().'">
															<img src="'.$image_url[0].'"/>
														</a>			
												</div>';
												echo '<div class="first-thumb-title-content-wrap">';			
													echo '<div class="news-title">';							
																the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');			
													echo '</div>';
													$content = esn_words_count( get_the_excerpt() ,20);
													echo '<div class="first-thumb-news-summary">
															<a href="'.get_permalink().'">
																<p>'.esc_html( $content ).'</p>
															</a>
													</div>';
												echo '</div>'; // end of first-thumb-title-content-wrap
											echo '</div>'; // end of first-thumb-news-wrapper
											echo '<div class="two-rem-thumb-section-wrapper">'; 
									}else{
										echo '<div class="two-thumb-news-wrapper">';	
											echo '<div class="second-thumb-img-wrap">	
													<a href="'.get_permalink().'">
														<img src="'.$image_url[0].'"/>
													</a>			
											</div>';
											echo '<div class="second-thumb-title-content-wrap">';			
												echo '<div class="news-title">';							
															the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');			
												echo '</div>';
												$content = esn_words_count( get_the_excerpt() ,20);
												echo '<div class="content-thumb-news-summary">
														<a href="'.get_permalink().'">
															<p>'.esc_html( $content ).'</p>
														</a>
												</div>';
											echo '</div>'; // end of second-thumb-title-content-wrap
										echo '</div>'; // end of two-thumb-news-wrapper	
									}
									if ($count == 2){
										echo '</div>'; //end of three-thumb-wrapper-only
										echo '</div>'; //end of two-rem-thumb-section-wrapper
										echo '<div class="remaining-side-news-wrapper">';
									}				
								} else {
									echo '<div class="remaining-list-wrapper">';	
										echo '<div class="side-news-img-wrap">	
												<a href="'.get_permalink().'">
													<img src="'.$image_url[0].'"/>
												</a>			
										</div>';
										echo '<div class="side-news-title-content-wrap">';			
											echo '<div class="news-title">';							
														the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');			
											echo '</div>';
											$content = esn_words_count( get_the_excerpt() ,20);
											echo '<div class="content-side-news-summary">
													<a href="'.get_permalink().'">
														<p>'.esc_html( $content ).'</p>
													</a>
											</div>';
										echo '</div>'; // end of side-news-title-content-wrap	
									echo '</div>';// end of remaining-list-wrapper
								}	
								$count++;
							endwhile;
						echo '</div></div>'; // first end of six-thumb-news-wrapper -- second end of three-thumb-news-wrapper-and-rem-side 			
						wp_reset_postdata();
					echo $args['after_widget'];
				}
			echo '</div>'; // end of six-thumb-news-main-wrapper
		}
		
		/* form function displays the widget in the back end */
		public function form( $instance ) {			
			$title = ! empty( $instance['title'] ) ? $instance['title'] : ''; //for title
			$esn_selected_cat = ! empty( $instance['esn_cat'] ) ? esc_attr( $instance['esn_cat']) : '';		
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

			<?php 
		}
		
		public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = ( isset( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
            $instance['esn_cat'] = ( isset( $new_instance['esn_cat'] ) ) ? esc_attr( $new_instance['esn_cat'] ) : '';

            return $instance;
        }
	
	  
	} // class esn_full_width_six_thumb_news_widget ends here
}

if ( ! function_exists( 'esn_full_width_six_thumb_news_widget' ) ) :
    /**
     * Function to Register and load the widget
     *
     * @since 1.0.0
     *
     * @param null
     * @return void
     *
     */
    function esn_full_width_six_thumb_news_widget() {
        register_widget( 'esn_full_width_six_thumb_news_widget' );
    }
endif;
add_action( 'widgets_init', 'esn_full_width_six_thumb_news_widget' );

