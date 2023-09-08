<?php
/**
 * Header file for the Twenty Twenty WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="google-site-verification" content="AtqcZJSHrwNMmEsBRAeTyl5nfk2EJljwbexiZMYH_uQ" />
		<link rel="profile" href="https://gmpg.org/xfn/11">
		<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap&subset=latin-ext" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,900&display=swap" rel="stylesheet">
		
		<?php wp_head(); ?>
<script>
	var cy_tdir ='<?php echo get_template_directory_uri() ?>';
	
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-167420831-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-167420831-1');
</script>

<?php 

	if(is_archive()){
		global $wp;
		$thisurl = home_url(add_query_arg(array(), $wp->request));

		echo '<link rel="canonical" href="' . $thisurl . '" />';
	}

?>

	</head>

	<body <?php body_class(); ?>>

		<?php
		wp_body_open();
		?>


		<header id="site-header" class="header-footer-group container" role="banner">

			<div class="header-inner section-inner">

				<div class="header-titles-wrapper col-md-4">

					<?php

					// Check whether the header search is activated in the customizer.
					$enable_header_search = get_theme_mod( 'enable_header_search', true );

					if ( true === $enable_header_search ) {

						?>

						<button class="toggle search-toggle mobile-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
							<span class="toggle-inner">
								<span class="toggle-icon">
									<?php twentytwenty_the_theme_svg( 'search' ); ?>
								</span>
								<!-- <span class="toggle-text"><?php _e( 'Search', 'twentytwenty' ); ?></span> -->
							</span>
						</button><!-- .search-toggle -->

					<?php } ?>

					<div class="header-titles theme-logo">
						<?php
						if ( has_custom_logo() ) {
						      the_custom_logo();
						} else {
						        echo '<a href="/" class="logo"><h1>'. get_bloginfo( 'name' ) .'</h1></a>';
						}
						?>
					</div><!-- .header-titles -->


					<button class="toggle nav-toggle mobile-nav-toggle" data-toggle-target=".menu-modal"  data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
						<span class="toggle-inner">
							<span class="toggle-icon">
								<?php twentytwenty_the_theme_svg( 'ellipsis' ); ?>
							</span>
							<!--	<span class="toggle-text"><?php _e( 'Menu', 'twentytwenty' ); ?></span> -->
						</span>
					</button><!-- .nav-toggle -->

				</div><!-- .header-titles-wrapper -->

				<div class="header-navigation-wrapper">

					<?php
					if ( has_nav_menu( 'primary' ) || ! has_nav_menu( 'expanded' ) ) {
						?>
							<nav class="primary-menu-wrapper" aria-label="<?php esc_attr_e( 'Horizontal', 'twentytwenty' ); ?>" role="navigation">

								<ul class="primary-menu reset-list-style">
								<?php
								if ( has_nav_menu( 'primary' ) ) {

									wp_nav_menu(
										array(
											'container'  => '',
											'items_wrap' => '%3$s',
											'theme_location' => 'primary',
										)
									);
								} elseif ( ! has_nav_menu( 'expanded' ) ) {
									wp_list_pages(
										array(
											'match_menu_classes' => true,
											'show_sub_menu_icons' => true,
											'title_li' => false,
											'walker'   => new TwentyTwenty_Walker_Page(),
										)
									);
								}
								?>
								</ul>

							</nav><!-- .primary-menu-wrapper -->
							
							<?php
								get_search_form(
									array(
										'label' => __( 'Search for:', 'twentytwenty' ),
									)
								);
								?>
						<?php
					}
?> <div class="responsive"> <?php
					if ( true === $enable_header_search || has_nav_menu( 'expanded' ) ) {
						?>
						<div class="header-toggles hide-no-js">

						<?php
						if ( has_nav_menu( 'expanded' ) ) {
							?>

							<div class="toggle-wrapper nav-toggle-wrapper has-expanded-menu">

								<button class="toggle nav-toggle desktop-nav-toggle" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
									<span class="toggle-inner">
										<span class="toggle-text"><?php _e( 'Menu', 'twentytwenty' ); ?></span>
										<span class="toggle-icon">
											<?php twentytwenty_the_theme_svg( 'ellipsis' ); ?>
										</span>
									</span>
								</button><!-- .nav-toggle -->

							</div><!-- .nav-toggle-wrapper -->

							<?php
						}

						if ( true === $enable_header_search ) {
							?>

							<div class="toggle-wrapper search-toggle-wrapper">

								<button class="toggle search-toggle desktop-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
									<span class="toggle-inner">
										<?php twentytwenty_the_theme_svg( 'search' ); ?>
										<span class="toggle-text"><?php _e( 'Search', 'twentytwenty' ); ?></span>
									</span>
								</button><!-- .search-toggle -->

							</div>

							<?php
						}
						?>
</div>
						</div><!-- .header-toggles -->
						<?php
					}
					?>

				</div><!-- .header-navigation-wrapper -->

			</div><!-- .header-inner -->

			<?php
			// Output the search modal (if it is activated in the customizer).
			 if ( true === $enable_header_search ) {
				get_template_part( 'template-parts/modal-search' );
			 }
			?> 

		</header><!-- #site-header -->
<?php
		if ( is_front_page() ) :
else :
	if ( function_exists('yoast_breadcrumb') ) {
		echo '<div class="container" id="breadcrumbs-wrapper">';
  yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
		
		$modifyDate = get_the_modified_date('d.m.Y');
		
		if($modifyDate != false) {
				
			echo '<p id="breadcrumbs-date">Data aktualizacji: ' . $modifyDate. '</p>';
			
		} else {
			
			$modifyDate = get_the_date('d.m.Y');
			echo '<p id="breadcrumbs-date">Data publikacji: ' . $modifyDate. '</p>';
			
		}
		
		echo '</div>';
}
endif;

		
		// Output the menu modal.
		get_template_part( 'template-parts/modal-menu' );

