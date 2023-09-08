<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
<div>
	<div class="col-xs-12">
		<div class='well row'>
			<div class='col-xs-12 col-sm-2'>
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
					
				$category_link='';
 				$cat = get_the_category( $post->ID );
				
				if( $cat[0])
 					$category_link = get_category_link($cat[0]);
 		
					
				the_title( '<h2 class="entry-title heading-size-1"><a rel="nofollow" href="'.$category_link.'#showcode-'.$post->ID.'">', '</a></h2>' );
				}
			?>
			
			<?php
			if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
				the_excerpt();
			} else {
				the_content( __( 'Continue reading', 'twentytwenty' ) );
			}
			?>
			
				<div class="info">
					<div class="col-sm-8">
						<?php 
							if (time() < strtotime( get_field( "kiedy_wygasa" )  )) :
							//echo time()." > " .time();
						?>
						<span class="timer"></span>
						<span class="timerTime">Do końca: <span class="countdownme"><?php echo get_field( "kiedy_wygasa" ); ?></span></span>
						<?php
							endif;
						?>
					</div>
					<div class="col-sm-4 text-right">
						<?php if( strlen( get_field( "firma" ) )> 2 ):?>
							<a href="#">#<?php echo get_field( "firma" ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
			
			<div class='col-xs-12 col-sm-2 text-center codes'>
				<div>
				<!--
					<span class="btn-code actions showcode" data-url="<?php get_permalink($post->ID) ?>" data-id="<?php echo $post->ID ?>">
						<?php _e('Odkryj kod'); ?>
						<span class="code"><?php echo ( strlen(get_field( "kod" ))>2 ? substr(get_field( "kod" ),0,2) : get_field( "kod" ) ) ?></span>
					</span>
				-->
				<?php
					$category_link='';
				 	$cat = get_the_category( $post->ID  );
				 	
				 	if( $cat[0])
				 		$category_link = get_category_link($cat[0]);
 		
				?>
				<a rel="nofollow" href="<?php echo $category_link.'#showcode-'. $post->ID; ?>" class=" btn btn-success actions" data-url="<?php get_permalink($post->ID) ?>" data-id="<?php echo $post->ID ?>">
						<?php _e('Odbierz bonus'); ?>
				</a>
					
				<?php if(get_field( "details_href" )): ?>
					<a href="<?php echo get_field( "details_href" ); ?>" class="more"><?php _e('Poznaj szczegóły'); ?> <i class="fas fa-chevron-down"></i></a>
				<?php endif; ?>
					
				</div>
				
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
