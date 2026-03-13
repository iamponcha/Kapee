<?php 
/**
 Kapee functions
*/

/**
* Get widget column class
*/
if( ! function_exists( 'kapee_get_widget_column_class' ) ) {
	function kapee_get_widget_column_class( $sidebar_id = 'kapee-filters-area' ) {
		global $_wp_sidebars_widgets;
		if ( empty( $_wp_sidebars_widgets ) ) :
			$_wp_sidebars_widgets = get_option( 'sidebars_widgets', array() );
		endif;
		
		$sidebars_widgets_count = $_wp_sidebars_widgets;

		if ( isset( $sidebars_widgets_count[ $sidebar_id ] ) || $sidebar_id == 'kapee-filters-area' ) {
			$count = ( isset( $sidebars_widgets_count[ $sidebar_id ] ) ) ? count( $sidebars_widgets_count[ $sidebar_id ] ) : 0;
			$widget_count = apply_filters( 'widgets_count_' . $sidebar_id, $count );
			$widget_classes = 'widget-count-' . $widget_count;
			$widget_classes .= kapee_get_grid_el_class( ( ($widget_count > 4) ? 4 : $widget_count ),12, 6, 6 );
			return apply_filters( 'widget_class_' . $sidebar_id, $widget_classes);
		}
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Function to get grid element (column)
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'kapee_get_grid_el_class' ) ) {
	function kapee_get_grid_el_class($columns = 4, $xs_size = false, $sm_size = 4, $md_size = 3) {
		$classes = '';

		if( ! in_array( $columns, array(1,2,3,4,6,12) ) ) {
			$columns = 4;
		}

		if( ! $xs_size ) {
			$xs_size = apply_filters('kapee_grid_xs_default', 6);
		}

		if( $columns < 3) {
			$xs_size = 12;
			if($columns == 1)
				$sm_size = 12;
			else
				$sm_size = 6;
		}		


		$col = ' col-xs-' . $xs_size . ' col-sm-' . $sm_size . ' col-md-';

		$md_size = 12/$columns;
		
		$classes .= $col . $md_size;
		
		return $classes;
	}
}

/**
 * Function to add array after specific key
 * 
 * @package Kapee theme
 * @since 1.0.0
 */
function kapee_add_array(&$array, $value, $index, $from_last = false) {
    
    if( is_array($array) && is_array($value) ) {

        if( $from_last ) {
            $total_count    = count($array);
            $index          = (!empty($total_count) && ($total_count > $index)) ? ($total_count-$index): $index;
        }
        
        $split_arr  = array_splice($array, max(0, $index));
        $array      = array_merge( $array, $value, $split_arr);
    }
    
    return $array;
}

function kapee_get_terms($args = array(), $args2 = ''){
	$return_data = array();
	
	if( !empty($args2) ){
		$result = get_terms( $args, $args2 );
	}else{
		if( !isset($args['hide_empty']) ){
			$args['hide_empty'] = true;
		}
		$result = get_terms( $args );
	}
	
	if ( is_wp_error( $result ) ) {
		return $return_data;
	}
	
	if ( !is_array( $result ) || empty( $result ) ) {
		return $return_data;
	}
	
	foreach ( $result as $term_data ) {
		if ( is_object( $term_data ) && isset( $term_data->name, $term_data->term_id ) ) {
			$return_data[ $term_data->name . ( ( isset($args['counts']) && $args['counts'] ) ? " (".$term_data->count.")" : '' )] = $term_data->term_id;
		}
	}
	return $return_data;
}

if ( ! function_exists( 'kapee_get_all_image_sizes' ) ) :
	 /**
     * Returns category name.
     *
     * @return string Category name.
     */
	function kapee_get_product_category_name_by_id( $category_id ) {
		$term = get_term_by( 'id', $category_id, 'product_cat', 'ARRAY_A' );
		return $term['name'];
	}
endif;

if ( ! function_exists( 'kapee_get_all_image_sizes' ) ) :
    /**
     * Returns all image sizes available.
     *
     * @since 1.0.0
     *
     * @param bool $for_choice True/False to construct the output as key and value choice
     * @return array Image Size Array.
     */
    function kapee_get_all_image_sizes( $for_choice = false ) {

        global $_wp_additional_image_sizes;

        $sizes = array();

        if( true == $for_choice ){
            $sizes['no-image'] = __( 'No Image', 'kapee-extensions' );
        }

        foreach ( get_intermediate_image_sizes() as $_size ) {
            if ( in_array( $_size, array('thumbnail', 'medium', 'large') ) ) {

                $width = get_option( "{$_size}_size_w" );
                $height = get_option( "{$_size}_size_h" );

                if( true == $for_choice ){
                    $sizes[$_size] = ucfirst($_size) . ' (' . $width . 'x' . $height . ')';
                }else{
                    $sizes[ $_size ]['width']  = $width;
                    $sizes[ $_size ]['height'] = $height;
                    $sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
                }
            } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

                $width = $_wp_additional_image_sizes[ $_size ]['width'];
                $height = $_wp_additional_image_sizes[ $_size ]['height'];

                if( true == $for_choice ){
                    $sizes[$_size] = ucfirst($_size) . ' (' . $width . 'x' . $height . ')';
                }else{
                    $sizes[ $_size ] = array(
                        'width'  => $width,
                        'height' => $height,
                        'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
                    );
                }
            }
        }

        if( true == $for_choice ){
            $sizes['full'] = __( 'Full Image', 'kapee-extensions' );
        }

        return $sizes;
    }
endif;

function kapee_block_shortcode($atts){
	// Getting attributes of shortcode
	extract( shortcode_atts( array(
		'id' 	=> '',
	), $atts, 'kapee_block'));
	$id 		= !empty($id) ? trim($id) : '';
	//$content 	= get_post_field('post_content',$id);
	$content 	= do_shortcode(get_post_field('post_content',$id));	
	$shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );	
	if ( ! empty( $shortcodes_custom_css ) ) {
		$content .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
		$content .= $shortcodes_custom_css;
		$content .= '</style>';
	}	
	return $content;
}

/**
* Get server info
*/
if( ! function_exists( 'kapee_get_server_info' ) ) {
	function kapee_get_server_info(){
		return $_SERVER['SERVER_SOFTWARE'];
	}
}

/*  QR Code generation
/* --------------------------------------------------------------------- */ 
if(!function_exists('kapee_generate_qr_code')) {
    function kapee_generate_qr_code($text='QR Code', $title = 'QR Code', $size = 128, $class = '', $self_link = false, $lightbox = false ) {
        if($self_link) {
            global $wp;
            $text = @(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
            if ( $_SERVER['SERVER_PORT'] != '80' )
                $text .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
            else 
                $text .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        }
        $image = 'https://chart.googleapis.com/chart?chs=' . $size . 'x' . $size . '&cht=qr&chld=H|1&chl=' . $text;
		
        if($lightbox) {
            $class .= 'link-popup';
            $output = '<a href="'.$image.'" class="'.$class.'">'.$title.'</a>';
        } else{
            $class .= ' qr-code-image';
            $output = '<img src="'.$image.'"  class="'.$class.'" />';
        }
        return $output;
    }
}

/* Instagram Function */
function kapee_get_insta_media($username = '',$limit = 9){
	// If no username then simply return
	if( empty($username) ) {
		return false;
	}
	
	// Taking some defaults
	$result_data		= array();
	$response_matches	= array();
	$transient_key 		= "kapee-".sanitize_title_with_dashes($username);
	$username 			= !empty($username) ? trim($username) 	: '';
	$by_hashtag = ( substr( $username, 0, 1 ) == '#' );
	$limit 				= !empty($limit) 	? trim($limit) 		: 9;
	$limit				= ($limit >= 12)	? 12				: $limit;

	$stored_transient 	= get_transient( $transient_key ); // Getting cache value
	$stored_transient	= !empty($stored_transient) ? json_decode($stored_transient, true) : false;
	
	if ( false === $stored_transient ) {
		$request_param = ( $by_hashtag ) ? 'explore/tags/' . substr( $username, 1 ) : trim( $username );
		$remote = wp_remote_get( 'https://instagram.com/'. $request_param );
		$args = array();
		// API args
		$api_args	= array(
						'timeout' 		=> 15,
						'sslverify' 	=> false,
						'user-agent'  	=> 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.87 Safari/537.36',
						'headers'		=> array(
							'Origin' 		=> 'https://www.instagram.com',
							'Referer' 		=> 'https://www.instagram.com',
							'Connection' 	=> 'close',
							'Host'			=> 'www.instagram.com'
						),
						'cookies'		=> array(
							'ig_or'			=> 'landscape-primary',
							'ig_pr'			=> '1',
							'ig_vh'			=> 1080,
							'ig_vw'			=> 1920,
							'ds_user_id'	=> 23841649944
						),
					);

		if ( ! empty($args['headers']) ) {
			$args['headers'] = array_merge($api_args['headers'], $args['headers']);
		}
		$api_args = wp_parse_args( $args, $api_args );
		$remote  = wp_remote_get( esc_url_raw( 'https://instagram.com/'. $request_param ), $api_args );
		
		
		if ( is_wp_error( $remote ) ) {
			return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'kapee-extensions' ) );
		}

		if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
			return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'kapee-extensions' ) );
		}
		
		preg_match('#window\._sharedData\s*=\s*(.*?)\s*;\s*</script>#', $remote['body'], $response_matches);
		if( isset($response_matches[1]) ) {
			
			$insta_array = json_decode($response_matches[1], true);
			if ( ! $insta_array ){
				return new WP_Error( 'break_json', esc_html__( 'Instagram has returned invalid data.', 'kapee-extensions' ) );
			}
			
			if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
			} elseif( $by_hashtag && isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
		        $images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
		    } else {
				return new WP_Error( 'break_json_2', esc_html__( 'Instagram has returned invalid data.', 'kapee-extensions' ) );
			}

			if ( ! is_array( $images ) ) {
				return new WP_Error( 'break_array', esc_html__( 'Instagram has returned invalid data.', 'kapee-extensions' ) );
			}
			
			$instagram = array();
			
			foreach ( $images as $image ) {
				$image = $image['node'];
				$caption = esc_html__( 'Instagram Image', 'kapee-extensions' );
				if ( ! empty( $image['edge_media_to_caption']['edges'][0]['node']['text'] ) ) $caption = $image['edge_media_to_caption']['edges'][0]['node']['text'];

				$image['thumbnail_src'] = preg_replace( "/^https:/i", "", $image['thumbnail_src'] );
				$image['thumbnail'] = preg_replace( "/^https:/i", "", $image['thumbnail_resources'][0]['src'] );
				$image['medium'] = preg_replace( "/^https:/i", "", $image['thumbnail_resources'][2]['src'] );
				$image['large'] = $image['thumbnail_src'];
				
				$type = ( $image['is_video'] ) ? 'video' : 'image';
					
				$result_data[] = array(
					'description'   => $caption,
					'link'		  	=> '//instagram.com/p/' . $image['shortcode'],
					'comments'	  	=> $image['edge_media_to_comment']['count'],
					'likes'		 	=> $image['edge_liked_by']['count'],
					'thumbnail'	 	=> $image['thumbnail'],
					'medium'		=> $image['medium'],
					'large'			=> $image['large'],
					'type'		  	=> $type,
				);
			}
			set_transient( $transient_key, json_encode($result_data), apply_filters( 'kapee_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
		}
		
	}else {
		$result_data = $stored_transient;
	}
	if ( ! empty( $result_data ) ) {
			return array_slice( $result_data, 0, $limit );
		} else {
			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'kapee-extensions' ) );
		}
	
}

/**
	Get twitter feed
*/
function kapee_get_twitter_feed($username,$consumer_key,$consumer_secret_key,$access_token,$access_token_secret,$number_of_tweets){
	$tweets = array();
	$connection = new TwitterOAuth(
		$consumer_key,   		// Consumer key
		$consumer_secret_key,   	// Consumer secret
		$access_token,   		// Access token
		$access_token_secret	// Access token secret
	);
	
	$my_tweets = $connection->get(
		'statuses/user_timeline',
		array(
			'screen_name'    => $username,
			'count'          => $number_of_tweets,
		)
	);
	$number_of_tweets = min( $number_of_tweets, count( $my_tweets ) );
	
	if( $connection->http_code == 200 ) {
		for( $i = 0; $i < $number_of_tweets; $i++ ) {
			$tweet = $my_tweets[$i];
			
			// Core info.
			$name = $tweet->user->name;
			
			// COMMUNITY REQUEST !!!!!! (2)
			$screen_name = $tweet->user->screen_name;

			$permalink = 'http://twitter.com/'. $screen_name .'/status/'. $tweet->id_str;
			$tweet_id = $tweet->id_str;

			//  Check for SSL via protocol https then display relevant image - thanks SO - this should do
			if ( isset( $_SERVER['HTTPS'] ) && ( $_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1 ) || isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) {
				$image = $tweet->user->profile_image_url_https;
			}else {
				$image = $tweet->user->profile_image_url;
			}

			// Process Tweets - Use Twitter entities for correct URL, hash and mentions
			$text = kapee_twitter_process_links( $tweet );

			// lets strip 4-byte emojis
			$text = preg_replace( '/[\xF0-\xF7][\x80-\xBF]{3}/', '', $text );

			// Need to get time in Unix format.
			$time = $tweet->created_at;
			$date_formate = date("Y/m/d", strtotime($time));
			//echo date("Y-m-d", strtotime($time));
			$time = date_parse( $time );
			$uTime = mktime( $time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year'] );
			
			//echo 'Tieme => '.$time;
			// Now make the new array.
			$tweets[] = array(
				'text' => $text,
				'name' => $name,
				'permalink' => $permalink,
				'image' => $image,
				'time' => $date_formate,
				'tweet_id' => $tweet_id
				);
				
		}
	}
	return $tweets;
}

// **********************************************************************//
// Kapee twitter process links
// **********************************************************************//
if( ! function_exists( 'kapee_twitter_process_links' ) ) {
	function kapee_twitter_process_links( $tweet ) {

		// Is the Tweet a ReTweet - then grab the full text of the original Tweet
		if( isset( $tweet->retweeted_status ) ) {
			// Split it so indices count correctly for @mentions etc.
			$rt_section = current( explode( ":", $tweet->text ) );
			$text = $rt_section.": ";
			// Get Text
			$text .= $tweet->retweeted_status->text;
		} else {
			// Not a retweet - get Tweet
			$text = $tweet->text;
		}

		// NEW Link Creation from clickable items in the text
		$text = preg_replace( '/((http)+(s)?:\/\/[^<>\s]+)/i', '<a href="$0" target="_blank" rel="nofollow">$0</a>', $text );
		// Clickable Twitter names
		$text = preg_replace( '/[@]+([A-Za-z0-9-_]+)/', '<a href="http://twitter.com/$1" target="_blank" rel="nofollow">@$1</a>', $text );
		// Clickable Twitter hash tags
		$text = preg_replace( '/[#]+([A-Za-z0-9-_]+)/', '<a href="http://twitter.com/search?q=%23$1" target="_blank" rel="nofollow">$0</a>', $text );
		// END TWEET CONTENT REGEX
		return $text;

	}
}

/**
 * Author Box
 */
if( ! function_exists( 'kapee_author_box' )){

	function kapee_author_box( $user_id = false ){

		if( !$user_id  ){
			global $post;
			$user_id = $post->post_author;
			
		}
		$description = get_the_author_meta( 'description', $user_id );
		?>

		<div class="about-author container-wrapper">

			<?php
				$user_info = get_userdata($user_id);				
				$name =  $user_info->user_login;				
				// Show the avatar if it is active only
				if( get_option( 'show_avatars' ) ){ ?>
					<div class="author-avatar">
						<a href="<?php echo get_author_posts_url( $user_id ); ?>">
							<?php echo get_avatar( get_the_author_meta( 'user_email', $user_id ), apply_filters( 'kapee_avatar_size', 180 ) ); ?>
						</a>
					</div>
					<?php
				}

			?>

			<div class="author-info">
				<h3 class="author-name"><a href="<?php echo get_author_posts_url( $user_id ); ?>"><?php echo esc_html( $name ) ?></a></h3>

				<div class="author-bio">
					<?php echo wp_kses_post( $description ); ?>
				</div>

			</div>
			
		</div>
		<?php
	}
}

/*-----------------------------------------------------------------------------------*/
# Get all categories as array of ID and name
/*-----------------------------------------------------------------------------------*/
function kapee_get_all_categories( $label = false ){

	$categories = array();

	if( ! empty( $label )){
		$categories[] = esc_html__( '- Select a category -', 'kapee-extensions' );
	}

	$get_categories = get_categories( 'hide_empty=0' );

	if( ! empty( $get_categories ) && is_array( $get_categories ) ){
		foreach ( $get_categories as $category ){
			$categories[ $category->cat_ID ] = $category->cat_name;
		}
	}

	return $categories;
}

/**
* Get post order
*/
function kapee_post_order(){
	//Post Order
	$post_order = array(
		'latest'   => esc_html__( 'Recent Posts', 'kapee-extensions' ),
		'rand'     => esc_html__( 'Random Posts', 'kapee-extensions' ),
		'modified' => esc_html__( 'Last Modified Posts', 'kapee-extensions' ),
		'popular'  => esc_html__( 'Most Commented posts', 'kapee-extensions' ),
	);
	$post_order['views'] = esc_html__( 'Most Viewed posts', 'kapee-extensions' );
	

	return apply_filters( 'kapee_post_order', $post_order );
}

/* Function to get required plugin list*/
function kapee_get_required_plugins_list() {   
    $plugins = array(
		array(
			'name'                     => 'Kapee Extensions',
			'slug'                     => 'kapee-extensions',
			'required'                 => true,
			'url'                      => 'kapee-extensions/kapee-extensions.php',
			'version'                  => '1.0',
		),
        array(
            'name'                     => 'WPBakery Visual Composer',
            'slug'                     => 'js_composer',
            'required'                 => true,
            'version'                  => '5.4.7',
            'url'                      => 'js_composer/js_composer.php',
        ),
		array(
            'name'                     => 'Revolution Slider',
            'slug'                     => 'revslider',
            'required'                 => true,
            'url'                      => 'revslider/revslider.php',
			'version'                  => '5.4.7.4',
        ),
        array(
            'name'                     => 'Woocommerce',
            'slug'                     => 'woocommerce',
            'required'                 => true,
            'url'                      => 'woocommerce/woocommerce.php',
			'version'                  => '3.4',
        ),
		
		
    );

    return $plugins;
}

/**
* Get link attr
*/
function kapee_vc_get_link_attr( $link ) {
	$link = ( '||' === $link ) ? '' : $link;
	if( function_exists( 'vc_build_link' ) ){
		$link = vc_build_link( $link );
	}
	return $link;
}

/**
* Get menu label HTML
*/
function kapee_menu_label( $label_txt = '',$label_color = '',$echo = true) {
	if(empty($label_txt) && empty($label_color)){
		return false;
	}
	$lable_style = $label_html = '';
	if(!empty($label_color)){
		$lable_style = 'style="background-color:'.$label_color.'"';
	}
	if(!empty($label_txt)){
		$label_html = '<span class="menu-label" '.$lable_style.'>'.$label_txt.'</span>';
	}
	if($echo){
		echo apply_filters('kapee_menu_label',$label_html,$label_txt,$label_color);
	}else{
		return apply_filters('kapee_menu_label',$label_html,$label_txt,$label_color);
	}
}


/**
 * Get post type dropdown
 */
function kapee_get_posts_dropdown($post_type ='post',$select_options = ''){
	$results = array();
	$args = array('post_type'	=> $post_type,
				'post_status' 	=>  array('publish'),
				'posts_per_page'=>-1);
	$post_type_query = get_posts( $args );
	if(!empty($select_options)){
		$results[' '] = $select_options;
	}
    foreach ( $post_type_query as $p ):
		$results[$p->ID] = $p->post_title;
    endforeach; 
	return $results;
}

/**
* Get links attributes
*/
function kapee_get_link_attributes( $link) {
	//parse link
	$link = kapee_vc_get_link_attr( $link );
	$use_link = false;
	if ( isset( $link['url'] ) && strlen( $link['url'] ) > 0 ) {
		$use_link = true;
		$a_href = apply_filters( 'kapee_vc_menu_url', $link['url'] );
		$a_title = $link['title'];
		$a_target = $link['target'];
	}

	$attributes = array();

	if ( $use_link ) {
		$attributes[] = 'href="' . trim( $a_href ) . '"';
		$attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
		if ( ! empty( $a_target ) ) {
			$attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';
		}
	}

	$attributes = implode( ' ', $attributes );

	return $attributes;
}
	
/**
* Load visual composer font
*/
function kapee_vc_icon_element_fonts_enqueue($icon_type = 'fontawesome') {
	vc_icon_element_fonts_enqueue( $icon_type );
}

/**
 * Get shortcode template parts.
 */
function kapee_get_pl_templates( $slug,$args = array() ) {
	$template = '';
	
	$template_path = 'template-parts/';
	$plugin_path = trailingslashit( KAPEE_EXTENSIONS_DIR );
	
	// If template file doesn't exist, look in yourtheme/template-parts/shortcodes/slug.php
	if ( ! $template ) {
		$template = locate_template( array(
			$template_path . "{$slug}.php"
		) );
	}
	
	// Get default slug.php
	if ( ! $template && file_exists( $plugin_path . "templates/{$slug}.php" ) ) {
		$template = $plugin_path . "templates/{$slug}.php";
	}
	
	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters( 'kapee_get_pl_templates', $template, $slug);	
	extract( $args );
	if ( $template ) {		
		include( $template );
	}
}
function kapee_get_posts( $args ) {
	$defaults = array(
		'post_type'           	=> isset($args['post_type']) ? $args['post_type'] : 'post',
		'status'              	=> 'published',
		'ignore_sticky_posts' 	=> 1,
		'orderby'             	=> isset($args['orderby']) ? $args['orderby'] : 'date',
		'order'               	=> isset($args['sortby']) ? $args['sortby'] : 'desc',
		'posts_per_page'      	=> isset( $args['limit'] ) > 0 ? intval( $args['limit'] ) : 10,
		'paged'      			=> isset($args['paged']) > 0 ? intval( $args['paged'] ) : 1,
	);
	$args = wp_parse_args( $args, $defaults );
	// Posts Order
	if( ! empty( $orderby ) ){
		// Most Viewd posts
		if( $args['orderby'] == 'views'){
			$prefix = KAPEE_EXTENSIONS_META_PREFIX;
			$args['orderby']  = 'meta_value_num';
			$args['meta_key'] = apply_filters( 'kapee_views_meta_field', $prefix.'views_count' );
		} elseif( $orderby == 'popular' ){ // Popular Posts by comments
			$args['orderby'] = 'comment_count';
		}
	}
	//Specific categories
	$categories = isset($args['categories']) ? trim($args['categories']) : '';
	if( !empty($categories) ){
		$categories_array = explode(',', $categories);
		$categories_array = array_map( 'trim', $categories_array );
		if( is_array($categories_array) && !empty($categories_array) ){
			$args['tax_query'][] = array(
				array(
					'taxonomy' => isset($args['taxonomy']) ? $args['taxonomy'] : 'category',
					'field'    => 'term_id',
					'terms'    => $categories_array
				)
			);
		}
	}
	
	// Exclude Products
	if ( !empty($args['exclude']) ) {
		$ids = explode( ',', $args[ 'exclude' ] );
		$ids = array_map( 'trim', $ids );			
		$args['post__not_in'] = $ids;
	}
	return $args;
}

/**
 Vendor products
*/
function kapee_vendor_products($args){
	$args = array(
		'post_type' => 'product',
		'posts_per_page' => $args['posts_per_page'],
		'author' => $args['author'],
		'ignore_sticky_posts'=> true,
		'no_found_rows'=> true
	);
	$args['meta_query'] 	= WC()->query->get_meta_query();
	$args['tax_query']   	= WC()->query->get_tax_query();
	$products = new WP_Query($args);
	return $products;
}

function kapee_get_products( $data_source, $atts, $args = array() ) {
	$defaults = array(
		'post_type'           	=> 'product',
		'status'              	=> 'published',
		'ignore_sticky_posts' 	=> 1,
		'orderby'             	=> isset($atts['orderby']) ? $atts['orderby'] : 'date',
		'order'               	=> isset($atts['sortby']) ? $atts['sortby'] : 'desc',
		'posts_per_page'      	=> isset( $atts['limit'] ) > 0 ? intval( $atts['limit'] ) : 10,
		'paged'      			=> isset($atts['paged']) > 0 ? intval( $atts['paged'] ) : 1,
	);
	$args['meta_query'] 	= WC()->query->get_meta_query();
	$args['tax_query']   	= WC()->query->get_tax_query();
	$args = wp_parse_args( $args, $defaults );
	
	switch ( $data_source ) {
		case 'featured_products';
			$args['tax_query'][] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => array( 'featured' ),
					'operator' => 'IN',
				),
			);			
			break;
		case 'sale_products';
			$product_ids_on_sale   = wc_get_product_ids_on_sale();
			$product_ids_on_sale[] = 0;
			$args['post__in']      = $product_ids_on_sale;
			break;
		case 'best_selling_products';
			$args['meta_key'] = 'total_sales';
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'DESC';
			break;
		case 'top_rated_products';
			$args['meta_key'] = '_wc_average_rating';
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'DESC';
			break;
		case 'products';
			if ( $atts['product_ids'] != '' ) {
				$args['post__in'] = explode( ',', $atts['product_ids'] );
			}
			break;
	}
	
	//Specific categories
	$categories = isset($atts['categories']) ? trim($atts['categories']) : '';
	if( !empty($categories) ){
		$categories_array = explode(',', $categories);
		$categories_array = array_map( 'trim', $categories_array );
		if( is_array($categories_array) && !empty($categories_array) ){
			$args['tax_query'][] = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $categories_array
				)
			);
		}
	}
	
	// Exclude Products
	if ( !empty($atts['exclude']) ) {
		$ids = explode( ',', $atts[ 'exclude' ] );
		$ids = array_map( 'trim', $ids );			
		$args['post__not_in'] = $ids;
		if(!empty($args['post__in'])){
			$args['post__in'] = array_diff( $args['post__in'], $args['post__not_in'] );
		}
	}
	
	return $args;
}
/* kapee width options*/
function kapee_width_options(){
	/**
	 * The pixel width of the plugin.
	 * Min. is 280
	 * Max. is 500
	 *
	 * @var $width array Defaults to 340.
	 */
	$width 			= range( 280, 500, 20 );
	$width_array 	= array();
	foreach ( $width as $val ){
		$width_array[$val] = $val;
	}
	return $width_array;
}

/* kapee width options*/
function kapee_height_options(){
	/**
	 * The maximum pixel height of the plugin.
	 * Min. is 130
	 *
	 * @var $height array Defaults to 500.
	 */
	$height 		= range( 125, 800, 25 );
	$height_array 	= array();
	foreach ( $height as $val ){
		$height_array[$val] = $val;
	}
	return $height_array;
}

add_action( 'wp_ajax_kapee_loadmore_product', 'kapee_loadmore_product' );
add_action( 'wp_ajax_nopriv_kapee_loadmore_product', 'kapee_loadmore_product' );
function kapee_loadmore_product(){
	$response        = array(
		'html'    => '',
		'message' => '',
		'success' => 'no',
		'show_bt' => 'no'
	);
	$attr      = isset( $_POST['attr'] ) ? $_POST['attr'] : '';
	$paged      = isset( $_POST['page'] ) ? $_POST['page'] : '';
	$args      = json_decode( base64_decode( $attr ) ,true);
	$args['paged'] = $paged;
	
	$query = kapee_get_products( $args['data_source'], $args );
	
	$loop = new WP_Query( $query );	
	//$loop         = new wp_query( $args );
	$max_num_page = $loop->max_num_pages;
	$query_paged  = $loop->query_vars['paged'];
	if ( $query_paged >= 0 && ( $query_paged < $max_num_page ) ) {
		$show_button = '1';
	} else {
		$show_button = '0';
	}
	if ( $max_num_page <= 1 ) {
		$show_button = 0;
	}
	
	ob_start();
	$args['show_button'] =  $show_button;
	extract( $args );
	if($product_style != 'default'){
		kapee_set_loop_prop('product-style',$product_style);
	}
	kapee_set_loop_prop('products-columns',$columns);
	wc_set_loop_prop('columns',$columns);
	while ( $loop->have_posts() ) : $loop->the_post();
		wc_get_template_part( 'content-product' );       
	endwhile;
	wp_reset_postdata();
	kapee_reset_loop();
	$response['html']    = ob_get_clean();
	$response['success'] = 'ok';
	$response['show_bt'] = $show_button;
	wp_send_json( $response );
	die();
}

add_action( 'wp_ajax_kapee_loadmore_posts', 'kapee_loadmore_posts' );
add_action( 'wp_ajax_nopriv_kapee_loadmore_posts', 'kapee_loadmore_posts' );
function kapee_loadmore_posts(){
	$response        = array(
		'html'    => '',
		'message' => '',
		'success' => 'no',
		'show_bt' => 'no'
	);
	$attr      = isset( $_POST['attr'] ) ? $_POST['attr'] : '';
	$paged      = isset( $_POST['page'] ) ? $_POST['page'] : '';
	$args      = json_decode( base64_decode( $attr ) ,true);
	$args['paged'] = $paged;
	
	$query = kapee_get_posts($args );
	
	$loop = new WP_Query( $query );	
	//$loop         = new wp_query( $args );
	$max_num_page = $loop->max_num_pages;
	$query_paged  = $loop->query_vars['paged'];
	if ( $query_paged >= 0 && ( $query_paged < $max_num_page ) ) {
		$show_button = '1';
	} else {
		$show_button = '0';
	}
	if ( $max_num_page <= 1 ) {
		$show_button = 0;
	}
	
	ob_start();
	extract( $args );
	
	kapee_set_loop_prop( 'name','posts-loop-shortcode');
	kapee_set_loop_prop( 'blog-post-style',$blog_style);
	kapee_set_loop_prop( 'post-fancy-date',$post_fancy_date);
	kapee_set_loop_prop( 'fancy-date-style',$fancy_date_style);
	kapee_set_loop_prop( 'post-meta',$post_meta);
	
	if($blog_style == 'blog-grid'){
		kapee_set_loop_prop( 'blog-grid-post-style',$grid_style);
		kapee_set_loop_prop( 'blog-grid-layout',$grid_layout);
		kapee_set_loop_prop( 'blog-grid-columns',$grid_column);
	}		
	kapee_set_loop_prop( 'blog-post-content',$blog_content);
	kapee_set_loop_prop( 'blog-excerpt-length',$blog_excerpt_length);
	kapee_set_loop_prop( 'read-more-button',$read_more_btn);
	kapee_set_loop_prop( 'read-more-button-style',$read_more_btn_style);
	kapee_set_loop_prop( 'blog-post-thumbnail',$blog_thumbnail);
	kapee_set_loop_prop( 'blog-post-title',$blog_title);
		
	while ( $loop->have_posts() ) :
		$loop->the_post();			
		// Include the loop post content template.
		get_template_part( 'template-parts/post-loop/layout', get_post_format() );      
	endwhile;
	wp_reset_postdata();
	kapee_reset_loop();
	$response['html']    = ob_get_clean();
	$response['success'] = 'ok';
	$response['show_bt'] = $show_button;
	wp_send_json( $response );
	die();
}

add_action( 'wp_ajax_kapee_loadmore_portfolios', 'kapee_loadmore_portfolios' );
add_action( 'wp_ajax_nopriv_kapee_loadmore_portfolios', 'kapee_loadmore_portfolios' );
function kapee_loadmore_portfolios(){
	$response        = array(
		'html'    => '',
		'message' => '',
		'success' => 'no',
		'show_bt' => 'no'
	);
	$attr      = isset( $_POST['attr'] ) ? $_POST['attr'] : '';
	$paged      = isset( $_POST['page'] ) ? $_POST['page'] : '';
	$args      =  $_POST['attr'];	
	$args['paged'] = $paged;	
	$query = kapee_get_posts($args );
	
	$loop = new WP_Query( $query );	
	//$loop         = new wp_query( $args );
	$max_num_page = $loop->max_num_pages;
	$query_paged  = $loop->query_vars['paged'];
	if ( $query_paged >= 0 && ( $query_paged < $max_num_page ) ) {
		$show_button = '1';
	} else {
		$show_button = '0';
	}
	if ( $max_num_page <= 1 ) {
		$show_button = 0;
	}
	
	ob_start();
	extract( $args );
	
	kapee_set_loop_prop( 'name','portfolio-post-shortcode');
	kapee_set_loop_prop( 'portfolio-style',$portfolio_style);
	kapee_set_loop_prop( 'portfolio-grid-layout',$portfolio_grid_layout);
	kapee_set_loop_prop( 'portfolio-grid-columns',$portfolio_grid_columns);
	kapee_set_loop_prop( 'portfolio-content-part',$portfolio_content_part);
	kapee_set_loop_prop( 'portfolio-grid-gap', $portfolio_grid_gap);
	kapee_set_loop_prop( 'portfolio-filter',$portfolio_filter);
	kapee_set_loop_prop( 'portfolio-button-icon',$portfolio_button_icon);
	kapee_set_loop_prop( 'portfolio-link-icon',$portfolio_link_icon);
	kapee_set_loop_prop( 'portfolio-zoom-icon',$portfolio_zoom_icon);
	kapee_set_loop_prop( 'portfolio-content-part',$portfolio_content_part);
	kapee_set_loop_prop( 'portfolio-category',$portfolio_category);
	kapee_set_loop_prop( 'portfolio-title',$portfolio_title);
		
	while ( $loop->have_posts() ) :
		$loop->the_post();			
		// Include the loop post content template.
		get_template_part( 'template-parts/portfolio-loop/layout', get_post_format() );   
	endwhile;
	wp_reset_postdata();
	kapee_reset_loop();
	$response['html']    = ob_get_clean();
	$response['success'] = 'ok';
	$response['show_bt'] = $show_button;
	wp_send_json( $response );
	die();
}

/**
 * Visual composer callback and rendar functions
 */
 function kapee_get_icon_class($type_icon='',$section = array()){
	$class_icon = '';
	if( $type_icon =='fontawesome') {
		$class_icon = isset($section["i_icon_". $type_icon]) ? $section["i_icon_". $type_icon] : 'fa fa-adjust';
	}
	if( $type_icon =='openiconic') {
		$class_icon = isset($section["i_icon_". $type_icon]) ? $section["i_icon_". $type_icon] : 'vc-oi vc-oi-dial';			
	}
	if( $type_icon =='typicons') {
		$class_icon = isset($section["i_icon_". $type_icon]) ? $section["i_icon_". $type_icon] : 'typcn typcn-adjust-brightness';			
	}
	if( $type_icon =='entypo') {
		$class_icon = isset($section["i_icon_". $type_icon]) ? $section["i_icon_". $type_icon] : 'entypo-icon entypo-icon-note';			
	}
	if( $type_icon =='linecons') {
		$class_icon = isset($section["i_icon_". $type_icon]) ? $section["i_icon_". $type_icon] : 'vc_li vc_li-heart';			
	}
	if( $type_icon =='monosocial') {
		$class_icon = isset($section["i_icon_". $type_icon]) ? $section["i_icon_". $type_icon] : 'vc-mono vc-mono-fivehundredpx';			
	}
	if( $type_icon =='material') {
		$class_icon = isset($section["i_icon_". $type_icon]) ? $section["i_icon_". $type_icon] : 'vc-material vc-material-cake';			
	}
	return $class_icon;
 }
 /**
 * Post category search
 * @param $search_string
 *
 * @return array
 */
function kapee_post_category_search( $search_string ) {
	$query = $search_string;
	$data = array();
	$args = array(
		'name__like' => $query,
		'taxonomy' => 'category',
	);
	$result = get_terms( $args );
	if ( is_wp_error( $result ) ) {
		return $data;
	}
	if ( !is_array( $result ) || empty( $result ) ) {
		return $data;
	}
	foreach ( $result as $term_data ) {
		if ( is_object( $term_data ) && isset( $term_data->name, $term_data->term_id ) ) {
			$data[] = array(
				'value' => $term_data->term_id,
				'label' => $term_data->name,
				'group' => 'category',
			);
		}
	}

	return $data;
}

/**
 * Post category render
 * @param $value
 *
 * @return array|bool
 */
function kapee_post_category_render( $value ) {
	$post = get_post( $value['value'] );
	$term_data = get_term_by( 'id',  $value['value'],'category' );

	return is_null( $term_data ) ? false : array(
		'label' => $term_data->name,
		'value' => $term_data->term_id,
		'group' => 'category',
	);
}

 /**
 * Post search
 * @param $search_string
 *
 * @return array
 */
function kapee_post_id_search( $search_string ) {
	$query = $search_string;
	$data = array();
	$args = array(
		's' => $query,
		'post_type' => 'post',
	);
	$args['vc_search_by_title_only'] = true;
	$args['numberposts'] = - 1;
	if ( 0 === strlen( $args['s'] ) ) {
		unset( $args['s'] );
	}
	add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
	$posts = get_posts( $args );
	if ( is_array( $posts ) && ! empty( $posts ) ) {
		foreach ( $posts as $post ) {
			$data[] = array(
				'value' => $post->ID,
				'label' => $post->post_title,
				'group' => $post->post_type,
			);
		}
	}

	return $data;
}

/**
 * @param $value
 *
 * Post render
 * @return array|bool
 */
function kapee_post_id_render( $value ) {
	$post = get_post( $value['value'] );

	return is_null( $post ) ? false : array(
		'label' => $post->post_title,
		'value' => $post->ID,
		'group' => $post->post_type,
	);
}


 /**
 * Product search
 * @param $search_string
 *
 * @return array
 */
function kapee_product_id_search( $search_string ) {
	$query = $search_string;
	$data = array();
	$args = array(
		's' => $query,
		'post_type' => 'product',
	);
	$args['vc_search_by_title_only'] = true;
	$args['numberposts'] = - 1;
	if ( 0 === strlen( $args['s'] ) ) {
		unset( $args['s'] );
	}
	add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
	$posts = get_posts( $args );
	if ( is_array( $posts ) && ! empty( $posts ) ) {
		foreach ( $posts as $post ) {
			$data[] = array(
				'value' => $post->ID,
				'label' => $post->post_title,
				'group' => $post->post_type,
			);
		}
	}

	return $data;
}

/**
 * Product render
 * @param $value
 *
 * @return array|bool
 */
function kapee_product_id_render( $value ) {
	$post = get_post( $value['value'] );

	return is_null( $post ) ? false : array(
		'label' => $post->post_title,
		'value' => $post->ID,
		'group' => $post->post_type,
	);
}

 /**
 * Product category search
 * @param $search_string
 *
 * @return array
 */
function kapee_product_category_search( $search_string ) {
	$query = $search_string;
	$data = array();
	$args = array(
		'name__like' 	=> $query,
		'taxonomy' 		=> 'product_cat',
		'hide_empty' 	=> false,
	);
	$result = get_terms( $args );
	if ( is_wp_error( $result ) ) {
		return $data;
	}
	if ( !is_array( $result ) || empty( $result ) ) {
		return $data;
	}
	foreach ( $result as $term_data ) {
		if ( is_object( $term_data ) && isset( $term_data->name, $term_data->term_id ) ) {
			$data[] = array(
				'value' => $term_data->term_id,
				'label' => $term_data->name,
				'group' => 'product_cat',
			);
		}
	}

	return $data;
}

/**
 * Product category render
 * @param $value
 *
 * @return array|bool
 */
function kapee_product_category_render( $value ) {
	$post = get_post( $value['value'] );
	$term_data = get_term_by( 'id',  $value['value'],'product_cat' );

	if($term_data ){
		return is_null( $term_data ) ? false : array(
			'label' => $term_data->name,
			'value' => $term_data->term_id,
			'group' => 'product_cat',
		);	
	}	
}

/**
 * Product brand search
 * @param $search_string
 *
 * @return array
 */
function kapee_product_brand_search( $search_string ) {
	$query = $search_string;
	$data = array();
	$args = array(
		'name__like' 	=> $query,
		'taxonomy' 		=> 'product_brand',
		'hide_empty' 	=> false,
	);
	$result = get_terms( $args );
	if ( is_wp_error( $result ) ) {
		return $data;
	}
	if ( !is_array( $result ) || empty( $result ) ) {
		return $data;
	}
	foreach ( $result as $term_data ) {
		if ( is_object( $term_data ) && isset( $term_data->name, $term_data->term_id ) ) {
			$data[] = array(
				'value' => $term_data->term_id,
				'label' => $term_data->name,
				'group' => 'product_brand',
			);
		}
	}

	return $data;
}

/**
 * Product brand render
 * @param $value
 *
 * @return array|bool
 */
function kapee_product_brand_render( $value ) {
	$post = get_post( $value['value'] );
	$term_data = get_term_by( 'id',  $value['value'],'product_brand' );

	return is_null( $term_data ) ? false : array(
		'label' => $term_data->name,
		'value' => $term_data->term_id,
		'group' => 'product_brand',
	);
}



/**
 * Function displaying social share
 */
if ( ! function_exists( 'kapee_social_share' ) ) :
	function kapee_social_share( $atts = array(), $echo = true ) {
		
		if( ! kapee_social_share_enable() ) false;
		
		extract(shortcode_atts( array(
			'type' 			=> 'share',			
			'style' 		=> 'icon-bordered',
			'shape' 		=> 'icons-shape-circle',
			'size' 			=> 'icons-size-default',
			'css_animation' => 'none',
			'el_class' 		=> '',
		), $atts ));
		
		$classes []		= 'kapee-social';
		$classes []		= $style;
		$classes []		= $shape;
		$classes []		= $size;
		$classes []		= ( $el_class ) ? $el_class : '';
		$classes []		= kapee_get_css_animation( $css_animation );
		$classes 		= implode( ' ', $classes );		
		$post_title 	= '';
		$post_link 		= '';
		$share_twitter_username = '';
		$thumb_id 		= '';
		$thumb_url 		= array( 0=> '' );
		$enabled_social_networks = array();
		
		if($type == 'share' && kapee_get_option('show-social-sharing', 1 ) ){
			$post_title   = htmlspecialchars( urlencode( html_entity_decode( esc_attr( get_the_title() ), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
			$post_link = get_the_permalink();
			// Twitter username
			$share_twitter_username = kapee_get_option( 'share_twitter_username', '' ) ? ' via %40'.kapee_get_option( 'share_twitter_username','' ) : '';
			$thumb_id 	= get_post_thumbnail_id();
			$thumb_url 	= wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true );
			$social_networks = (array) kapee_get_option( 'social-share-manager', array(
                'enabled'  =>array(
					'facebook' 		=> 'Facebook',
					'twitter'     	=> 'Twitter',
					'linkedin'   	=> 'Linkedin',
					'telegram'		=> 'Telegram',
					'pinterest'		=> 'Pinterest',
				)
			));
			
			if(!isset($social_networks['enabled'])){
				$social_networks['enabled'] = array(
					'facebook' 		=> 'Facebook',
					'twitter'     	=> 'Twitter',
					'linkedin'   	=> 'Linkedin',
					'telegram'		=> 'Telegram',
					'pinterest'		=> 'Pinterest',
				);
			}
			
			$enabled_social_networks = $social_networks['enabled'];			
		}
		
		// Buttons array
		$share_buttons = array(

			'facebook' => array(
				'url'  => 'https://www.facebook.com/sharer/sharer.php?u='. $post_link,
				'text' => esc_html__( 'Facebook', 'kapee' ),
				'icon' => 'pls-facebook',
			),

			'twitter' => array(
				'url'   => 'https://twitter.com/share?url='. $post_title . $share_twitter_username .'&amp;url='. $post_link,
				'text'  => esc_html__( 'Twitter', 'kapee' ),
				'icon' => 'pls-x-twitter',
			),

			'linkedin' => array(
				'url'  => 'https://www.linkedin.com/shareArticle?mini=true&url='. $post_link .'&amp;title='. $post_title,
				'text' => esc_html__( 'LinkedIn', 'kapee' ),
				'icon' => 'pls-linkedin',
			),

			'stumbleupon' => array(
				'url'  => 'http://www.stumbleupon.com/submit?url='. $post_link .'&amp;title='. $post_title,
				'text' => esc_html__( 'StumbleUpon', 'kapee' ),
				'icon' => 'pls-stumbleupon',
			),

			'tumblr' => array(
				'url'  => 'https://tumblr.com/widgets/share/tool?canonicalUrl='. $post_link .'&amp;name='. $post_title,
				'text' => esc_html__( 'Tumblr', 'kapee' ),
				'icon' => 'pls-tumblr',
			),

			'pinterest' => array(
				'url'  => 'https://pinterest.com/pin/create/button/?url='. $post_link .'&amp;description='. $post_title .'&amp;media='. $thumb_url[0],
				'text' => esc_html__( 'Pinterest', 'kapee' ),
				'icon' => 'pls-pinterest-alt',
			),

			'reddit' => array(
				'url'  => 'https://reddit.com/submit?url='. $post_link .'&amp;title='. $post_title,
				'text' => esc_html__( 'Reddit', 'kapee' ),
				'icon' => 'pls-reddit',
			),
			'vk' => array(
				'url'  => 'https://vk.com/share.php?url='. $post_link,
				'text' => esc_html__( 'VKontakte', 'kapee' ),
				'icon' => 'pls-vk',
			),
			
			'odnoklassniki' => array(
				'url'  => 'https://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl='. $post_link .'&amp;description='. $post_title .'&amp;media='. $thumb_url[0],
				'text' => esc_html__( 'Odnoklassniki', 'kapee' ),
				'icon' => 'pls-odnoklassniki',
			),
			
			'pocket' => array(
				'url'  => 'https://getpocket.com/save?title='. $post_title .'&amp;url='.$post_link,
				'text' => esc_html__( 'Pocket', 'kapee' ),
				'icon' => 'pls-pocket',
			),
			
			'whatsapp' => array(
				'url'   => 'https://wa.me/?text='. $post_link,
				'text'  => esc_html__( 'WhatsApp', 'kapee' ),
				'icon' => 'pls-whatsapp',
				'avoid_esc' => true,
			),
			
			'telegram' => array(
				'url'   => 'https://telegram.me/share/url?url='.$post_link,
				'text'  => esc_html__( 'Telegram', 'kapee' ),
				'icon'  => 'pls-telegram',
				'avoid_esc' => true,
			),	
			
			'email' => array(
				'url'  => 'mailto:?subject='. $post_title .'&amp;body='. $post_link,
				'text' => esc_html__( 'Email', 'kapee' ),
				'icon' => 'pls-envelope',
			),
			
			'print' => array(
				'url'  => '#',
				'text' => esc_html__( 'Print', 'kapee' ),
				'icon' => 'pls-printer',
				'check'=> kapee_get_option('share-print', 0 ),
			),
			
			'tiktok' => array(
				'url'  => '#',
				'text' => esc_html__( 'TikTok', 'kapee' ),
				'icon' => 'pls-tik-tok',
			),
			
			'instagram' => array(
				'url'  => '#',
				'text' => esc_html__( 'Instagram', 'kapee' ),
				'icon' => 'pls-instagram',
			),
			
			'flickr' => array(
				'url'  => '#',
				'text' => esc_html__( 'Flickr', 'kapee' ),
				'icon' => 'pls-flickr',
			),
			
			'rss' => array(
				'url'  => '#',
				'text' => esc_html__( 'RSS', 'kapee' ),
				'icon' => 'pls-feed',
			),
			
			'youtube' => array(
				'url'  => '#',
				'text' => esc_html__( 'Youtube', 'kapee' ),
				'icon' => 'pls-youtube',
			),
			
			'github' => array(
				'url'  => '#',
				'text' => esc_html__( 'Github', 'kapee' ),
				'icon' => 'pls-github',
			),			
		);
		
		$share_buttons = apply_filters( 'kapee_social_share_buttons', $share_buttons );
		
		$active_share_buttons = array();
		
		foreach ( $share_buttons as $network => $button ){
			$social_link = '';
			
			if($type == 'share' && kapee_get_option('show-social-share', 1) && array_key_exists($network,$enabled_social_networks)){
				$social_link = $button['url'];
			}elseif($type == 'profile' && kapee_get_option('show-social-profile', 1) && kapee_get_option($network.'-link','')){
				$social_link = kapee_get_option($network.'-link','');
			}
			if( !empty($social_link)  && ! isset( $button['avoid_esc'] )){
				$button['url'] = esc_url( $social_link );
			}
			if(!empty($social_link)){
				$active_share_buttons[$network] = '<a href="'. $social_link .'" rel="external" target="_blank" class="social-'. $network.'"><i class="'. $button['icon'] .'"></i> <span class="social-text">'. $button['text'] .'</span></a>';
			}
		}
		
		/**
		* social share icon order
		*/
		$active_share = array();
		if( ! empty( $enabled_social_networks ) ){
			foreach($enabled_social_networks as $social_key => $value){
				if(isset($active_share_buttons[$social_key]))
				$active_share[$social_key] =  $active_share_buttons[$social_key]; 
			}
			$active_share_buttons = array_merge($active_share,$active_share_buttons);
		}
		if( is_array( $active_share_buttons ) && ! empty( $active_share_buttons ) ){
			if($echo){	?>
				<div class="<?php echo esc_attr($classes);?>">
					<?php echo implode( '', $active_share_buttons ); ?>
				</div>
			<?php			
			}else{
				return implode( '', $active_share_buttons );
			}		
		}		
	}
endif;

?>