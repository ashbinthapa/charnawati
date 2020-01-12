<?php
/**
 * Three Column News Widget Class
 */
if ( ! class_exists( 'three_column_news' ) ) {
    /**
     * Class for adding widget
     * @since 1.0.0
     */
	class three_column_news extends WP_Widget {
	  /**
	  * To create the example widget all three methods will be 
	  * nested inside this single instance of the WP_Widget class.
	  **/
		public function __construct() {
			$widget_options = array( 
			  'classname' => 'three_column_news',
			  'description' => 'This widget display three column news!',
			);
			parent::__construct( 'three_column_news', 'ESN: Three Column News Widget', $widget_options );
		}
		
		/* widget function displays the widget in the front end */
		public function widget( $args, $instance ) {
			$news_count = ! empty( $instance['news_count'] ) ? $instance['news_count'] : '';
			$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$esn_selected_cat = ! empty( $instance['esn_cat'] ) ? esc_attr( $instance['esn_cat']) : '';
			$title1 = ! empty( $instance['title1'] ) ? $instance['title1'] : '';
			$esn_selected_cat1 = ! empty( $instance['esn_cat1'] ) ? esc_attr( $instance['esn_cat1']) : '';
			$title2 = ! empty( $instance['title2'] ) ? $instance['title2'] : '';
			$esn_selected_cat2 = ! empty( $instance['esn_cat2'] ) ? esc_attr( $instance['esn_cat2']) : '';	   
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
					'posts_per_page'      => $news_count,
					'cat'				  => $esn_selected_cat1,
					'no_found_rows'       => true,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
					'post__not_in' => $sticky
				);
			}		   
			if( $esn_selected_cat2 != -1 ){
	            $sticky = get_option( 'sticky_posts' );
				$esn_cat_post_args2 = array(
					'posts_per_page'      => $news_count,
					'cat'				  => $esn_selected_cat2,
					'no_found_rows'       => true,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
					'post__not_in' => $sticky
				);
			}
			$news_query = new WP_Query($esn_cat_post_args);
			$news_query1 = new WP_Query($esn_cat_post_args1);
			$news_query2 = new WP_Query($esn_cat_post_args2);
			echo '<div class="three-column-news-wrapper">';
					if ($news_query->have_posts()){
						echo $args['before_widget'] . 
							$args['before_title'] .
								'<a class="hvr-shutter-out-horizontal" href="category/'.get_cat_name($esn_selected_cat).'"><img class="title-icon" src="http://dial100.test/wp-content/uploads/2019/09/icon.png">'. $title.'</a>'.
							$args['after_title'];
							$count = 0;
							echo '<div class="column-news-wrapper">';
								while ($news_query->have_posts()): $news_query->the_post();
									if (has_post_thumbnail()) {
										$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
									} else {
										$image_url[0] = get_template_directory_uri() . '/assets/img/no-image-660-365.png';
									}
									if( $count == 0 ){
										echo '<div class="column-first-news-wrapper">';
											echo '<div class="frist-news-img-wrap">';	
												echo '<a href="'.get_permalink().'">';
													echo '<img src="'.$image_url[0].'"/>';
												echo '</a>';		
											echo '</div>';
											echo '<div class="news-title">';
												the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');
											echo '</div>';
										echo '</div>';
									}else{
										echo '<div class="column-rest-news-wrapper">';
												echo '<div class="news-title">';
													the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');	
												echo '</div>';
										echo '</div>';			
									}
								$count++;
								endwhile;
							echo '</div>'; // end column-news-wrapper
						echo $args['after_widget'];
					}
					if ($news_query1->have_posts()){
						echo $args['before_widget'] . 
							$args['before_title'] .
								'<a class="hvr-shutter-out-horizontal" href="category/'.get_cat_name($esn_selected_cat1).'"><img class="title-icon" src="http://dial100.test/wp-content/uploads/2019/09/icon.png">'. $title1.'</a>'.
							$args['after_title'];
							$count = 0;
							echo '<div class="column-news-wrapper">';
								while ($news_query1->have_posts()): $news_query1->the_post();
									if (has_post_thumbnail()) {
										$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
									} else {
										$image_url[0] = get_template_directory_uri() . '/assets/img/no-image-660-365.png';
									}
									if( $count == 0 ){
										echo '<div class="column-first-news-wrapper">';
											echo '<div class="frist-news-img-wrap">';	
												echo '<a href="'.get_permalink().'">';
													echo '<img src="'.$image_url[0].'"/>';
												echo '</a>';		
											echo '</div>';
											echo '<div class="news-title">';
												the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');
											echo '</div>';
										echo '</div>';
									}else{
										echo '<div class="column-rest-news-wrapper">';
												echo '<div class="news-title">';
													the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');	
												echo '</div>';
										echo '</div>';			
									}
								$count++;
								endwhile;
							echo '</div>'; // end column-news-wrapper
						echo $args['after_widget'];
					}
					if ($news_query2->have_posts()){
						echo $args['before_widget'] . 
							$args['before_title'] .
								'<a class="hvr-shutter-out-horizontal" href="category/'.get_cat_name($esn_selected_cat2).'"><img class="title-icon" src="http://dial100.test/wp-content/uploads/2019/09/icon.png">'. $title2.'</a>'.
							$args['after_title'];
							$count = 0;
							echo '<div class="column-news-wrapper">';
								while ($news_query2->have_posts()): $news_query2->the_post();
									if (has_post_thumbnail()) {
										$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
									} else {
										$image_url[0] = get_template_directory_uri() . '/assets/img/no-image-660-365.png';
									}
									if( $count == 0 ){
										echo '<div class="column-first-news-wrapper">';
											echo '<div class="frist-news-img-wrap">';	
												echo '<a href="'.get_permalink().'">';
													echo '<img src="'.$image_url[0].'"/>';
												echo '</a>';		
											echo '</div>';
											echo '<div class="news-title">';
												the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');
											echo '</div>';
										echo '</div>';
									}else{
										echo '<div class="column-rest-news-wrapper">';
												echo '<div class="news-title">';
													the_title('<h4 class="title"><a href="'.get_permalink().'">','</a></h4>');	
												echo '</div>';
										echo '</div>';			
									}
								$count++;
								endwhile;
							echo '</div>'; // end column-news-wrapper
						echo $args['after_widget'];
					}
			echo '</div>'; // end of three-column-news-wrapper
		}
		
		/* form function displays the widget in the back end */
		public function form( $instance ) {
			$news_count = ! empty( $instance['news_count'] ) ? $instance['news_count'] : '';
			$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$esn_selected_cat = ! empty( $instance['esn_cat'] ) ? esc_attr( $instance['esn_cat']) : '';
			$title1 = ! empty( $instance['title1'] ) ? $instance['title1'] : '';
			$esn_selected_cat1 = ! empty( $instance['esn_cat1'] ) ? esc_attr( $instance['esn_cat1']) : '';
			$title2 = ! empty( $instance['title2'] ) ? $instance['title2'] : '';
			$esn_selected_cat2 = ! empty( $instance['esn_cat2'] ) ? esc_attr( $instance['esn_cat2']) : '';		
			?> 
			<p>
				<label for="<?php echo $this->get_field_id( 'news_count' ); ?>">News Count For The Columns:</label>
				<input type="number" id="<?php echo $this->get_field_id( 'news_count' ); ?>" name="<?php echo $this->get_field_name( 'news_count' ); ?>" value="<?php echo esc_attr( $news_count ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title For Column 1:</label>
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
				<label for="<?php echo $this->get_field_id( 'title1' ); ?>">Title For Column 2:</label>
				<input type="text" id="<?php echo $this->get_field_id( 'title1' ); ?>" name="<?php echo $this->get_field_name( 'title1' ); ?>" value="<?php echo esc_attr( $title1 ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('esn_cat1'); ?>"><?php _e('Select Category', 'esn'); ?></label>
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
				<label for="<?php echo $this->get_field_id( 'title2' ); ?>">Title For Column 3:</label>
				<input type="text" id="<?php echo $this->get_field_id( 'title2' ); ?>" name="<?php echo $this->get_field_name( 'title2' ); ?>" value="<?php echo esc_attr( $title2 ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('esn_cat2'); ?>"><?php _e('Select Category', 'esn'); ?></label>
				<?php
				$esn_dropown_cat2 = array(
					'show_option_none'   => __('From Recent Posts','esn'),
					'orderby'            => 'name',
					'order'              => 'asc',
					'show_count'         => 1,
					'hide_empty'         => 1,
					'echo'               => 1,
					'selected'           => $esn_selected_cat2,
					'hierarchical'       => 1,
					'name'               => $this->get_field_name('esn_cat2'),
					'id'                 => $this->get_field_name('esn_cat2'),
					'class'              => 'widefat',
					'taxonomy'           => 'category',
					'hide_if_empty'      => false,
				);
				wp_dropdown_categories($esn_dropown_cat2);
				?>
			</p>
			<?php 
		}
		
		public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['news_count'] = ( isset( $new_instance['news_count'] ) ) ? $new_instance['news_count'] : '';
            $instance['title'] = ( isset( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
            $instance['esn_cat'] = ( isset( $new_instance['esn_cat'] ) ) ? esc_attr( $new_instance['esn_cat'] ) : '';
            $instance['title1'] = ( isset( $new_instance['title1'] ) ) ? sanitize_text_field( $new_instance['title1'] ) : '';
            $instance['esn_cat1'] = ( isset( $new_instance['esn_cat1'] ) ) ? esc_attr( $new_instance['esn_cat1'] ) : '';
            $instance['title2'] = ( isset( $new_instance['title2'] ) ) ? sanitize_text_field( $new_instance['title2'] ) : '';
            $instance['esn_cat2'] = ( isset( $new_instance['esn_cat2'] ) ) ? esc_attr( $new_instance['esn_cat2'] ) : '';

            return $instance;
        }
	
	  
	} // class three_column_news ends here
}

if ( ! function_exists( 'three_column_news' ) ) :
    /**
     * Function to Register and load the widget
     *
     * @since 1.0.0
     *
     * @param null
     * @return void
     *
     */
    function three_column_news() {
        register_widget( 'three_column_news' );
    }
endif;
add_action( 'widgets_init', 'three_column_news' );

