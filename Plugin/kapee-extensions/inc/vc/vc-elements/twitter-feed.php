<?php
/**
 * Element: Twitter Feed
 */
class vcTwitterFeed extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_twitter_feed', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }		
		vc_map( array(
			'name'			=> esc_html__( 'Twitter', 'kapee-extensions' ),
			'base'			=> 'kapee_twitter_feed',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Twitter feed.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				//General
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Title', 'kapee-extensions' ),
					'param_name' 	=> 'title',
					'description' 	=> esc_html__( 'Enter title.', 'kapee-extensions' ),
					'std' 			=> 'Twitter',
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Twitter Name (without @ symbol)', 'kapee-extensions' ),
					'param_name' 	=> 'username',
					'description' 	=> esc_html__( 'Enter username.', 'kapee-extensions' ),
					'std' 			=> '',
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Number Of Tweets', 'kapee-extensions' ),
					'param_name' 	=> 'number_of_tweets',
					'std' 			=> '5',
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Consumer Key', 'kapee-extensions' ),
					'param_name' 	=> 'consumer_key',
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Consumer Secret', 'kapee-extensions' ),
					'param_name' 	=> 'consumer_secret_key',
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Access Token', 'kapee-extensions' ),
					'param_name' 	=> 'access_token',
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Access Token Secret', 'kapee-extensions' ),
					'param_name' 	=> 'access_token_secret',
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Show your avatar image', 'kapee-extensions' ),
					'param_name' 	=> 'show_avatar',
					'value' 		=> '1',
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				//Style
				array(
					'type' 			=> 'css_editor',
					'heading' 		=> esc_html__( 'CSS box', 'kapee-extensions' ),
					'param_name' 	=> 'css',
					'group' 		=> esc_html__( 'Design Options', 'kapee-extensions' )
				)
			),
		) );
	}
	
	public function _html( $atts, $content ) {
		$args = shortcode_atts( array(
			'title' 				=> esc_html__( 'Twitter Feed', 'kapee-extensions' ),
			'username' 				=> '',
			'number_of_tweets' 		=> '5',
			'consumer_key' 			=> '',
			'consumer_secret_key'	=> '',
			'access_token'			=> '',
			'access_token_secret'	=> '',
			'show_avatar'			=> 0,
			'css_animation' 		=> 'none',	
			'el_class'				=> '',
			'css'					=> '',
		), $atts );		
		extract($args);
		
		if(empty($username)) return;
		$class				= array();
		$class[]			= 'kapee-element';
		$class[]			= 'kapee-twitter';
		$class[]			= $el_class;
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		$class[]			= kapee_get_css_animation($css_animation);
		$args['class'] 		= implode(' ',array_filter($class));		
		$tweets 			= kapee_get_twitter_feed($username,$consumer_key,$consumer_secret_key,$access_token,$access_token_secret,$number_of_tweets);
		$args['tweets'] 	= $tweets;		
		ob_start();
			kapee_get_pl_templates('shortcodes/twitter-feed',$args );	
		return ob_get_clean();
	}	
}
new vcTwitterFeed();