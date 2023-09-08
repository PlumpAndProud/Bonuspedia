	<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
?>

			<header class="category">
				<div class="container">
					<h1 class="page-title">
						<?php _e( 'Wyniki dla: ', 'twentynineteen' ); ?>
						<span class="page-description"><?php echo get_search_query(); ?></span>
					</h1>
				</div>
			</header><!-- .page-header -->


<div class="container">
	<main id="site-content" role="main">
		<div class="row">

		<div class="col-md-9 col-xs-12 category-blog">
		<?php if ( have_posts() ) : ?>


			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content-blog', get_post_type() );

				// End the loop.
			endwhile;

	

			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content-blog', get_post_type() );

		endif;
		?>
		</div>
		
		<div class="col-xs-12 col-md-3 category-right <?php echo ($cat_parent_slug?$cat_parent_slug:$catslug) ?>">
		<?php
			if(is_active_sidebar($category_template.'-right')){
				dynamic_sidebar($category_template.'-right');
			}else
				if(is_active_sidebar('blog-right')){
					dynamic_sidebar('blog-right');
				}
		?>		
		</div>
		
		
		</div>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
