<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */
?>
<div class="head-post">
	<?php
		if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
			the_post_thumbnail( 'full' );
			echo "<div class='img-caption'>".get_post(get_post_thumbnail_id())->post_excerpt."</div>";
		}
	?>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'freedom_before_post_content' ); ?>

	<header class="entry-header">
		<h1 class="entry-title">
			<?php the_title(); ?>
		</h1>
	</header>
	<?php if ( function_exists( 'get_author_bio_box' ) ) echo get_author_bio_box(); ?>
	<?php freedom_entry_meta(); ?>

	<div class="entry-content clearfix">
		<?php
			the_content();

			wp_link_pages( array(
				'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'freedom' ),
				'after'             => '</div>',
				'link_before'       => '<span>',
				'link_after'        => '</span>'
	      ) );
		?>
		<?php tags_bottom(); ?>
		<ul class="sharebtn">
			<li style="width: 178px;font-weight: bold;font-size:17px;font-family: arial;">Bagikan artikel ini:</li>
			<li class="twitter--btn"><a target="_blank" class="share-btn" href="http://twitter.com/home/?status=<?php the_title(); ?> - <?php the_permalink(); ?> via @indtens" title="Tweet this!"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
			<li class="facebook--btn"><a target="_blank" class="share-btn" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title(); ?>" title="Share to Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
			<li class="google--btn"><a target="_blank" class="share-btn" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" title="Share to Google+"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>

		</ul>
</a>
	</div>

	<?php do_action( 'freedom_after_post_content' ); ?>
</article>
