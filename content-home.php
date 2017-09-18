<?php
/**
 * The template used for displaying posts page (images listing view).
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */

global $post_i;
if( $post_i % 2 == 1 )
	$article_class = 'tg-two-column-post-left';
else
	$article_class = 'tg-two-column-post-right';

if( has_post_thumbnail() )
	$article_class .= ' yes-post-thumbnail';
else
	$article_class .= ' no-post-thumbnail';

$article_class .= ' post-box';
?>

<div class="col-md-6">
	<div class="post-item">
		<div class="post-thumb">
			<a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail(); ?>
			</a>
		</div>
		<div class="post-body">
			<div class="title">
				<?php 
					$categories_list = get_the_category_list();
					if ( $categories_list ) {
						echo "<div class='ctgr_home'>".$categories_list."</div>";
					}	
				?>
			<h3 class="post-title"><a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			</div> 
		</div>
	</div>
</div>


<?php 
	$post_i++; 
?>
