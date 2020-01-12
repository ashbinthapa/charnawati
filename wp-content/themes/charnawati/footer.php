<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package charnawati
 */

?>

	</div><!-- #content -->
	</div><!-- .body-wrapper -->
	<footer id="colophon" class="site-footer">
		<div class="site-footer-content-wrapper body-wrapper">
			<?php if( is_active_sidebar( 'sidebar-3' ) ){
				dynamic_sidebar( 'sidebar-3' );
			} ?>
		</div>

		<div class="site-info">
			<div class="body-wrapper">
				<p> Copyright 2019 &copy; CharnawatiNews</p>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'CharnawatiNews' ) ); ?>">
					<?php
					/* translators: %s: CMS name, i.e. WordPress. */
					printf( esc_html__( 'Maintained by %s', 'CharnawatiNews' ), 'Eservices Nepal' );
					?>
				</a>
			</div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
