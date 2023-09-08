<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
?>
	
<header class="blog">
	<div class="container">
			<div class="row">
				<div class='col-md-8'>
		    		<h1><?php the_title( ); ?></h1>
		    		<p><?php 
						$content = get_post_field( 'post_content', get_the_ID() );
						$content_parts = get_extended( $content );
						echo $content_parts['main'];
		    		 ?></p>
		    	</div>
		    	<div class='col-md-4'>
		    		<?php echo get_the_post_thumbnail( null, 'medium', array( 'class' => 'alignnone size-medium wp-image-11' ) ); ?>
		    	</div>
			</div> 
	</div>
</header>


	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'single' );

				if ( is_singular( 'attachment' ) ) {
					// Parent post navigation.
					the_post_navigation(
						array(
							/* translators: %s: Parent post link. */
							'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'twentynineteen' ), '%title' ),
						)
					);
				} 


			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
