<?php
/**
 * The template part for displaying navigation.
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */
?>
<div class="related-item">
<?php
if( is_archive() || is_home() || is_search() ) {
	/**
	 * Checking WP-PageNaviplugin exist
	 */
	if ( function_exists('wp_pagenavi' ) ) : 
		wp_pagenavi();

	else: 
		global $wp_query;
		if ( $wp_query->max_num_pages > 1 ) : 
		?>
		<ul class="default-wp-page clearfix">
			<li class="previous"><?php next_posts_link( __( '&larr; Previous', 'freedom' ) ); ?></li>
			<li class="next"><?php previous_posts_link( __( 'Next &rarr;', 'freedom' ) ); ?></li>
		</ul>
		<?php
		endif;
	endif;
}

if ( is_single() ) {	
	if( is_attachment() ) {
	?> 
	<?php
	}
	else {
	?>	
		<?php $orig_post = $post;
			global $post;
			$categories = get_the_category($post->ID);
			if ($categories) {
				$category_ids = array();
				foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
				
				$args=array(
					'category__in' => $category_ids,
					'post__not_in' => array($post->ID),
					'posts_per_page'=> 2, // Number of related posts that will be shown.
					'caller_get_posts'=>1
				);
				
				$my_query = new wp_query( $args );
				if( $my_query->have_posts() ) {
					$no = 1;
					echo '<div class="row">';
					while( $my_query->have_posts() ) {
						$my_query->the_post();
		?>					
						<div class="col-md-4">
							<div class="post-related">
								<div class="related-thumb">
									<a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
										<?php the_post_thumbnail(); ?>
									</a>
								</div>
								<div class="post-related-body">
									<div class="title">
										<h3 class="post-title"><a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
									</div>									
								</div>
							</div>
						</div>
		<?php
						$no++;
					}
					echo '</div>';
				}
			}
			$post = $orig_post;
			wp_reset_query(); 
		?> 
	<?php
	}	
}
?>
</div>