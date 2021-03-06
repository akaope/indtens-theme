<?php
/**
 * home.php for our theme.
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */

get_header(); ?>

	<?php do_action( 'freedom_before_body_content' ); ?>

	<div id="primary" class="home-primary">
		<div id="content" class="indtens-ctn--home clearfix">
			<div class="home-title">
				<h3>Masih Hangat</h3>
			</div>
			<?php if ( have_posts() ) : ?>

				<?php global $post_i; $post_i = 1; ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						if ( get_theme_mod( 'freedom_posts_page_display_type', 'photo_blogging_two_column' ) == 'photo_blogging_two_column' ) {
							$view_type = 'home';
						}
						else {
							$view_type = '';
						}
					?>

					<?php get_template_part( 'content', $view_type ); ?>

				<?php endwhile; ?>

				<?php get_template_part( 'navigation', 'none' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'none' ); ?>

			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary --> 
	<?php get_sidebar(); ?>
	<?php do_action( 'freedom_after_body_content' ); ?>

<?php get_footer(); ?>
