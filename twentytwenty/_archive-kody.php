<?php
get_header();
?>
<!-- kody -->
<header class="category">
	<div class="container">
		<?php 
		if(!is_category() ):
		$category = get_category( get_query_var( 'cat' ) );
		$catslug = str_replace('-','',$category->slug );

		$out = do_shortcode('[global_variable variable_name="HEADER'.strtoupper( ( get_post_type()?get_post_type():$catslug) ).'"]');
		if(strpos( $out , '[mrp_rating_form')!== false)
		 echo "dddddddddddd";
		
		else:
		?>
		
		<div>
		    <strong><?php single_cat_title( ); ?></strong>:
		    <?php echo category_description(); ?>
		</div> 
		<?php endif; ?>
	</div>
</header>

<div class="container">
<main id="site-content" role="main">

<div class="row">
	<div class="col-md-9 col-xs-12 kody">
	<?php

	if ( have_posts() ) {

		$i = 0;

		while ( have_posts() ) {
			$i++;
			the_post();

			get_template_part( 'template-parts/content-blog', get_post_type() );

		}
	}	
	?>

	<?php get_template_part( 'template-parts/pagination' ); ?>
	<div class="bottom-category">
		<?php
			if(is_active_sidebar('bottom-category')){
				dynamic_sidebar('bottom-category');
			}
		?>	
	</div>
	
	</div>
	<div class="col-xs-12 col-md-3">
		<?php
		if(is_active_sidebar('blog-right')){
			dynamic_sidebar('blog-right');
		}
		?>
					
	</div>
</div>


</main><!-- #site-content -->
</div>
<?php
get_footer();