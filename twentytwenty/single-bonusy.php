<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
<header class="blog">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</div>
			<div classs="col-md-4 hidden-xs">
			<?php
				if ( ! is_search() ) {
						the_post_thumbnail();
					}
			?>
			</div>
		</div>
	</div>
</header>

<div class="container">
	<div id="primary" class="row">
		<main id="main" class="site-main" role="main">
			<?php
				while ( have_posts() ) :
					the_post();
					?>
				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<?php if ( is_single() ): ?>
					<div class="entry-content">
						<?php
						if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
							the_excerpt();
						} else {
							the_content( __( 'Continue reading', 'twentytwenty' ) );
						}
						?>
					</div><!-- .entry-content -->
					<div class="row">
						<div class='col-md-6'>
							<div class="acf activeto"><?php echo get_field( "jak_odebrac" );?></div>
						</div>
						<div class='col-md-6'>
							<div class="acf activeto"><?php echo get_field( "regulamin" );?></div>
						</div>
					</div>
					<div class="row">
						<div class='col-md-12'>
							<div class="acf activeto"><?php echo get_field( "przyklad" );?></div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 text-center">
							<a href="<?php echo get_field( "cta" );?>" target="_blank" class="btn-more">
								<?php echo get_field( "cta_name" );?>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-md-offset-3">
								<div class="cont text-center">	
									<span class="timer"></span>
									<span class="timerTime">Do końca: <span class='countdownme'><?php echo get_field( "aktywny_do" );?></span></span>
								</div>
						 </div>
					</div>
					<?php endif; ?>		
					</article><!-- .post -->
					<?php endwhile; ?>
		</main>
	</div><!-- .post-inner -->
</div>
	
<?php
	if ( is_single() ) {
		get_template_part( 'template-parts/navigation' );
	}
?>
<?php
get_footer();

