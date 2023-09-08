<?php
$output='<div class="elementor-shortcode"><div class="latest-post-selection">';
 foreach( $recent_posts as $recent ){
 	$recent= (array)$recent;
 	
 	$field_acf = [];
 	$output_tags = [];
 	$article_class=[];
 	
 	$tags = get_the_tags( $recent['ID'] );
 	foreach($tags as $t)
 		$output_tags[].= '<a href="'.get_tag_link( $t->term_id ).'" rel="tag">#'.$t->name.'</a>';
 	
 	$field_acf['kiedy_wygasa_test'] = get_field( "kiedy_wygasa_test", $recent['ID'] );
 	
 	if($type=='bonus' or $type='kody')
 	{
		if( empty($field_acf['kiedy_wygasa_test']))
			$article_class[]='inactive';
		if (time() >= strtotime($field_acf['kiedy_wygasa_test'])) {
			$article_class[]='inactive';
		}
	}
 	$article_class = array_unique( $article_class );
 	
 	$category_link='';
 	$cat = get_the_category( $recent['ID']  );
 	
 	if( $cat[0])
 		$category_link = get_category_link($cat[0]);
 	$timer='';
	 if (!empty($field_acf['kiedy_wygasa_test']) && time() < strtotime($field_acf['kiedy_wygasa_test'])) {
		 $endDate = strtotime($field_acf['kiedy_wygasa_test']);
		 $fourteenDaysLater = strtotime('+14 days');

		 if ($endDate > $fourteenDaysLater) {
			 $timer='<div class="col-sm-12 col-md-12  col-xl-6  col-lg-8 cont text-center">	
						</div>';
		 } else {
			 $timer='<div class="col-sm-12 col-md-12  col-xl-6  col-lg-8 cont text-center">	
							<span class="timer"></span>
							<span class="timerTime">Do końca: <span  class="countdownme">'.$field_acf['kiedy_wygasa_test'].'</span></span>
						</div>';
		 }
	 } else {
		 $timer='<div class="col-sm-12 col-md-12 col-lg-8 col-xl-6 cont text-center">	
					<span class="timer"></span>
					<span class="">Oferta wygasła</span></span>
				</div>';
	 }
 		
$output.='<article class="'.implode(' ',$article_class).'">
		
		<div class="imgart">'.get_the_post_thumbnail( $recent['ID'], array( 200, 200)  ).'</div>
		<span class="item-title-tag"><a rel="nofollow" href="'.get_permalink($recent['ID']).'" class="main-link " title="'.esc_attr($recent["post_title"]).'">'.esc_attr($recent["post_title"]).'</a></span>
		<p>'.wp_trim_words($recent['post_content'] , 20).'</p>'.$timer.'
		
		
		
			<div class="tags_home col-sm-12 col-md-12 col-lg-4 col-xl-6">
				'.implode("\n", $output_tags).'
			</div>
		
		<a rel="nofollow" href="'.get_permalink($recent['ID']).'" data-id="'.$recent['ID'].'" class="main-link " title="'.esc_attr($recent["post_title"]).'"><span class="read-more ">'.$linktext.'</span></a>
		
		<div class="clear"></div>
		'.(in_array( 'inactive', $article_class)?'<a href="'.get_permalink($recent['ID']).'">':'').'
		<div class="over"></div>
		'.(in_array( 'inactive', $article_class)?'</a>':'').'
		</article>
';
}
//'#showcode-'. $recent['ID'] .
$output.="</div></div>";
 	