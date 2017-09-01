<?php
/**
 * Theme Single Post Section for our theme.
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */

get_header(); ?>

	<?php do_action( 'freedom_before_body_content' ); ?>

	<div id="primary">
		<div id="content" class="clearfix">
			<ul class="sharebtn-top">
			<li class="twitter--btn"><a target="_blank" class="share-btn" href="http://twitter.com/home/?status=<?php the_title(); ?> - <?php the_permalink(); ?>" title="Tweet this!"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
			<li class="facebook--btn"><a target="_blank" class="share-btn" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title(); ?>" title="Share to Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
			<li class="google--btn"><a target="_blank" class="share-btn" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" title="Share to Google+"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
		</ul>
			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php get_template_part( 'content', 'single' ); ?>

				<?php get_template_part( 'navigation', 'single' ); ?>

				<?php
					do_action( 'freedom_before_comments_template' );
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
	      		do_action ( 'freedom_after_comments_template' );
				?>

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

	<?php //freedom_sidebar_select(); ?>
	<?php get_sidebar(); ?>
	<?php do_action( 'freedom_after_body_content' ); ?>

<?php get_footer(); ?>
