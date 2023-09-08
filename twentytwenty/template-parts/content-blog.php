<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */

?>


<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
<div class='row'>
	<div class="col-xs-12">
		<div class='well row'>
			<div class='col-xs-12 col-sm-4'>
				<div class="img-box">
				<?php
				if ( ! is_search() ) {
						the_post_thumbnail('thumbnail', array( 'class' => 'img-thumbnail' ) );

						$caption = get_the_post_thumbnail_caption();

						if ( $caption ) {
							?>

							<figcaption class="wp-caption-text"><?php echo esc_html( $caption ); ?></figcaption>

							<?php
						}
					}
				?>
				</div>
			</div>
			<div class='col-xs-12 col-sm-8'>
			<?php
			if ( is_singular() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
				} else {
				the_title( '<h2 class="entry-title heading-size-1"><a href="'.get_permalink($post->ID).'" class="main-link read-more-wrap">', '</a></h2>' );
				}
			?>
			<div class="info">
				<span><i class="far fa-calendar-alt"></i> <?php echo get_the_date(); ?></span>
				<span><i class="far fa-user"></i> <?php
				$author_id = get_post_field ('post_author');
				$display_name = get_the_author_meta( 'display_name' , $author_id ); 
				echo $display_name;
				?></span>
				<span><?php
					$categories = get_the_category();
					if ( !empty($categories) )
						foreach( $categories as $c  ) {
							if( $c->slug!='blog')
					    		echo '<a href="' . esc_url( get_category_link( $c->term_id ) ) . '">' . esc_html( $c->name ) . '</a>';
						}
					?></span>
				
				

			</div>
			<?php
			if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
				the_excerpt();
			} else {
				the_content( __( 'Continue reading', 'twentytwenty' ) );
			}
			?>
			</div>
		</div>
	</div>
</div>
	<?php
	if ( is_single() ) {

		get_template_part( 'template-parts/navigation' );

	}
	/**
	 *  Output comments wrapper if it's a post, or if comments are open,
	 * or if there's a comment number – and check for password.
	 * */
	if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
		?>
		<div class="comments-wrapper section-inner">
			<?php comments_template(); ?>
		</div><!-- .comments-wrapper -->
		<?php
	}
	?>
</article><!-- .post -->
