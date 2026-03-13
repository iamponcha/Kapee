<?php
/*
Element: Block
*/
class vcBlock extends WPBakeryShortCode {

    function __construct() {
        //$this->_mapping();
        add_shortcode( 'kapee_block', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }	
		$block_lists = kapee_get_posts_dropdown(KAPEE_EXTENSIONS_BLOCK_POST_TYPE,__('Select Block','kapee-extensions'));
		vc_map( array(
			'name'			=> esc_html__( 'Block', 'kapee-extensions' ),
			'base'			=> 'kapee_block',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Display list items.', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Select Block', 'kapee-extensions' ),
					'value' 		=> array_flip($block_lists),
					'param_name' 	=> 'id'
				),
			),
		) );
	}
	
	public function _html( $atts) {
		$args = ( shortcode_atts( array(
			'id' 	=> '',
		), $atts ) );
		extract( $args );
		
		if( empty( $id ) ){ return;}
		
		$post 		= get_post( $id );
		$content 	= '';		
		if ( ! $post || $post->post_type != 'block' ) { return; }
		
		if( class_exists('WPBMap') && method_exists( 'WPBMap', 'addAllMappedShortcodes' ) ){
			WPBMap::addAllMappedShortcodes();
		}
		
		$content 				= do_shortcode(get_post_field( 'post_content', $id) );	
		$shortcodes_custom_css 	= get_post_meta( $id, '_wpb_shortcodes_custom_css', true );	
		if ( ! empty( $shortcodes_custom_css ) ) {
			$content .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
			$content .= $shortcodes_custom_css;
			$content .= '</style>';
		}
		return $content;
	}	
}
new vcBlock();
?>