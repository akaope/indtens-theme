<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */
?>
<?php #head-post before ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'freedom_before_post_content' ); ?>
	<?php custom_breadcrumbs(); ?>
	<?php
		if ( is_front_page() == false ) {					
				if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.					
					echo '<div class="head-post">';
					the_post_thumbnail( 'full', array('class'=>'head-post__img') );
					echo "<div class='overlay'></div>";
					echo '<header class="indtens-title"><h1 class="indtens-title">';
						the_title();
					echo '</h1> </header>';					
					$categories_list = get_the_category_list();
					if ( $categories_list ) {
						echo "<div class='categories_list'>".$categories_list."</div>";
					}
					echo "<div class='img-caption'>".get_post(get_post_thumbnail_id())->post_excerpt."</div>";
					echo "</div>";
			}					
		}
		
	?> 

	<?php freedom_entry_meta(); ?>
	<div class="meta_desc">
		<?php echo get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true); ?>
	</div>
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
	</div>

	<?php do_action( 'freedom_after_post_content' ); ?>
</article>
