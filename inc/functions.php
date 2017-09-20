<?php
/**
 * Freedom functions and definitions
 *
 * This file contains all the functions and it's defination that particularly can't be
 * in other files.
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */

/****************************************************************************************/

add_action( 'wp_enqueue_scripts', 'freedom_scripts_styles_method' );
/**
 * Register jquery scripts
 */
function freedom_scripts_styles_method() {
   /**
	* Loads our main stylesheet.
	*/
	wp_enqueue_style( 'freedom_style', get_stylesheet_uri() );

  	wp_register_style( 'freedom_googlefonts', 'http://fonts.googleapis.com/css?family=Fira+Sans|Vollkorn' );
  	wp_enqueue_style( 'freedom_googlefonts' );

	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/**
	 * Register JQuery cycle js file for slider.
	 */
	wp_register_script( 'jquery_cycle', FREEDOM_JS_URL . '/jquery.cycle.all.min.js', array( 'jquery' ), '3.0.3', true );

	/**
	 * Enqueue Slider setup js file.
	 */
	if ( is_front_page() && get_theme_mod( 'freedom_activate_slider', '0' ) == '1' ) {
		wp_enqueue_script( 'freedom_slider', FREEDOM_JS_URL . '/freedom-slider-setting.js', array( 'jquery_cycle' ), false, true );
	}
	wp_enqueue_script( 'freedom-navigation', FREEDOM_JS_URL . '/navigation.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'freedom-custom', FREEDOM_JS_URL. '/freedom-custom.js', array( 'jquery' ) );

	wp_enqueue_style( 'freedom-fontawesome', get_template_directory_uri().'/fontawesome/css/font-awesome.css', array(), '4.2.1' );

	wp_enqueue_style( 'google_fonts' );

	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5shiv.js', array(), '3.7.3', false );
	wp_script_add_data( 'html5shiv', 'conditional', 'lte IE 8' );

}

/****************************************************************************************/

add_filter( 'excerpt_length', 'freedom_excerpt_length' );
/**
 * Sets the post excerpt length to 40 words.
 *
 * function tied to the excerpt_length filter hook.
 *
 * @uses filter excerpt_length
 */
function freedom_excerpt_length( $length ) {
	return 40;
}

add_filter( 'excerpt_more', 'freedom_continue_reading' );
/**
 * Returns a "Continue Reading" link for excerpts
 */
function freedom_continue_reading() {
	return '';
}

/****************************************************************************************/

/**
 * Removing the default style of wordpress gallery
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Filtering the size to be medium from thumbnail to be used in WordPress gallery as a default size
 */
function freedom_gallery_atts( $out, $pairs, $atts ) {
	$atts = shortcode_atts( array(
	'size' => 'medium',
	), $atts );

	$out['size'] = $atts['size'];

	return $out;

}
add_filter( 'shortcode_atts_gallery', 'freedom_gallery_atts', 10, 3 );

/****************************************************************************************/

add_filter( 'body_class', 'freedom_body_class' );
/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
function freedom_body_class( $classes ) {
	global $post;

	if( $post ) { $layout_meta = get_post_meta( $post->ID, 'freedom_page_layout', true ); }

	if( is_home() ) {
		$queried_id = get_option( 'page_for_posts' );
		$layout_meta = get_post_meta( $queried_id, 'freedom_page_layout', true );
	}
	if( empty( $layout_meta ) || is_archive() || is_search() ) { $layout_meta = 'default_layout'; }
	$freedom_default_layout = get_theme_mod( 'freedom_default_layout', 'no_sidebar_full_width' );

	$freedom_default_page_layout = get_theme_mod( 'freedom_pages_default_layout', 'right_sidebar' );
	$freedom_default_post_layout = get_theme_mod( 'freedom_single_posts_default_layout', 'right_sidebar' );

	if( $layout_meta == 'default_layout' ) {
		if( is_page() ) {
			$classes[] = '';
			// if( $freedom_default_page_layout == 'right_sidebar' ) { $classes[] = ''; }
			// elseif( $freedom_default_page_layout == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
			// elseif( $freedom_default_page_layout == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
			// elseif( $freedom_default_page_layout == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }
		}
		elseif( is_single() ) {
			$classes[] = '';
			// if( $freedom_default_post_layout == 'right_sidebar' ) { $classes[] = ''; }
			// elseif( $freedom_default_post_layout == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
			// elseif( $freedom_default_post_layout == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
			// elseif( $freedom_default_post_layout == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }
		}
		elseif( $freedom_default_layout == 'right_sidebar' ) { $classes[] = ''; }
		elseif( $freedom_default_layout == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
		elseif( $freedom_default_layout == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
		elseif( $freedom_default_layout == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }
	}
	elseif( $layout_meta == 'right_sidebar' ) { $classes[] = ''; }
	elseif( $layout_meta == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
	elseif( $layout_meta == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
	elseif( $layout_meta == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }

	if( get_theme_mod( 'freedom_new_menu', 0 ) == 1 ){
		$classes[] = 'better-responsive-menu';
	}

	if( get_theme_mod( 'freedom_site_layout', 'wide' ) == 'wide' ) {
		$classes[] = 'wide';
	}
	elseif( get_theme_mod( 'freedom_site_layout', 'wide' ) == 'box' ) {
		$classes[] = '';
	}

	return $classes;
}

/****************************************************************************************/

if ( ! function_exists( 'freedom_sidebar_select' ) ) :
/**
 * Fucntion to select the sidebar
 */
function freedom_sidebar_select() {
	global $post;

	if( $post ) { $layout_meta = get_post_meta( $post->ID, 'freedom_page_layout', true ); }

	if( is_home() ) {
		$queried_id = get_option( 'page_for_posts' );
		$layout_meta = get_post_meta( $queried_id, 'freedom_page_layout', true );
	}

	if( empty( $layout_meta ) || is_archive() || is_search() ) { $layout_meta = 'default_layout'; }
	$freedom_default_layout = get_theme_mod( 'freedom_default_layout', 'no_sidebar_full_width' );

	$freedom_default_page_layout = get_theme_mod( 'freedom_pages_default_layout', 'right_sidebar' );
	$freedom_default_post_layout = get_theme_mod( 'freedom_single_posts_default_layout', 'right_sidebar' );

	if( is_page() ) {
		get_sidebar();
	}
	if( is_single() ) {
		get_sidebar();
	}
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'freedom_entry_meta' ) ) :
/**
 * Shows meta information of post.
 */
function freedom_entry_meta() {
	echo '<div class="entry-meta">';
?>
	<div class="indtens-meta--left">
	<?php
		echo '<div class="indtens-autor-pic">' . get_avatar( get_the_author_meta('ID'), 50 ) . '</div>';
		echo '<div class="meta-info">';			
		
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		  $time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
		}
		$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
		printf( __( '<div class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark">%3$s</a></div>', 'freedom' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		$time_string
	);

	// if ( $tags_list ) echo $tags_list;
?>
	<div class="author-top">
		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo get_the_author(); ?>"><?php echo ucwords(esc_html( get_the_author() )); ?> - <?php if(function_exists('the_views')) { the_views(); } ?></a>    
	</div>

	</div></div>

	<div class="indtens-meta--right"> 
		<?=wpvkp_social_buttons();?>
	</div>
	<?php
	echo '</div>';
}
endif;

if ( ! function_exists( 'tags_bottom' ) ) :
/**
 * Shows tags information of post.
 */
function tags_bottom() {
	echo '<div class="entry-meta">';
	?>
	<?php
		$tags_list = get_the_tag_list( '<span class="tag-links">', __( ' ', 'freedom' ), '</span>' );
		if ( $tags_list ) echo $tags_list;
	?>
	<?php
	echo '</div>';
}
endif;


if ( ! function_exists( 'freedom_home_entry_meta' ) ) :
/**
 * Shows post meta information in photo blogging view for archives.
 */
function freedom_home_entry_meta() {
	echo '<div class="entry-meta">';

	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
   if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
      $time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
   }
   $time_string = sprintf( $time_string,
      esc_attr( get_the_date( 'c' ) ),
      esc_html( get_the_date() ),
      esc_attr( get_the_modified_date( 'c' ) ),
      esc_html( get_the_modified_date() )
   );
	printf( __( '<span class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark"><i class="fa fa-calendar-o"></i> %3$s</a></span>', 'freedom' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		$time_string
	);

	$categories_list = get_the_category_list( __( ', ', 'freedom' ) );
		if ( $categories_list )	printf( __( '<span class="cat-links"><i class="fa fa-folder-open"></i>%1$s</span>', 'freedom' ), $categories_list );

	echo '</div>';
}
endif;

/****************************************************************************************/

/**
 * Generate darker color
 * Source: http://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
 */
function freedom_darkcolor($hex, $steps) {
   // Steps should be between -255 and 255. Negative = darker, positive = lighter
   $steps = max(-255, min(255, $steps));

   // Normalize into a six character long hex string
   $hex = str_replace('#', '', $hex);
   if (strlen($hex) == 3) {
      $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
   }

   // Split into three parts: R, G and B
   $color_parts = str_split($hex, 2);
   $return = '#';

   foreach ($color_parts as $color) {
      $color   = hexdec($color); // Convert to decimal
      $color   = max(0,min(255,$color + $steps)); // Adjust color
      $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
   }

   return $return;
}

/****************************************************************************************/

add_action('wp_head', 'freedom_custom_css');
/**
 * Hooks the Custom Internal CSS to head section
 */
function freedom_custom_css() {
	$freedom_internal_css = '';

	$primary_color = get_theme_mod( 'freedom_primary_color', '#46c9be' );
	$primary_dark    = freedom_darkcolor($primary_color, -50);
	if( $primary_color != '#46c9be' ) {

		$freedom_internal_css .= ' .feedom-button,blockquote,button,input[type=button],input[type=reset],input[type=submit]{background-color:'.$primary_color.'}#site-title a:hover,.next a:hover,.previous a:hover,a{color:'.$primary_color.'}#search-form span{background-color:'.$primary_color.'}.main-navigation a:hover,.main-navigation ul li ul li a:hover,.main-navigation ul li ul li:hover>a,.main-navigation ul li.current-menu-ancestor a,.main-navigation ul li.current-menu-item a,.main-navigation ul li.current-menu-item ul li a:hover,.main-navigation ul li.current_page_ancestor a,.main-navigation ul li.current_page_item a,.main-navigation ul li:hover>a,.site-header .menu-toggle:before{color:'.$primary_color.'}.main-small-navigation li a:hover,.main-small-navigation .current-menu-item a,.main-small-navigation .current_page_item a{background-color:'.$primary_color.'}#featured-slider .entry-title a:hover{color:'.$primary_color.'}#featured-slider .slider-read-more-button a{background-color:'.$primary_color.'}.slider-nav i:hover{color:'.$primary_color.'}.format-link .entry-content a,.pagination span{background-color:'.$primary_color.'}.pagination a span:hover{color:'.$primary_color.';border-color:'.$primary_color.'}#content .comments-area a.comment-edit-link:hover,#content .comments-area a.comment-permalink:hover,#content .comments-area article header cite a:hover,.comments-area .comment-author-link a:hover{color:'.$primary_color.'}.comments-area .comment-author-link span{background-color:'.$primary_color.'}.comment .comment-reply-link:hover,.nav-next a,.nav-previous a{color:'.$primary_color.'}#secondary h3.widget-title{border-bottom:2px solid '.$primary_color.'}#wp-calendar #today{color:'.$primary_color.'}.entry-meta .byline i,.entry-meta .cat-links i,.entry-meta a,.footer-socket-wrapper .copyright a:hover,.footer-widgets-area a:hover,.post .entry-title a:hover,.search .entry-title a:hover,.post-box .entry-meta .cat-links a:hover,.post-box .entry-meta .posted-on a:hover,.post.post-box .entry-title a:hover,a#scroll-up i{color:'.$primary_color.'}.entry-meta .post-format i{background-color:'.$primary_color.'}.entry-meta .comments-link a:hover,.entry-meta .edit-link a:hover,.entry-meta .posted-on a:hover,.entry-meta .tag-links a:hover{color:'.$primary_color.'}.more-link span{background-color:'.$primary_color.'}.single #content .tags a:hover{color:'.$primary_color.'}.no-post-thumbnail{background-color:'.$primary_color.'}@media screen and (max-width:768px){.top-menu-toggle:before{color:'.$primary_color.'}.better-responsive-menu .menu li .sub-toggle:hover{background-color:'.$primary_dark.'}.better-responsive-menu .menu li .sub-toggle {background-color:'.$primary_color.'}} .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce span.onsale {background-color: '.$primary_color.';},.woocommerce ul.products li.product .price .amount,.entry-summary .price .amount,.woocommerce .woocommerce-message::before{color: '.$primary_color.';} .woocommerce .woocommerce-message { border-top-color: '.$primary_color.';}';
	}

	if( !empty( $freedom_internal_css ) ) {
		echo '<!-- '.get_bloginfo('name').' Internal Styles -->';
		?><style type="text/css"><?php echo $freedom_internal_css; ?></style>
<?php
	}

	$freedom_custom_css = get_theme_mod( 'freedom_custom_css' );
	if( $freedom_custom_css && ! function_exists( 'wp_update_custom_css_post' ) ) {
		echo '<!-- '.get_bloginfo('name').' Custom Styles -->';
		?><style type="text/css"><?php echo $freedom_custom_css; ?></style><?php
	}
}

/**************************************************************************************/

add_filter('the_content_more_link', 'freedom_remove_more_jump_link');
/**
 * Removing the more link jumping to middle of content
 */
function freedom_remove_more_jump_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}

/**************************************************************************************/

if ( ! function_exists( 'freedom_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function freedom_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h3 class="screen-reader-text"><?php _e( 'Post navigation', 'freedom' ); ?></h3>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'freedom' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'freedom' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'freedom' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'freedom' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // freedom_content_nav

/**************************************************************************************/

if ( ! function_exists( 'freedom_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function freedom_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'freedom' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'freedom' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 74 );
					printf( '<div class="comment-author-link"><i class="fa fa-user"></i>%1$s%2$s</div>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'freedom' ) . '</span>' : ''
					);
					printf( '<div class="comment-date-time"><i class="fa fa-calendar-o"></i>%1$s</div>',
						sprintf( __( '%1$s at %2$s', 'freedom' ), get_comment_date(), get_comment_time() )
					);
					printf( '<a class="comment-permalink" href="%1$s"><i class="fa fa-link"></i>Permalink</a>', esc_url( get_comment_link( $comment->comment_ID ) ) );
					edit_comment_link();
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'freedom' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'freedom' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</section><!-- .comment-content -->

		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

/**************************************************************************************/

add_action( 'freedom_footer_copyright', 'freedom_footer_copyright', 10 );
/**
 * function to show the footer info, copyright information
 */
function freedom_footer_copyright() {
	$site_link = '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';
	$wp_link = '<a href="'.esc_url( 'http://wordpress.org' ).'" target="_blank" title="' . esc_attr__( 'WordPress', 'freedom' ) . '"><span>' . __( 'WordPress', 'freedom' ) . '</span></a>';
	$tg_link =  '<a href="'.esc_url( 'https://themegrill.com/themes/freedom' ).'" target="_blank" title="'.esc_attr__( 'ThemeGrill', 'freedom' ).'" ><span>'.__( 'ThemeGrill', 'freedom') .'</span></a>';

	$default_footer_value = __( 'Copyright &copy; ', 'freedom' ). date( 'Y' ).'&nbsp'.$site_link.__( '.&nbsp;Powered by&nbsp;', 'freedom' ).$wp_link.'&nbsp;and&nbsp;'.$tg_link.__( '.', 'freedom' );
	$freedom_footer_copyright = '<div class="copyright">'.$default_footer_value.'</div>';

	echo $freedom_footer_copyright;
}

/**************************************************************************************/

add_action('admin_init','freedom_textarea_sanitization_change', 100);
/**
 * Override the default textarea sanitization.
 */
function freedom_textarea_sanitization_change() {
   remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
   add_filter( 'of_sanitize_textarea', 'freedom_sanitize_textarea_custom',10,2 );
}

/**
 * sanitize the input for custom css
 */
function freedom_sanitize_textarea_custom( $input,$option ) {
   if( $option['id'] == "freedom_custom_css" ) {
      $output = wp_filter_nohtml_kses( $input );
   } else {
      $output = $input;
   }
   return $output;
}

/**
 * Function to transfer the Header Logo added in Customizer Options of theme to Site Logo in Site Identity section
 */
function freedom_site_logo_migrate() {
	if ( function_exists( 'the_custom_logo' ) && ! has_custom_logo( $blog_id = 0 ) ) {
		$logo_url = get_theme_mod( 'freedom_header_logo_image' );

		if ( $logo_url ) {
			$customizer_site_logo_id = attachment_url_to_postid( $logo_url );
			set_theme_mod( 'custom_logo', $customizer_site_logo_id );

			// Delete the old Site Logo theme_mod option.
			remove_theme_mod( 'freedom_header_logo_image' );
		}
	}
}

add_action( 'after_setup_theme', 'freedom_site_logo_migrate' );

/**************************************************************************************/

/**
 * Migrate any existing theme CSS codes added in Customize Options to the core option added in WordPress 4.7
 */
function freedom_custom_css_migrate() {

	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		$custom_css = get_theme_mod( 'freedom_custom_css' );
		if ( $custom_css ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return = wp_update_custom_css_post( $core_css . $custom_css );
			if ( ! is_wp_error( $return ) ) {
				// Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
				remove_theme_mod( 'freedom_custom_css' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'freedom_custom_css_migrate' );

/**
 * Making the theme Woocommrece compatible
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

add_filter( 'woocommerce_show_page_title', '__return_false' );

add_action('woocommerce_before_main_content', 'freedom_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'freedom_wrapper_end', 10);

function freedom_wrapper_start() {
  echo '<div id="primary">';
}

function freedom_wrapper_end() {
  echo '</div>';
}

// Function to handle the thumbnail request
function get_the_post_thumbnail_src($img)
{
  return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}
function wpvkp_social_buttons($content="") {
    global $post;
    if(is_singular() || is_home()){
    	$shr = "";
    
        // Get current page URL 
        $sb_url = urlencode(get_permalink());
 
        // Get current page title
        $sb_title = str_replace( ' ', '%20', get_the_title());
        
        // Get Post Thumbnail for pinterest
        $sb_thumb = get_the_post_thumbnail_src(get_the_post_thumbnail());
 
        // Construct sharing URL without using any script
        $twitterURL = 'https://twitter.com/intent/tweet?text='.$sb_title.'&amp;url='.$sb_url.'&amp;via=wpvkp';
        $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$sb_url;
        $bufferURL = 'https://bufferapp.com/add?url='.$sb_url.'&amp;text='.$sb_title;
        $whatsappURL = 'whatsapp://send?text='.$sb_title . ' ' . $sb_url;
        $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$sb_url.'&amp;title='.$sb_title;

       if(!empty($sb_thumb)) {
            $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$sb_url.'&amp;media='.$sb_thumb[0].'&amp;description='.$sb_title;
        }
        else {
            $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$sb_url.'&amp;description='.$sb_title;
        }
 
        // Based on popular demand added Pinterest too
        $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$sb_url.'&amp;media='.$sb_thumb[0].'&amp;description='.$sb_title;
        $gplusURL ='https://plus.google.com/share?url='.$sb_title.'';
 
        // Add sharing button at the end of page/page content
        $shr .= '<div class="social-box"><div class="social-btn">';
        $shr .= '<a class="col-1 sbtn s-twitter" href="'. $twitterURL .'" target="_blank" rel="nofollow"><span>Share on twitter</span></a>';
        $shr .= '<a class="col-1 sbtn s-facebook" href="'.$facebookURL.'" target="_blank" rel="nofollow"><span>Share on facebook</span></a>';
        // $shr .= '<a class="col-2 sbtn s-whatsapp" href="'.$whatsappURL.'" target="_blank" rel="nofollow"><span>WhatsApp</span></a>';
        // $shr .= '<a class="col-2 sbtn s-googleplus" href="'.$googleURL.'" target="_blank" rel="nofollow"><span>Google+</span></a>';
        // $shr .= '<a class="col-2 sbtn s-pinterest" href="'.$pinterestURL.'" data-pin-custom="true" target="_blank" rel="nofollow"><span>Pin It</span></a>';
        $shr .= '</div></div>';
        
        return $shr;
    }else{
        return $shr;
    }
};

// Breadcrumbs
function custom_breadcrumbs() {
       
    // Settings
    $separator          = '/';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Homepage';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
           
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul>';
           
    }
       
}