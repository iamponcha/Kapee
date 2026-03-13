<?php
/**
 *	Kapee Widget: Facebook Page
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Facebook_Page extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass = 'kapee-facebook-page';
        $this->widget_description = esc_html__("Display facebook page.", 'kapee-extensions');
        $this->widget_id = 'kapee-facebook-page';
        $this->widget_name = esc_html__('KP: Facebook Page', 'kapee-extensions');
		$width_options = $this->kapee_width_options();
		$height_options = $this->kapee_height_options();
		$this->settings = array(
            'title' => array(
                'type' 	=> 'text',
                'label' => esc_html__('Title:', 'kapee-extensions'),
				'std' 	=> 'Facebook Page',
            ),
			'page_url' => array(
                'type' 	=> 'text',
                'label' => esc_html__('Facebook Page URL:', 'kapee-extensions'),
				'std'	=> 'https://www.facebook.com/facebook',
            ),
			'width' => array(
                'type' 		=> 'select',
                'label' 	=> esc_html__('Width:', 'kapee-extensions'),
				'options' 	=> $width_options,
				'std' 		=> 280,
            ),
			'height' => array(
                'type' 		=> 'select',
                'label' 	=> esc_html__('Height:', 'kapee-extensions'),
				'options' 	=> $height_options,
				'std' 		=> 250,
            ),			
			'show_cover_photo' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Show Cover Photo?', 'kapee-extensions'),
				'std' => true,
            ),
			'show_facepile' => array(
                'type' 	=> 'checkbox',
                'label' => esc_html__('Show Facepile?', 'kapee-extensions'),
				'std' 	=> false,
            ),
			'show_action_button' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Show Call to Action button?', 'kapee-extensions'),
				'std' => false,
            ),
			'show_small_header' => array(
                'type' 	=> 'checkbox',
                'label' => esc_html__('Small Header?', 'kapee-extensions'),
                'std' 	=> false,
            ),
			'show_timeline' => array(
                'type' 	=> 'checkbox',
                'label' => esc_html__('Show Timeline Tab?', 'kapee-extensions'),
                'std' 	=> true,
            ),
			'show_events' => array(
                'type' 	=> 'checkbox',
                'label' => esc_html__('Show Events Tab?', 'kapee-extensions'),
                'std' 	=> false,
            ),
			'show_message' => array(
                'type' 	=> 'checkbox',
                'label' => esc_html__('Show Messages Tab?', 'kapee-extensions'),
                'std' 	=> false,
            ),
			'adapt_container_width' => array(
                'type' 	=> 'checkbox',
                'label' => esc_html__('Adapt to container width?', 'kapee-extensions'),
                'std' 	=> true,
            ),			
		);
		parent::__construct();
	}
	
	/**
     * Output widget.
     *
     * @see WP_Widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance){

        ob_start();
		
		$this->widget_start($args, $instance);
		
		do_action( 'kapee_before_facebook_page_widget');
		
		$page_url 				= (!empty($instance['page_url'])) ?  $instance['page_url'] : '';
		$width 					= (!empty($instance['width'])) ?  $instance['width'] : 280;
		$height					= (!empty($instance['height'])) ?  $instance['height'] : 250;		
		$show_cover_photo 		= $instance['show_cover_photo'] ? "false" : "true" ;
		$show_facepile 			= $instance['show_facepile'] ?  "true" : "false";
		$show_action_button 	= $instance['show_action_button'] ? "false"  : "true";
		$show_small_header 		= $instance['show_small_header'] ? "true" : "false";
		$show_timeline 			= $instance['show_timeline'] ?  true : false;
		$show_events 			= $instance['show_events'] ?  true : false;
		$show_message 			= $instance['show_message'] ?  true : false;
		$adapt_container_width 	= $instance['adapt_container_width'] ?  "true" : "false";
		
		$tab_output = array();
	
		if ( $show_timeline) {
			array_push( $tab_output, 'timeline' );
		}
		if ( $show_events ) {
			array_push( $tab_output, 'events' );
		}
		if ( $show_message) {
			array_push( $tab_output, 'messages' );
		}
		
		$output = '';
		//* Wrapper for alignment
		$output .= '<div class="kapee-facebook-page-widget">';
		//$page_url = '';
		if ( false !== strpos( $page_url, 'facebook.com' ) ) {
			$page_url = str_replace( 'https://', 'http://', $page_url );
		}else{
			$page_url = "http://facebook.com/" . esc_attr( $page_url );
		}
		//* Main Facebook Feed
		$output .= '<div class="fb-page" ';
		
		$output .= 'data-href="'.$page_url.'" ';
		$output .= 'data-width="' . esc_attr( $width ) . '" ';
		$output .= 'data-height="' . esc_attr( $height ) . '" ';
		$output .= 'data-tabs="' . implode( ', ', $tab_output ) . '" ';
		$output .= 'data-hide-cover="' . esc_attr( $show_cover_photo ) . '" ';
		$output .= 'data-show-facepile="' . esc_attr( $show_facepile ) . '" ';
		$output .= 'data-hide-cta="' . esc_attr( $show_action_button ) . '" ';
		$output .= 'data-small-header="' . esc_attr( $show_small_header ) . '" ';
		$output .= 'data-adapt-container-width="' . esc_attr( $adapt_container_width ) . '">';	
		$output .= '</div>';
		
		// end wrapper
		$output .= '</div>';

		echo $output;
		$lang = get_locale();
		$facebook_apid = kapee_get_option('facebook_apid', '297186066963865');
		?>
		<div id="fb-root"></div>
		<script>(function(d, s, id){
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/<?php echo esc_attr($lang)?>/sdk.js#xfbml=1&version=v2.8&appId=\"<?php echo $facebook_apid;?>\"";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<?php
		//wp_enqueue_script('kapee-fb-root');
		do_action( 'kapee_after_facebook_page_widget');

		$this->widget_end($args);

        echo ob_get_clean();
    }
	
	public function kapee_width_options(){
		/**
		 * The pixel width of the plugin.
		 * Min. is 280
		 * Max. is 500
		 *
		 * @var $width array Defaults to 340.
		 */
		$width = range( 280, 500, 20 );
		$width_array 	= array();
		foreach ( $width as $val ){
			$width_array[$val] = $val;
		}
		return $width_array;
	}
	
	public function kapee_height_options(){
		/**
		 * The maximum pixel height of the plugin.
		 * Min. is 130
		 *
		 * @var $height array Defaults to 500.
		 */
		$height = range( 125, 800, 25 );
		$height_array 	= array();
		foreach ( $height as $val ){
			$height_array[$val] = $val;
		}
		return $height_array;
}

}
