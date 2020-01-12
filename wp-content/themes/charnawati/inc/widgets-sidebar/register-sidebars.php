<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function charnawati_news_sidebars_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Home Page Content Area', 'charnawati-news' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'charnawati-news' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Area', 'charnawati-news' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Add Footer widgets here.', 'charnawati-news' ),
		'before_widget' => '<section id="%1$s" class="fiiter-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="footer-widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'charnawati_news_sidebars_init' );