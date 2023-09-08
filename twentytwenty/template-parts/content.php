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
<div class="container">
<div class='col-xs-12 col-sm-9'>
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">

		<div >

			<?php
			if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
				the_excerpt();
			} else {
				$content = get_the_content( __( 'Continue reading', 'twentytwenty' ) , true);
				$toc='';
				$toc =  do_shortcode("[prepareToc for='post' id='".get_the_ID() ."' class='blue']");
				$content = str_replace('[selfToc]', $toc , $content);
				$content = apply_filters('the_content', $content);
				echo after_selfToc($content);
				
			}
			?>
		</div><!-- .entry-content -->
	</div><!-- .post-inner -->

</article><!-- .post -->
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