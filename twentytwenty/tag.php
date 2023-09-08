<?php
get_header();
$tag = get_queried_object();
?>

<header class="category">
	<div class="container">
		<?php 
		if(is_category() ):
			$category = get_category( get_query_var( 'cat' ) );
			if($cat_parent = get_category( $category->parent ) )
				$cat_parent_slug = $cat_parent->slug;
				
			if( !empty($category->term_id )){
				$category_title = strlen( get_term_meta( $category->term_id, '_pagetitle', true ))>2 ? get_term_meta( $category->term_id, '_pagetitle', true ) : null ;
				$category_sub_title = strlen( get_term_meta( $category->term_id, '_pagesubtitle', true ))>2 ?  get_term_meta( $category->term_id, '_pagesubtitle', true ) : null ;
				$category_template = strlen( get_term_meta( $category->term_id, '_pagetemplate', true ))>2 ? get_term_meta( $category->term_id, '_pagetemplate', true ) : null ;
		
			}	
			$catslug = str_replace('-','',$category->slug );
			echo '<!-- HEADER'.strtoupper( $catslug )." --> \n";
			$out = do_shortcode('[global_variable variable_name="HEADER'.strtoupper( $catslug ).'"]');
		endif;
		
		if($out):
			echo $out;
		else:
		?>
			<div>
		    	<h1><?php single_cat_title( ); ?></h1>
			    <p><?php echo category_description(); ?></p>
			</div> 
		<?php endif; ?>
	</div>
</header>

<div class="container">
<main id="site-content" role="main">
<div class="row">
<div class="col-md-9 col-xs-12 category-blog">
<div>
<?php
	if($catslug!='blog' and $cat_parent_slug!='blog'):
		?>
		
		<h2 class="bonusy">
			<?php
				if($category_title)
					echo $category_title;
				else 
					single_cat_title( ); 
					
				$miesiac = array( 'Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień' );
				echo " - ".$miesiac[ (int)date('m')-1 ]." ".date('Y'); 
			?>
		</h2>
		<p><?php echo get_field('opis_dodatkowy', $tag); ?></p>
		<?php
	else:
	
		if(!empty($category->parent) )
			$categories=get_categories(
			    array( 'parent' => $cat_parent->cat_ID )
			);
		else
			$categories=get_categories(
			    array( 'parent' => $category->cat_ID )
			);
	?>
	
	<div class="blog-categories">
		<b><?php _e( 'Categories'); ?>:</b>
			<?php foreach($categories as $cat):?>
				<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ) ?>"><?php echo $cat->name; ?></a>
			<?php endforeach; ?>
	</div>
	
	<?php
	endif;
	?>
	</div>
	
	<?php
			$today = date('Y-m-d H:i:s');
			$posts = new  WP_Query( array(
					'post_type' 		=> 'kody',
					'numberposts'      	=> 10,
					'tag'         		=> $tag->slug,
				    'meta_key'			=> 'aktywny_do',
					'orderby'			=> 'meta_value',
					'order'				=> 'DESC',
				   	'meta_query' => array(
				   						'relation' => 'AND',
								        array(
								            'key'     => 'aktywny_do',
								            'compare' => '>=',
								            'value'   => $today,
								            'type'	  => 'DATETIME'
								        ),
								        array(
								            'key'     => 'rodzaj',
								            'compare' => '=',
								            'value'   => 'bonus'
								        )
								    ),
				));
	
	if ( $posts->have_posts() ) {
		$i = 0;
		while ( $posts->have_posts() ) {
			$i++;
			$posts->the_post();
			get_template_part( 'template-parts/content-tag', $posts->get_post_type() );
		}
	}
	?>

	<?php get_template_part( 'template-parts/pagination' ); ?>
	<div class="clearfix"></div>
	<div class="bottom-category ">
	<?php
		
		$lastitems='';
		if(!empty( $tag->slug ))
			{
				$today = date('Y-m-d H:i:s');
				$posts_code = new  WP_Query( array(
					'post_type' 		=> 'kody',
					'numberposts'      	=> 3,
					'tag'         		=> $tag->slug,
				    'meta_key'			=> 'aktywny_do',
					'orderby'			=> 'meta_value',
					'order'				=> 'DESC',
				   	'meta_query' => array(
				   						'relation' => 'AND',
								        array(
								            'key'     => 'aktywny_do',
								            'compare' => '<',
								            'value'   => $today,
								            'type'	  => 'DATETIME'
								        ),
								        array(
								            'key'     => 'rodzaj',
								            'compare' => '=',
								            'value'   => 'bonus'
								        )
								    ),
				));
				
			while ( $posts_code->have_posts() ) {
				$i++;
				$posts_code->the_post();
			    	$lastitems.='
			    		<div class="well archive row archive-kody" data-href="'.get_permalink($post->ID).'#showcode-'. $post->ID.'">
			    					    		
								<div class="col-xs-12 col-sm-2">
									<div class="img-box">
									'.get_the_post_thumbnail( $post->ID,'thumbnail', array( 'class' => 'img-thumbnail' ) ).'
									</div>
								</div>
								<div class="col-xs-12 col-sm-8">
								' . '<h2 class="entry-title"><a href="javascript:void(0)" class="main-link read-more-wrap" data-url="'.get_permalink($post->ID) .'" data-id="'.$post->ID.'">'. get_the_title( $post->ID ).'</a></h2>' .'			
								'.get_the_excerpt( $post->ID ).'
									<div class="info">
										<div class="col-sm-6">
										</div>
										<div class="col-sm-6 text-right">
											<a href="#">#'. get_field( "firma" , $post->ID ).'</a>
										</div>
									</div>
								</div>
								
								<div class="col-xs-12 col-sm-2 text-center codes">
									<div>
										<span class="btn-code actions main-link read-more-wrap" data-url="'.get_permalink($post->ID).'" data-id="'.$post->ID.'">
											'._('Odkryj kod').'
											<span class="code">'.( strlen(get_field( "kod" ))>2 ? substr(get_field( "kod" ),0,2) : get_field( "kod" ,$post->ID ) ).'</span>
										</span>
									'.(get_field( "details_href" ,$post->ID) ? '<a href="'.get_field( "details_href" , $post->ID ).'" class="more">'._('Poznaj szczegóły').'<i class="fas fa-chevron-down"></i></a>':''). '	
									</div>
								</div>		
						<div class="overlay main-link read-more-wrap" data-url="'.get_permalink($post->ID).'" data-id="'.$post->ID.'""></div>
					</div>'; 
			}
				

		}
		
		
		$box_tag = get_field('box_tag', $tag);
		if( !empty($box_tag) )
		{
			$bottom_category = str_replace('[GET_ARCHIVE_LAST]', $lastitems, $box_tag);
			
			$toc = do_shortcode("[prepareToc for='tag' id='".$tag->slug ."' class='blue']");
			$bottom_category = str_replace('[selfToc]', $toc , $bottom_category);	
						
			echo '<div class="box_tag_opis">'.after_selfToc( $bottom_category ).'</div>';
			
		}elseif(is_active_sidebar('bottom-category')){
			
				ob_start();
					dynamic_sidebar('bottom-category');
					$bottom_category = ob_get_contents();
				ob_end_clean();

				$bottom_category = str_replace('[GET_ARCHIVE_LAST]', $lastitems, $bottom_category);
				echo $bottom_category;
			}
	?>	
	</div>
		
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
<div class="row">
	<div class="col-xs-12 col-md-12">
		
	</div>
</div>


</main><!-- #site-content -->
</div>
<?php
get_footer();