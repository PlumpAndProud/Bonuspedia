<?php
$output='<div class="blog-links-right">';
 foreach( $recent_posts as $recent ){
 	$field_acf = [];
 	$output_tags = [];
 	$article_class=[];
 	
 
 	if($type=='bonus')
 	{
		if( empty($field_acf['aktywny_do']) )
			$article_class[]='inactive';
		if (time() >= strtotime($field_acf['aktywny_do'])) {
			$article_class[]='inactive';
		}	
	}
 	$article_class = array_unique( $article_class );
 	
$output.='<div><a href="'.get_permalink( $recent['ID'] ).'" title="'.esc_attr($recent["post_title"]).'">'.esc_attr($recent["post_title"]).'</a></div>
';
}

$output.="</div>";
 	