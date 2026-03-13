<?php 
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 
 * @since 1.0.0
 */
// Exit if accessed directly

if ( !defined( 'ABSPATH' ) ) exit;

class Kapee_Style_Script {
	
	function __construct() {
		
		// Action to add script at front side
		add_action( 'wp_enqueue_scripts', array($this, 'kapee_front_script') );
		
		// Action to add style in backend
		add_action( 'admin_enqueue_scripts', array($this, 'kapee_admin_style') );
		
		// Action to add script at admin side
		add_action( 'admin_enqueue_scripts', array($this, 'kapee_admin_script') );
	}
	
	/**
	* Function to add script at front side
	*/
	function kapee_front_script(){
		
		wp_localize_script( 'kapee-fb-root', 'kapee_fb_options', array( 
			'facebook_apid'	=> 297186066963865, 
			'language' 		=> defined( 'WPLANG' ) ? WPLANG : get_locale() 
		) );
	}
	
	/**
	* Function to add style at admin side
	*/
	function kapee_admin_style(){
		// Registring and enqueing admin css		
		wp_enqueue_style( 'wp-color-picker' );
		wp_register_style( 'kapee-admin-css', KAPEE_EXTENSIONS_URL.'assets/css/kapee-admin.css', null, KAPEE_EXTENSIONS_VERSION );
		wp_enqueue_style( 'kapee-admin-css' );
		wp_register_style( 'kapee-edittable-css', KAPEE_EXTENSIONS_URL.'inc/admin/assets/css/jquery.edittable.css', null, time() );
		wp_enqueue_style('kapee-edittable-css');
	}
	
	/**
	* Function to add script at front side
	*/
	function kapee_admin_script(){
		
		// Registring public script
		
		wp_register_script( 'kapee-edittable-js', KAPEE_EXTENSIONS_URL.'inc/admin/assets/js/jquery.edittable.js', array('jquery'), time(), true );
		wp_enqueue_script('kapee-edittable-js');
	}
}
$kapee_style_script_obj = new Kapee_Style_Script();