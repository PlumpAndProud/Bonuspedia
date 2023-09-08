<?php
/*
update_option( 'siteurl', 'http://bonuspedia.pl' );
update_option( 'home', 'http://bonuspedia.pl' );
*/
function twentytwenty_theme_support() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Custom background color.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f5efe0',
		)
	);

	// Set content-width.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 580;
	}

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );
	add_image_size( 'twentytwenty-fullscreen', 1980, 9999 );
	$logo_width  = 120;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if ( get_theme_mod( 'retina_logo', false ) ) {
		$logo_width  = floor( $logo_width * 2 );
		$logo_height = floor( $logo_height * 2 );
	}

	add_theme_support(
		'custom-logo',
		array(
			'height'      => $logo_height,
			'width'       => $logo_width,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_theme_support( 'title-tag' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);

	load_theme_textdomain( 'twentytwenty' );
	add_theme_support( 'align-wide' );
	if ( is_customize_preview() ) {
		require get_template_directory() . '/inc/starter-content.php';
		add_theme_support( 'starter-content', twentytwenty_get_starter_content() );
	}
	add_theme_support( 'customize-selective-refresh-widgets' );

}
add_action( 'after_setup_theme', 'twentytwenty_theme_support' );


function twentytwenty_custom_logo_setup() {
	 $defaults = array(
	 'height'      => 100,
	 'width'       => 400,
	 'flex-height' => true,
	 'flex-width'  => true,
	 'header-text' => array( 'site-title', 'site-description' ),
	 );
	 add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'twentytwenty_custom_logo_setup' );

require get_template_directory() . '/inc/template-tags.php';

require get_template_directory() . '/classes/class-twentytwenty-svg-icons.php';
require get_template_directory() . '/inc/svg-icons.php';
require get_template_directory() . '/classes/class-twentytwenty-customize.php';
require get_template_directory() . '/classes/class-twentytwenty-separator-control.php';

/**
 * Register and Enqueue Styles.
 */
function twentytwenty_register_styles() {
	$theme_version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'twentytwenty-style', get_stylesheet_uri(), array(), $theme_version );
	wp_style_add_data( 'twentytwenty-style', 'rtl', 'replace' );
	wp_enqueue_style( 'twentytwenty-print-style', get_template_directory_uri() . '/print.css', null, $theme_version, 'print' );
	wp_enqueue_style( 'boostrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', null, $theme_version );
	wp_enqueue_style( 'fonts', get_template_directory_uri() . '/assets/css/all.min.css', null, $theme_version );
	wp_enqueue_style( 'custom', get_template_directory_uri() . '/custom.css', null, $theme_version );
	

}

add_action( 'wp_enqueue_scripts', 'twentytwenty_register_styles' );

/**
 * Register and Enqueue Scripts.
 */
function twentytwenty_register_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'twentytwenty-js', get_template_directory_uri() . '/assets/js/index.js', array(), $theme_version, false );
	wp_script_add_data( 'twentytwenty-js', 'async', true );

	wp_enqueue_script( 'boostrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), $theme_version, true ); 	
	wp_enqueue_script( 'countdown', get_template_directory_uri() . '/assets/js/jquery.countdown.min.js', array(), $theme_version, true ); 	
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/assets/js/custom.js', array(), $theme_version, true ); 
	
}

add_action( 'wp_enqueue_scripts', 'twentytwenty_register_scripts' );


function twentytwenty_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'twentytwenty_skip_link_focus_fix' );


function twentytwenty_menus() {

	$locations = array(
		'primary'  => __( 'Desktop Horizontal Menu', 'twentytwenty' ),
		'expanded' => __( 'Desktop Expanded Menu', 'twentytwenty' ),
		'mobile'   => __( 'Mobile Menu', 'twentytwenty' ),
		'footer'   => __( 'Footer Menu', 'twentytwenty' ),
		'social'   => __( 'Social Menu', 'twentytwenty' ),
	);

	register_nav_menus( $locations );
}

add_action( 'init', 'twentytwenty_menus' );


function twentytwenty_get_custom_logo( $html ) {

	$logo_id = get_theme_mod( 'custom_logo' );

	if ( ! $logo_id ) {
		return $html;
	}

	$logo = wp_get_attachment_image_src( $logo_id, 'full' );

	if ( $logo ) {
		// For clarity.
		$logo_width  = esc_attr( $logo[1] );
		$logo_height = esc_attr( $logo[2] );

		// If the retina logo setting is active, reduce the width/height by half.
		if ( get_theme_mod( 'retina_logo', false ) ) {
			$logo_width  = floor( $logo_width / 2 );
			$logo_height = floor( $logo_height / 2 );

			$search = array(
				'/width=\"\d+\"/iU',
				'/height=\"\d+\"/iU',
			);

			$replace = array(
				"width=\"{$logo_width}\"",
				"height=\"{$logo_height}\"",
			);

			// Add a style attribute with the height, or append the height to the style attribute if the style attribute already exists.
			if ( strpos( $html, ' style=' ) === false ) {
				$search[]  = '/(src=)/';
				$replace[] = "style=\"height: {$logo_height}px;\" src=";
			} else {
				$search[]  = '/(style="[^"]*)/';
				$replace[] = "$1 height: {$logo_height}px;";
			}

			$html = preg_replace( $search, $replace, $html );

		}
	}

	return $html;

}

add_filter( 'get_custom_logo', 'twentytwenty_get_custom_logo' );

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backwards compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}


/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentytwenty_sidebar_registration() {

	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
	);
	// Footer #1.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #1', 'twentytwenty' ),
				'id'          => 'sidebar-1',
				'description' => __( 'Widgets in this area will be displayed in the first column in the footer.', 'twentytwenty' ),
			)
		)
	);
	// Footer #2.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #2', 'twentytwenty' ),
				'id'          => 'sidebar-2',
				'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'twentytwenty' ),
			)
		)
	);
	// Footer #3.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #3', 'twentytwenty' ),
				'id'          => 'sidebar-3',
				'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'twentytwenty' ),
			)
		)
	);
	// Footer #3.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Blog Rigth', 'twentytwenty' ),
				'id'          => 'blog-right',
				'description' => __( 'Widgets in this area will be displayed on right column in blog', 'twentytwenty' ),
			)
		)
	);
	
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Codes Rigth', 'twentytwenty' ),
				'id'          => 'kody-right',
				'description' => __( 'Widgets in this area will be displayed on right column in codes', 'twentytwenty' ),
			)
		)
	);
	
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Bonus Rigth', 'twentytwenty' ),
				'id'          => 'bonusy-right',
				'description' => __( 'Widgets in this area will be displayed on right column in Bonuses', 'twentytwenty' ),
			)
		)
	);
	
	// Footer #3.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Bottom category', 'twentytwenty' ),
				'id'          => 'bottom-category',
				'description' => __( 'Widgets in this area will be displayed on bottom of any categories', 'twentytwenty' ),
			)
		)
	);
	

}

add_action( 'widgets_init', 'twentytwenty_sidebar_registration' );


/* 
	********************************************************************************************************* CYRUS_CALLBACK_NOLITERAL
   	********************************************************************************************************* CYRUS_CALLBACK_NOLITERAL 
   	********************************************************************************************************* CYRUS_CALLBACK_NOLITERAL
 */
function twentytwenty_read_more_tag( $html ) {
	return preg_replace( '/<a(.*)>(.*)<\/a>/iU', sprintf( '<div class="read-more-button-wrap"><a$1><span class="faux-button">$2</span> <span class="screen-reader-text">"%1$s"</span></a></div>', get_the_title( get_the_ID() ) ), $html );
}

add_filter( 'the_content_more_link', 'twentytwenty_read_more_tag' );


function getHomeBonus_function( $atts = array() ) {
	$numberposts=12;
	$type= 'bonus';
	$template = 'bonus';
	$linktext='Poznaj szczegóły i odbierz bonus';
	
	if(!empty($atts['linktext']) )
		$linktext  = $atts['linktext'];
		
	if(!empty($atts['template']) )
		$template  = $atts['template'];
		
	if(!empty($atts['numberposts']) )
		$numberposts = $atts['numberposts'];
		
	if(!empty($atts['type']) )
		$type = $atts['type'];
		
	$output ='<ul>';
	$recent_posts = wp_get_recent_posts(array('post_type'=> $type,  'numberposts' => $numberposts ));
	
	$today = date('Y-m-d');

	$recent_posts = get_posts(array(
				'post_type'			=> $type,
				'posts_per_page'	=> 12,
				'numberposts'		=> $numberposts,
				'meta_key'			=> 'kiedy_wygasa_test',
				'orderby'			=> 'meta_value',
				'order'				=> 'ASC',
				'meta_query'	=> array(
					array(
						'key'	  	=> 'kiedy_wygasa_test',
						'value'	  	=> $today,
						'compare' 	=> '>=',
						'type'		=> 'DATE',
					),
				)	
				
			));
	//$recent_posts = $recent_posts->posts;


    foreach( $recent_posts as $recent ){
    	$recent= (array)$recent;
        $output.=  '<li><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
    }
    $output.='<ul>';
    
    if( file_exists( get_template_directory() .'/template-parts/'.$template.'-tpl.php' ))
    	include( get_template_directory() .'/template-parts/'.$template.'-tpl.php' );
    return $output;
}

add_shortcode('gethomebonus', 'getHomeBonus_function');


function wpa_category_custom_type( $query ) {
    if ( $query->is_category() && $query->is_main_query() ) {
        $query->set( 'post_type', array( 'post', 'kody', 'bonusy' ) );
    }
}
add_action( 'pre_get_posts', 'wpa_category_custom_type' );

/**
* 
* @var edit_category_form_fields
* 
*/
add_action ( 'edit_category_form_fields', function( $tag ){
    $cat_title = get_term_meta( $tag->term_id, '_pagetitle', true ); 
    $cat_sub_title = get_term_meta( $tag->term_id, '_pagesubtitle', true ); 
    $cat_template = get_term_meta( $tag->term_id, '_pagetemplate', true ); 
    ?>
    <tr class='form-field'>
        <th scope='row'><label for='cat_title'><?php _e('Category Page Title'); ?></label></th>
        <td>
            <input type='text' name='cat_title' id='cat_title' value='<?php echo $cat_title ?>'>
            <p class='description'><?php _e('Title for the Category '); ?></p>
        </td>
    </tr>
    <tr class='form-field'>
        <th scope='row'><label for='cat_sub_title'><?php _e('Sub Category Page Title'); ?></label></th>
        <td>
            <input type='text' name='cat_sub_title' id='cat_sub_title' value='<?php echo $cat_sub_title ?>'>
            <p class='description'><?php _e('Sub Title for the Category '); ?></p>
        </td>
    </tr>
     <tr class='form-field'>
        <th scope='row'><label for='cat_template'><?php _e('Category Template'); ?></label></th>
        <td>
        	<select name="cat_template">
        		<option value=''><?php _e('Default'); ?></option>
        		<option value='kody' <?php echo ($cat_template=='kody'?' SELECTED ':'') ?> ><?php _e('Codes'); ?></option>
        		<option value='bonusy' <?php echo ($cat_template=='bonusy'?' SELECTED ':'') ?> ><?php _e('Bonus'); ?></option>
        		
        	</select>
            
            <p class='description'><?php _e('Category Template'); ?></p>
        </td>
    </tr>
     <?php
});
/**
* 
* @var edited_category
* 
*/
add_action ( 'edited_category', function() {
    if ( isset( $_POST['cat_title'] ) )
        update_term_meta( $_POST['tag_ID'], '_pagetitle', $_POST['cat_title'] );
    if ( isset( $_POST['cat_sub_title'] ) )
        update_term_meta( $_POST['tag_ID'], '_pagesubtitle', $_POST['cat_sub_title'] );
    if ( isset( $_POST['cat_template'] ) )
        update_term_meta( $_POST['tag_ID'], '_pagetemplate', $_POST['cat_template'] );
});


add_filter( 'site_transient_update_themes', 'remove_update_themes' );
function remove_update_themes( $value ) {
    $your_theme_slug = 'weblth';
    if ( isset( $value ) && is_object( $value ) ) {
        unset( $value->response[ $your_theme_slug ] );
    }
    return $value;
}



function my_cptui_add_post_types_to_archives( $query ) {
	// We do not want unintended consequences.
	if ( is_admin() || ! $query->is_main_query() ) {
		return;    
	}
	if ( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
		$cptui_post_types = array( 'kody', 'bonusy' );

		$query->set(
	  		'post_type',
			array_merge(
				array( 'post' ),
				$cptui_post_types
			)
		);
	
	  		
	}
}
add_filter( 'pre_get_posts', 'my_cptui_add_post_types_to_archives' );


/**
* 
* 
* @return shapeSpace_print_scripts
*/
function shapeSpace_print_scripts() { 
	?>
	<script>
		var cy_ajax_url = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
	</script>
	<?php
	
}
add_action('wp_print_scripts', 'shapeSpace_print_scripts');


/**
*  AJAX
* 
* @return
*/
// AJAX request handler
function cy_action() {
    global $wpdb;  // you can use global WP variables and so on
    $post_id = intval( $_POST['post_id'] );
    
    switch($_POST['act']){
		case 'cpycnt':
		if($post_id)
		    {
		    	$cpy = get_field('cpy_cnt',  $post_id );
		    	//echo $post_id.':'. $cpy;
			    if( isset($cpy) )
		    		{
		    			$cpy++;
		    			update_field('cpy_cnt', $cpy, $post_id);
						echo  get_field('cpy_cnt',  $post_id );
							
					}
			}
		break;
	}
    wp_die();
    
}
add_action( 'wp_ajax_cy_action', 'cy_action' );
add_action( 'wp_ajax_nopriv_cy_action', 'cy_action' );
/**
*  TOC
* @param undefined $atts
* 
* @return
*/

function url_anchor_target( $title )
		{
			$return = false;
			
			if ( $title ) {
				
				$return = trim( strip_tags($title) );
				
				$return = str_replace( '[CyDate type="month_str"]',  displayCstDate(['type'=>'month_str']) , $return);
				$return = str_replace( '[CyDate type="year"]', displayCstDate(['type'=>'year']) , $return);
				
				$return = preg_replace("/\([^)]+\)/","",$return); 
				
				// convert accented characters to ASCII 
				$return = remove_accents( $return );
				
				// replace newlines with spaces (eg when headings are split over multiple lines)
				$return = str_replace( array("\r", "\n", "\n\r", "\r\n",'-'), ' ', $return );
				
				// remove &amp;
				$return = str_replace( '&amp;', '', $return );
				
				// remove non alphanumeric chars
				$return = preg_replace( '/[^a-zA-Z0-9 \-_]*/', '', $return );
				
				// convert spaces to _
				$return = str_replace(
					array('  ', ' '),
					'_',
					$return
				);
				
				// remove trailing - and _
				$return = rtrim( $return, '-_' );
			}
				// lowercase everything?
				$return = strtolower($return);
				return $return;
}


function prepareTOC_function( $atts = array() ) {
	
	$template = 'toc';
	$class = '';
	
	if(!empty($atts['for']) )
		$content  = $atts['for'];
	if(!empty($atts['id']) )
		$id  = $atts['id'];
	if(!empty($atts['class']) )
		$class  = $atts['class'];
		
	if(!empty($atts['template']) )
		$template  = $atts['template'];
	
	switch($content){
		case 'category':
			$html_string = category_description( $id );
		break;
		case 'page':
			$p = get_page($id);
			$html_string =$p->post_content;
		break;
		case 'post':
			$p = get_post($id);
			$html_string =$p->post_content;
		break;
		case 'tag':
			$tag = get_term_by('slug', $id, 'post_tag');
			 $html_string = get_field('box_tag', $tag);
		break;
	}
	
	//preg_match_all('#<h[3]*[^>]*>.*?<\/h[3]>#',$html_string,$resultats);

	preg_match_all('|<h[^>]+>(.*)</h[^>]+>|iU',$html_string,$resultats);
	$res = $resultats[0];

	foreach($res as $k => $v)
	if(substr($v,0,3)!='<h3')
		unset( $res[$k] );
		
    //reformat the results to be more usable
    $toc = implode("\n",$res);
	$tohtml = $toc;
    $toc=preg_replace('/ class=".*?"/', '', $toc);
    $toc = str_replace('<a name="','<a href="#',$toc);
    $toc = str_replace('</a>','',$toc);
    $toc = preg_replace('#<h([3])>#','<li class="toc2"><a href="#toccy_">',$toc);
    $toc = preg_replace('#<\/h[3]>#','</a></li>',$toc);
	$toc = preg_replace_callback(
    '#\#toccy_#',
    function($m) {
        static $id = 0;
        $id++;
        return "#".$id."_".$m[1];
    },
    $toc);
    
   
$dom = new DOMDocument;
$dom->loadHTML('<?xml encoding="utf-8" ?>' .$toc);
foreach ($dom->getElementsByTagName('a') as $node)
{
	$st = (string) $node->nodeValue;
	$toc = str_replace( $node->getAttribute("href"), $node->getAttribute("href").url_anchor_target($node->nodeValue) , $toc);
}
    //plug the results into appropriate HTML tags
    $out = '<!-- CYTOC -->
    		<div id="toc" class="row"> 
			    <div class="col-sm-6">
				    <ul class="'.$class.'">
				    '.$toc.'
				    </ul>
				</div>
		    </div>
		    <!-- /CYTOC -->';
    return $out;
}

function after_selfToc($html_string){
	//preg_match_all('#<h[3]*[^>]*>.*?<\/h[3]>#',$html_string,$resultats);
	preg_match_all('|<h[^>]+>(.*)</h[^>]+>|iU',$html_string,$resultats);
	
	$res = $resultats[0];
	foreach($res as $k => $v)
		if(substr($v,0,3)!='<h3')
			unset( $res[$k] );
		
	
	$i=0;
	foreach($res  as $r){
		$i++;
		$to=preg_replace('/ class=".*?"/', '', $r);
		$to=str_replace( ['<h3>','</h3>'], ['<h3 class="hash"><a name="'.$i.'_'.url_anchor_target(strip_tags($r)).'"></a><span>','</span></h3>'], $to);
		$html_string=str_replace( $r, $to,$html_string);
	}
	return $html_string;
}

add_shortcode('prepareToc', 'prepareTOC_function');
add_filter( 'the_content', 'after_selfToc', 100 );	



/**
 * Returns a link to a tag. Instead of /tag/tag-name/ returns /tag-name.html
 */


/*
 * Add columns to exhibition post list
 */
 function add_acf_columns ( $columns ) {
   return array_merge ( $columns, array ( 
     'rodzaj' => __ ( 'Rodzaj' )
   ) );
 }
 add_filter ( 'manage_kody_posts_columns', 'add_acf_columns' );

 /*
 * Add columns to exhibition post list
 */
 function exhibition_custom_column ( $column, $post_id ) {
   switch ( $column ) {
     case 'rodzaj':
       echo get_post_meta ( $post_id, 'rodzaj', true );
       break;
   }
 }
 add_action ( 'manage_kody_posts_custom_column', 'exhibition_custom_column', 10, 2 );
 
 
function displayCstDate( $atts )
{
	switch($atts['type']){
		case 'year':
			return date('Y');
		break;
		case 'day':
			return date('d');
		break;
		case 'month_str':
			$miesiac = array( 'Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień' );
			return $miesiac[ (int)date('m')-1 ];
		break;
		case 'month':
			return date('m');
		break;
		
	}
	return '';
 
}
 
add_shortcode( 'CyDate', 'displayCstDate');


/**
* Category ID Column on Category Page
* https://wordpress.org/support/topic/show-category-id-on-category-page-manager-in-admin/
*/
add_action( 'admin_footer-edit-tags.php', 'wpse_56569_remove_cat_tag_description' );

function wpse_56569_remove_cat_tag_description(){
    global $current_screen;
    switch ( $current_screen->id ) 
    {
        case 'edit-category':
            // WE ARE AT /wp-admin/edit-tags.php?taxonomy=category
            // OR AT /wp-admin/edit-tags.php?action=edit&taxonomy=category&tag_ID=1&post_type=post
            break;
        case 'edit-post_tag':
            // WE ARE AT /wp-admin/edit-tags.php?taxonomy=post_tag
            // OR AT /wp-admin/edit-tags.php?action=edit&taxonomy=post_tag&tag_ID=3&post_type=post
            break;
    }
    ?>
    <script type="text/javascript">
    jQuery(document).ready( function($) {
        $('body.edit-tags-php table.wp-list-table.tags .column-description').remove();
    });
    </script>
    <style type="text/css">
    	body.edit-tags-php table.wp-list-table.tags  .column-description{
			  display:none;
			}
	</style>
    <?php
}

add_filter( 'manage_kody_posts_columns', 'smashing_realestate_columns' );
function smashing_realestate_columns( $columns ) {
    $columns['id'] = __( 'ID' );
    $columns['aktywny_do'] = __( 'Rodzaj / Aktywny do' );
  return $columns;
}
add_action( 'manage_kody_posts_custom_column' , 'custom_kody_column', 10, 2 );
function custom_kody_column( $column, $post_id ) {
    switch ( $column ) {
        case 'id' :
            echo  $post_id; 
        break;
        case 'aktywny_do':
        
        echo "<span style='color: #fff; background: #888; border-radius: 4px; padding:2px 15px; font-weight:bold;'>";
        	echo get_field('rodzaj', $post_id);
        echo "</span><br>";
        
        if(get_field('aktywny_do', $post_id))
	        {
	        	$today = strtotime( date("Y-m-d H:i:s")); 
				$acf = strtotime(get_field('aktywny_do', $post_id) ); 
				if($acf < $today )
					echo "<span style='color: red; font-weight:bold;'>".get_field('aktywny_do', $post_id)."</span>";
	        		else
	        		echo  "<span style='color: green; font-weight:bold;'>".get_field('aktywny_do', $post_id)."</span>";
			}else
				echo '-';
        break;

    }
}

function isa_remove_hentry_class( $classes ) {
    $classes = array_diff( $classes, array( 'hentry' ) );
    return $classes;
}
add_filter( 'post_class', 'isa_remove_hentry_class' );

/* Category ID Column on Category Page Ends */

/* Blog post, archive and site schema adder */

// add_action('wp_head', 'schema_to_head_blog');

// function schema_to_head_blog(){
// 	if(is_single()){
	
// 		$headline = get_the_title();
// 		$url = get_permalink();

// 		/*Check if there is a img*/
// 		global $post;
// 		$content = $post->post_content;
// 		$pattern = '/<img[^>]+>/';
	
// 		if(preg_match($pattern, $content, $matches)){
// 			$attachment_id = get_post_thumbnail_id( $post->ID );
// 			$imageUrl = wp_get_attachment_image_url($attachment_id);
// 		} else {
// 			$imageUrl = "";
// 		}

// 		$postPublishDate = get_the_date();

// 		/*Check if post was modified*/
// 		if(get_the_modified_date() != false){
// 			$lastUpdatedDate = get_the_modified_date();
// 		} else {
// 			$lastUpdatedDate = "";
// 		}
	
		
// 		echo 	'<script type="application/ld+json">
// 					{
// 					"@context": "https://schema.org",
// 					"@type": "BlogPosting",
// 					"mainEntityOfPage": {
// 						"@type": "WebPage",
// 						"@id": ' . "\"$url\"" . '
// 					  },
// 					"headline": ' . "\"$headline\"" . ',
// 					"image": ' . "\"$imageUrl\"" . ',  
// 					"author": {
// 						"@type": "Organization",
// 						"name": "Bonuspedia.pl"
// 					},  
// 					"publisher": {
// 						"@type": "Organization",
// 						"name": "Bonuspedia.pl",
// 						"logo": {
// 						"@type": "ImageObject",
// 						"url": "https://bonuspedia.pl/wp-content/uploads/2020/03/logo-1.png"
// 						}
// 					},
// 					"datePublished": ' . "\"$postPublishDate\"" . ',
// 					"dateModified": ' . "\"$lastUpdatedDate\"" . '
// 					}
// 				</script>';
// 	} 
// 	else if (is_page()){
// 		if(is_single()){
	
// 			$url = get_permalink();

// 			$postPublishDate = get_the_date();
	
// 			/*Check if post was modified*/
// 			if(get_the_modified_date() != false){
// 				$lastUpdatedDate = get_the_modified_date();
// 			} else {
// 				$lastUpdatedDate = "";
// 			}
		
			
// 			echo 	'<script type="application/ld+json">
// 						{
// 						"@context": "https://schema.org",
// 						"@type": "WebPage",
// 						"mainEntityOfPage": {
// 							"@type": "WebPage",
// 							"@id": ' . "\"$url\"" . '
// 						  },
// 						"author": {
// 							"@type": "Organization",
// 							"name": "Bonuspedia.pl"
// 						},  
// 						"publisher": {
// 							"@type": "Organization",
// 							"name": "Bonuspedia.pl",
// 							"logo": {
// 							"@type": "ImageObject",
// 							"url": "https://bonuspedia.pl/wp-content/uploads/2020/03/logo-1.png"
// 							}
// 						},
// 						"datePublished": ' . "\"$postPublishDate\"" . ',
// 						"dateModified": ' . "\"$lastUpdatedDate\"" . '
// 						}
// 					</script>';
// 		}
// 	}
// 	else if(is_archive()){
	
// 		$url = get_permalink();

// 		$postPublishDate = get_the_date();

// 		/*Check if post was modified*/
// 		if(get_the_modified_date() != false){
// 			$lastUpdatedDate = get_the_modified_date();
// 		} else {
// 			$lastUpdatedDate = "";
// 		}
	
		
// 		echo 	'<script type="application/ld+json">
// 					{
// 					"@context": "https://schema.org",
// 					"@type": "WebPage",
// 					"mainEntityOfPage": {
// 						"@type": "WebPage",
// 						"@id": ' . "\"$url\"" . '
// 					  },
// 					"author": {
// 						"@type": "Organization",
// 						"name": "Bonuspedia.pl"
// 					},  
// 					"publisher": {
// 						"@type": "Organization",
// 						"name": "Bonuspedia.pl",
// 						"logo": {
// 						"@type": "ImageObject",
// 						"url": "https://bonuspedia.pl/wp-content/uploads/2020/03/logo-1.png"
// 						}
// 					},
// 					"datePublished": ' . "\"$postPublishDate\"" . ',
// 					"dateModified": ' . "\"$lastUpdatedDate\"" . '
// 					}
// 				</script>';
// 	}
// };
