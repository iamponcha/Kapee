<?php
/**
 * Element: Team Member
 */
class vcTeamMember extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_team_member', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }		
		
		vc_map( array(
			'name' 				=> esc_html__( 'Team Member', 'kapee-extensions' ),
			'base' 				=> 'kapee_team_member',
			'as_child' 			=> array( 'only' => 'kapee_team' ),
			'content_element' 	=> true,
			'category' 			=> esc_html__( 'Theme elements', 'kapee-extensions' ),
			'description' 		=> esc_html__( 'Display information about member', 'kapee-extensions' ),
        	'icon' 				=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 			=> array(
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Name', 'kapee-extensions' ),
					'param_name' 	=> 'name',
					'value' 		=> '',
					'description' 	=> esc_html__( 'Enter member name', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Designation', 'kapee-extensions' ),
					'param_name' 	=> 'designation',
					'value' 		=> '',
					'description' 	=> esc_html__( 'Enter member designation', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'attach_image',
					'heading' 		=> esc_html__( 'Member Avatar', 'kapee-extensions' ),
					'param_name' 	=> 'image',
					'value' 		=> '',
					'description' 	=> esc_html__( 'Select image from media library.', 'kapee-extensions' )
				),				
				array(
					'type' 			=> 'textarea',
					'heading' 		=> esc_html__( 'Description', 'kapee-extensions' ),
					'param_name' 	=> 'description',
					'description' 	=> esc_html__( 'You can add some member bio here.', 'kapee-extensions' )
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Facebook link', 'kapee-extensions' ),
					'param_name' 	=> 'facebook'
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Twitter link', 'kapee-extensions' ),
					'param_name' 	=> 'twitter'
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Google+ link', 'kapee-extensions' ),
					'param_name' 	=> 'google_plus'
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Linkedin link', 'kapee-extensions' ),
					'param_name' 	=> 'linkedin'
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Skype link', 'kapee-extensions' ),
					'param_name' 	=> 'skype'
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Instagram link', 'kapee-extensions' ),
					'param_name' 	=> 'instagram'
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Youtube Link', 'kapee-extensions' ),
					'param_name' 	=> 'youtube'
				),
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
		global $team_args;
		$args = ( shortcode_atts( array(
			'name' 			=> '',
			'designation' 	=> '',
			'image' 		=> '',
			'description' 	=> '',
			'facebook'		=> '',
			'twitter' 		=> '',
			'google_plus' 	=> '',				
			'linkedin' 		=> '',				
			'skype' 		=> '',				
			'instagram' 	=> '',				
			'youtube' 		=> '',				
			'el_class' 		=> '',
			'css'			=> '',
		), $atts ) );
		$args = array_merge($args, $team_args);
		extract( $args );
		
		$args['id'] 		= kapee_uniqid('kapee-team-member-');	
		$class				= array();
		$class[]			= 'kapee-team-member';
		$class[]			= $member_class;
		$class[]			= $el_class;
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		$args['class'] 		= implode(' ',array_filter($class));		
		$image_output 		= wp_get_attachment_image( $image,  $img_size, false );
		$args['image'] 		= $image_output;
		//kapee_pre($args['image']);
		$team_social_data = array();
		if( ! empty( $facebook ) ){
			$team_social_data[] = array(
				'class'	=> 'facebook',
				'icon'	=> 'pls-facebook',
				'link'	=> $facebook,
			);
		}
		if( ! empty( $twitter ) ){
			$team_social_data[] = array(
				'class'	=> 'twitter',
				'icon'	=> 'pls-x-twitter',
				'link'	=> $twitter,
			);
		}
		if( ! empty( $google_plus ) ){
			$team_social_data[] = array(
				'class'	=> 'google-plus',
				'icon'	=> 'pls-google-plus',
				'link'	=> $google_plus,
			);
		}
		if( ! empty( $linkedin ) ){
			$team_social_data[] = array(
				'class'	=> 'linkedin',
				'icon'	=> 'pls-linkedin',
				'link'	=> $linkedin,
			);
		}
		if( ! empty( $skype ) ){
			$team_social_data[] = array(
				'class'	=> 'skype',
				'icon'	=> 'pls-skype',
				'link'	=> $skype,
			);
		}
		if( ! empty( $instagram ) ){
			$team_social_data[] = array(
				'class'	=> 'instagram',
				'icon'	=> 'pls-instagram',
				'link'	=> $instagram,
			);
		}
		if( ! empty( $youtube ) ){
			$team_social_data[] = array(
				'class'	=> 'youtube',
				'icon'	=> 'pls-youtube',
				'link'	=> $youtube,
			);
		}
		$args['team_social_data'] 	= $team_social_data;			
		
		ob_start();
			kapee_get_pl_templates('shortcodes/team/'.$style, $args );
		return ob_get_clean();
	}	
}
new vcTeamMember();