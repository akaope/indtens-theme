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

  <div class="col-md-4">
    <div class="post-item">
			<div class="post-thumb">
				<a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
					<?php the_post_thumbnail(); ?>
				</a>
			</div>
      <div class="post-body">
				<div class="title">
					<h3 class="post-title"><a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
				</div>
				<div class="post-author">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo get_the_author(); ?>"><?php echo ucwords(esc_html(get_the_author())); ?></a>
				</div>
      </div>
    </div>
  </div>


<?php 
	$post_i++; 
?>
