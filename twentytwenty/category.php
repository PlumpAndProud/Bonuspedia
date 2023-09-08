<?php
get_header();
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
			
			$term = get_queried_object();
			$out = get_field('box_header', $term);
			if(!$out)
				$out = do_shortcode('[global_variable variable_name="HEADER'.strtoupper( $catslug ).'"]');
				
				
			if(strpos( $out , '[today_date]')!== false){
				$out = str_replace( '[today_date]', date('d.m.Y'), $out);
			}
			if(strpos( $out , '[acf')!== false)
		 		{
					$start = '\[acf';
					$end  = '\]';
					if (preg_match('#('.$start.')(.*)('.$end.')#si', $out, $match) == 1) {
					    $result_rate = do_shortcode($match[0]);
					}
					
					$out = preg_replace('#('.$start.')(.*)('.$end.')#si', $result_rate, $out);
				}
				
			if(strpos( $out , '[ratings')!== false)
		 		{
					$start = '\[ratings';
					$end  = '\]';
					if (preg_match('#('.$start.')(.*)('.$end.')#si', $out, $match) == 1) {
					    $result_rate = do_shortcode($match[0]);
					}
					
					$out = preg_replace('#('.$start.')(.*)('.$end.')#si', $result_rate, $out);
				}
		 	
		 	
		endif;
		if($out):
			echo $out;
		else:
		?>
			<div>
		    	<strong><?php single_cat_title( ); ?></strong>
			    <?php echo category_description(); ?>
			</div> 
		<?php endif; ?>
	</div>
</header>

<div class="container">
<main id="site-content" role="main">
	<?php
	if($catslug!='blog' and $cat_parent_slug!='blog'):
	?>
		<div class="col-md-12 col-xs-12">
		<h2>
			<?php
				if($category_title)
					echo $category_title;
				else 
					single_cat_title( ); 
					
				$miesiac = array( 'Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień' );
				echo " - ".$miesiac[ (int)date('m')-1 ]." ".date('Y'); 
			?>
		</h2>
		<?php if($category_sub_title) echo "<p>". $category_sub_title ."</p>"; ?>
		</div>
		<div class="col-md-9 col-xs-12 category-blog  type-<?php echo get_post_type() ?>">
		
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
	<div class="col-md-9 col-xs-12 category-blog">
	<?php
	endif;
	?>

	
	<?php
	 if(get_post_type()=='kody'):

				$today = date('Y-m-d H:i:s');
				$posts = new  WP_Query( array(
				    'post_type' 		=> 'kody',
				    'posts_per_page' 	=> 100,
				    'numberposts'      	=> 100,
				    'cat'         		=> 	$category->cat_ID,
				    'meta_key'			=> 'aktywny_do',
					'orderby'			=> 'meta_value',
					'order'				=> 'DESC',
				   	'meta_query' => array(
								        array(
								            'key'     => 'aktywny_do',
								            'compare' => '>',
								            'value'   => $today,
								            'type'	  => 'DATETIME'
								        ),
								        array(
								            'key'     => 'rodzaj',
								            'compare' => '=',
								            'value'   => 'kod'
								        )
								    ),
				));
			
		
		$i = 0;
		echo "<script>var kody_cnt = ".(!empty($posts->post_count)?$posts->post_count:'0').";</script>";
		while ( $posts->have_posts() ) {
			$i++;
			$posts->the_post();
			if($category_template)
				get_template_part( 'template-parts/content-'.$category_template.'-top', get_post_type() );
			else
				get_template_part( 'template-parts/content-blog', get_post_type() );

		}
	else:

	if ( have_posts() ) {
		$i = 0;
		while ( have_posts() ) {
			$i++;
			the_post();
			if($category_template)
				get_template_part( 'template-parts/content-'.$category_template.'-top', get_post_type() );
			else
				get_template_part( 'template-parts/content-blog', get_post_type() );

		}
	}	
	
	endif;
	?>



<!-- Kod dla wyswietlania bonusow -->
<?php
$today = date('Y-m-d H:i:s');
$args = array(
    'post_type' => 'bonus',
    'posts_per_page' => 100,
    'cat' => get_query_var('cat'),
    'meta_key' => 'kiedy_wygasa_test',
    'orderby' => 'meta_value',
    'order' => 'DESC',
    'meta_query' => array(
        array(
            'key' => 'kiedy_wygasa_test',
            'compare' => '>',
            'value' => $today,
            'type' => 'DATETIME'
        )
    )
);

$posts_query = new WP_Query($args);

if ($posts_query->have_posts()) :
    ?>
    <div class="clearfix"></div>
    <h2>
        <?php
        echo _('Bonusy i promocje');
        $miesiac = array('Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień');
        echo " - " . $miesiac[(int)date('m') - 1] . " " . date('Y');
        ?>
    </h2>
    <?php
    if ($category_sub_title) {
        echo "<p>" . $category_sub_title . "</p>";
    }

    while ($posts_query->have_posts()) :
        $posts_query->the_post();
        if ($category_template) {
            get_template_part('template-parts/content-' . $category_template, get_post_type());
        } else {
            get_template_part('template-parts/content-blog', get_post_type());
        }
    endwhile;

    	?>
<?php
endif;

// Przywrócenie oryginalnego zapytania postów
wp_reset_postdata();
?>





<?php if(get_post_type()=='bonus_new'):?>
<!-- section 2 -->
<div class="clearfix"></div>
<h2>
	<?php
	if( get_post_type()=='bonus_new'){
		echo _('Bonusy i promocje');
	}elseif($category_title)
			echo $category_title;
		else 
			single_cat_title( ); 
		$miesiac = array( 'Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień' );
		echo " - ".$miesiac[ (int)date('m')-1 ]." ".date('Y'); 
	?></h2>
<?php if($category_sub_title) echo "<p>". $category_sub_title ."</p>"; ?>
<?php

 if(get_post_type()=='bonus_new'):

				$today = date('Y-m-d H:i:s');
				$posts = new  WP_Query( array(
				    'post_type' 		=> 'bonus_new',
				    'posts_per_page' 	=> 100,
				    'numberposts'      	=> 100,
				    'cat'         		=> 	$category->cat_ID,
				    'meta_key'			=> 'aktywny_do',
					'orderby'			=> 'meta_value',
					'order'				=> 'DESC',
				   	'meta_query' => array(
									   
								        array(
								            'key'     => 'aktywny_do',
								            'compare' => '>',
								            'value'   => $today,
								            'type'	  => 'DATETIME'
								        )
								    ),
				));
		echo "<script>var bonusy_cnt = ".(!empty($posts->post_count)?$posts->post_count:'0').";</script>";
		$i = 0;
		while ( $posts->have_posts() ) {
			$i++;
			$posts->the_post();
			if($category_template)
				get_template_part( 'template-parts/content-'.$category_template, get_post_type() );
			else
				get_template_part( 'template-parts/content-blog', get_post_type() );

		}
else:
	if ( have_posts() ) {
		$i = 0;
		while ( have_posts() ) {
			$i++;
			the_post();
			if($category_template)
				get_template_part( 'template-parts/content-'.$category_template, get_post_type() );
			else
				get_template_part( 'template-parts/content-blog', get_post_type() );

		}
	}	
	get_template_part( 'template-parts/pagination' );
endif;

	?>
<?php endif; ?>
<!-- Koniec kodu do wyswietlania bonusow -->


<!-- section 2 -->

	
	<div class="clearfix"></div>
	<div class="bottom-category ">
	<p>
	<?php 
		$desc = category_description();
		
		$toc = do_shortcode("[prepareToc for='category' id='".$category->cat_ID."' class='blue']");
		
		$lastitems='';
		if(!empty($category->cat_ID))
		{
			
			$today = date('Y-m-d H:i:s');
				$posts_code = new  WP_Query( array(
				    'post_type' 		=> 'kody',
				    'posts_per_page' 	=> 3,
				    'numberposts'      	=> 3,
				    'cat'         		=> 	$category->cat_ID,
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
				$tags = get_the_tags($p->ID );
				$tags_arch='';
 				foreach($tags as $t)
 					$tags_arch.= '<a href="'.get_tag_link( $t->term_id ).'" rel="tag">#'.$t->name.'</a>';
 						
 						
			    	$lastitems.='
			    		<div class="well archive row archive-kody" data-href="'.get_permalink($post->ID).'#showcode-'. $post->ID.'">
			    					    		
								<div class="col-xs-12 col-sm-2">
									<div class="img-box">
									'.get_the_post_thumbnail( $p->ID,'thumbnail', array( 'class' => 'img-thumbnail' ) ).'
									</div>
								</div>
								<div class="col-xs-12 col-sm-8">
								' . '<h2 class="entry-title"><a href="javascript:void(0)" class="main-link read-more-wrap" data-url="'.get_permalink($p->ID) .'" data-id="'.$p->ID.'">'. get_the_title( $p->ID ).'</a></h2>' .'			
								'.get_the_excerpt( $p->ID ).'
									<div class="info">
										<div class="col-sm-6">
										</div>
										<div class="col-sm-6 text-right">
											'.( strlen( get_field( "firma" ) )> 2 ?'<a href="#">#'.get_field( "firma" ).'</a>':'').'
											'.$tags_arch.'
										</div>
									</div>
								</div>
								
								<div class="col-xs-12 col-sm-2 text-center codes">
									<div>
										<span class="btn-code actions main-link read-more-wrap" data-url="'.get_permalink($p->ID).'" data-id="'.$p->ID.'">
											'._('Odkryj kod').'
											<span class="code">'.( strlen(get_field( "kod" ))>2 ? substr(get_field( "kod" ),0,2) : get_field( "kod" ,$p->ID ) ).'</span>
										</span>
									'.(get_field( "details_href" ,$p->ID) ? '<a href="'.get_field( "details_href" , $p->ID ).'" class="more">'._('Poznaj szczegóły').'<i class="fas fa-chevron-down"></i></a>':''). '	
									</div>
								</div>		
						<div class="overlay main-link read-more-wrap" data-url="'.get_permalink($p->ID).'" data-id="'.$p->ID.'""></div>
					</div>'; 
			}
				

		}
		

		
		$category_desc = str_replace('[selfToc]', $toc , $desc);
		$category_desc = str_replace('[GET_ARCHIVE_LAST]', $lastitems, $category_desc);
		$category_desc = after_selfToc( $category_desc );
		
		echo $category_desc;
		
	?></p>
	
	<?php
		if($catslug!='blog' and $cat_parent_slug!='blog' and empty($category_desc))
			if(is_active_sidebar('bottom-category')){
				dynamic_sidebar('bottom-category');
			}
	?>	
	</div>
		
	</div>
	<div class="col-xs-12 col-md-3 category-right <?php echo ($cat_parent_slug?$cat_parent_slug:$catslug) ?>">
		<?php
		$term = get_queried_object();
		$box_1 = get_field('box_1', $term);
		$box_2 = get_field('box_2', $term);
		$box_3 = get_field('box_3', $term);
		$box_4 = get_field('box_4', $term);
		if( !empty($box_1) or !empty($box_2) or !empty($box_3) or !empty($box_4) )
		{
			if(!empty($box_1))
				echo '<div class="box_1">'.$box_1.'</div>';
			if(!empty($box_2))
				echo '<div class="box_2">'.$box_2.'</div>';
			if(!empty($box_3))
				echo '<div class="box_3">'.$box_3.'</div>';
			if(!empty($box_4))
				echo '<div class="box_4">'.$box_4.'</div>';
			
		}elseif(is_active_sidebar($category_template.'-right')){
			dynamic_sidebar($category_template.'-right');
		}else
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