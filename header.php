<?php
/**
 * Theme Header Section for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main" class="clearfix"> <div class="inner-wrap">
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<!-- Chrome, Firefox OS and Opera -->
<meta content='#f39c12' name='theme-color'/>
<!-- Windows Phone -->
<meta content='#f39c12' name='msapplication-navbutton-color'/>
<!-- iOS Safari -->
<meta content='yes' name='apple-mobile-web-app-capable'/>
<meta content='#f39c12' name='apple-mobile-web-app-status-bar-style'/>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<?php
/**
 * This hook is important for wordpress plugins and other many things
 */
wp_head();
?>
</head>

<body <?php body_class(); ?>>
<?php	do_action( 'before' ); ?>
<div id="page" class="hfeed site">
	<?php do_action( 'freedom_before_header' ); ?>
	<header id="masthead" class="site-header clearfix">
		<div id="header-text-nav-container" class="clearfix">
			<div class="inner-wrap">
				<div id="header-text-nav-wrap" class="clearfix">
					<div id="header-left-section">
						<?php
						if( ( get_theme_mod( 'freedom_show_header_logo_text', 'text_only' ) == 'both' || get_theme_mod( 'freedom_show_header_logo_text', 'text_only' ) == 'logo_only' ) ) {
						?>
							<div id="header-logo-image">

							<?php if (function_exists('the_custom_logo') && has_custom_logo( $blog_id = 0 )) {
								the_custom_logo();
							}
							elseif ( get_theme_mod('freedom_header_logo_image', '') != '') { ?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo get_theme_mod( 'freedom_header_logo_image', '' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
							<?php } ?>

							</div><!-- #header-logo-image -->
						<?php
						}
                  		$screen_reader = '';
						if( get_theme_mod( 'freedom_show_header_logo_text', 'text_only' ) == 'logo_only' || get_theme_mod( 'freedom_show_header_logo_text', 'text_only' ) == 'none' ) {
								$screen_reader = 'screen-reader-text';
						}
						?>
						<div id="header-text" class="<?php echo $screen_reader; ?>">
						<?php
							if ( is_front_page() || is_home() ) : ?>
   							<h1 id="site-title">
   								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
   							</h1>
							<?php else : ?>
   							<h3 id="site-title">
   								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
   							</h3>
							<?php endif;?>
						</div><!-- #header-text -->
					</div><!-- #header-left-section -->
					<div id="header-right-section">
						<?php //get_search_form(); ?>
						<form action="/" id="search-form" class="searchform clearfix" method="get">
							<input placeholder="Cari apa?" class="s field" name="s" type="text">
							<input value="Search" class="search-submit submit" name="submit" type="submit">
						</form>
			    </div><!-- #header-right-section -->
			   </div><!-- #header-text-nav-wrap -->
			</div><!-- .inner-wrap -->

			<?php freedom_render_header_image(); ?>

			<nav id="indtens-navigation" class="main-navigation clearfix" role="navigation">
				<div class="inner-wrap clearfix">
					<p class="menu-toggle"><?php _e( 'Menu', 'freedom' ); ?></p>
					<?php
						if ( has_nav_menu( 'primary' ) ) {
							wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'menu-primary-container' ) );
						}
						else {
							wp_page_menu();
						}
					?>
				</div>
			</nav>

		</div><!-- #header-text-nav-container -->

		<?php
   	if( get_theme_mod( 'freedom_activate_slider', '0' ) == '1' ) {
			if ( is_front_page() ) {
   			freedom_featured_image_slider();
			}
   	}
   	?>

	</header>
	<?php do_action( 'freedom_after_header' ); ?>
	<?php do_action( 'freedom_before_main' ); ?>
	<div id="main" class="clearfix">
		<div class="inner-wrap clearfix">
		
			<?php
				if ( is_front_page() == false ) {
					echo '<div class="head-post">';
	   				if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.					

						the_post_thumbnail( 'full' );
						echo '<header class="indtens-title"><h1 class="indtens-title">';
							the_title();
						echo '</h1> </header>';
						$categories_list = get_the_category_list();
						if ( $categories_list ) {
							echo "<div class='categories_list'>".$categories_list."</div>";
						}									
						echo "<div class='img-caption'>".get_post(get_post_thumbnail_id())->post_excerpt."</div>";
					}
					echo "</div>";
				}
				
			?>
		
