<?php
/*
Plugin Name: Kapee Extensions
Plugin URI: https://themeforest.net/user/presslayouts
Description: Adds additional functionality like VC shortcode, posts, widgets, theme options and data importer to Kapee Theme.
Version: 1.3.0
Author: PressLayouts
Author URI: https://presslayouts.com
Text Domain: kapee-extensions
*/

if ( 'kapee' !== get_template() ) {
	return;
}

if( !defined( 'KAPEE_EXTENSIONS_VERSION' ) ) {
    define( 'KAPEE_EXTENSIONS_VERSION', '1.3' ); // Version of plugin
}
if( !defined( 'KAPEE_EXTENSIONS_DIR' ) ) {
    define( 'KAPEE_EXTENSIONS_DIR', dirname( __FILE__ ) ); // Plugin dir
}
if( !defined( 'KAPEE_EXTENSIONS_URL' ) ) {
    define( 'KAPEE_EXTENSIONS_URL', plugin_dir_url( __FILE__ ) ); // Plugin url
}
if( !defined( 'KAPEE_EXTENSIONS_PLUGIN_BASENAME' ) ) {
    define( 'KAPEE_EXTENSIONS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) ); // Plugin base name
}
if( !defined( 'KAPEE_EXTENSIONS_PORTFOLIO_POST_TYPE' ) ) {
    define( 'KAPEE_EXTENSIONS_PORTFOLIO_POST_TYPE', 'portfolio' ); // Portfolio post type
}
if( !defined( 'KAPEE_EXTENSIONS_PORTFOLIO_CAT' ) ) {
    define( 'KAPEE_EXTENSIONS_PORTFOLIO_CAT', 'portfolio_cat' ); // portfolio taxonomy name
}
if( !defined( 'KAPEE_EXTENSIONS_PORTFOLIO_SKILL' ) ) {
    define( 'KAPEE_EXTENSIONS_PORTFOLIO_SKILL', 'portfolio_skill' ); // portfolio taxonomy name
}

if( !defined( 'KAPEE_EXTENSIONS_BLOCK_POST_TYPE' ) ) {
    define( 'KAPEE_EXTENSIONS_BLOCK_POST_TYPE', 'block' ); // Block post type
}

if( !defined( 'KAPEE_EXTENSIONS_BLOCK_POST_CAT' ) ) {
    define( 'KAPEE_EXTENSIONS_BLOCK_POST_CAT', 'block_cat' ); // block category
}

if( !defined( 'KAPEE_EXTENSIONS_META_PREFIX' ) ) {
    define( 'KAPEE_EXTENSIONS_META_PREFIX', '_kp_' ); // Plugin metabox prefix
}

if( !defined( 'KAPEE_EXTENSIONS_SIZE_CHART_POST_TYPE' ) ) {
    define( 'KAPEE_EXTENSIONS_SIZE_CHART_POST_TYPE', 'kp_size_chart' ); // sizechart post type
}

/**
 * Load Text Domain
 * This gets the plugin ready for translation
 * 
 * @package Kapee Extensions
 * @since 1.0
 */
add_action('plugins_loaded', 'kapee_extensions_load_textdomain');
function kapee_extensions_load_textdomain() {

    global $wp_version;

    // Set filter for plugin's languages directory
    $kapee_extensions_lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
    $kapee_extensions_lang_dir = apply_filters( 'kapee_extensions_languages_directory', $kapee_extensions_lang_dir );

    // Traditional WordPress plugin locale filter.
    $get_locale = get_locale();

    if ( $wp_version >= 4.7 ) {
        $get_locale = get_user_locale();
    }

    // Traditional WordPress plugin locale filter
    $locale = apply_filters( 'plugin_locale',  $get_locale, 'kapee-extensions' );
    $mofile = sprintf( '%1$s-%2$s.mo', 'kapee-extensions', $locale );

    // Setup paths to current locale file
    $mofile_global  = WP_LANG_DIR . '/plugins/' . basename( KAPEE_EXTENSIONS_DIR ) . '/' . $mofile;

    if ( file_exists( $mofile_global ) ) { // Look in global /wp-content/languages/plugin-name folder
        load_textdomain( 'kapee-extensions', $mofile_global );
    } else { // Load the default language files
        load_plugin_textdomain( 'kapee-extensions', false, $kapee_extensions_lang_dir );
    }    
}


/**
 * Activation Hook
 * 
 * Register plugin activation hook.
 * 
 * @package Kapee Extensions
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'kapee_extensions_install' );

/**
 * Deactivation Hook
 * 
 * Register plugin deactivation hook.
 * 
 * @package Kapee Extensions
 * @since 1.0.0
 */
register_deactivation_hook( __FILE__, 'kapee_extensions_uninstall');

/**
 * Plugin Setup (On Activation)
 * 
 * Does the initial setup,
 * stest default values for the plugin options.
 * 
 * @package Kapee Extensions
 * @since 1.0.0
 */
function kapee_extensions_install() {  
    
    //kapee_extensions_register_portfolio_post_type();
    //kapee_extensions_register_portfolio_taxonomies();

    // IMP need to flush rules for custom registered post type
    flush_rewrite_rules();
}

/**
 * Plugin Setup (On Deactivation)
 * 
 * Delete  plugin options.
 * 
 * @package Kapee Extensions
 * @since 1.0.0
 */
function kapee_extensions_uninstall() {
    // Uninstall functionality
}

//function kapee_load_files(){

//Load admin files
require_once KAPEE_EXTENSIONS_DIR .'/inc/admin/meta-box/meta-box.php';
require_once KAPEE_EXTENSIONS_DIR .'/inc/admin/custom-field-image-set.php';
require_once KAPEE_EXTENSIONS_DIR .'/inc/admin/custom-field-select-group.php';
require_once KAPEE_EXTENSIONS_DIR .'/inc/admin/redux-core/framework.php';

// Load functions file
require_once KAPEE_EXTENSIONS_DIR .'/inc/functions.php';

// Load style and CSS
require_once KAPEE_EXTENSIONS_DIR .'/inc/kp-style-scripts.php';

// Load Custom Post types
require_once KAPEE_EXTENSIONS_DIR .'/post-types/class-kapee-posts.php';
require_once KAPEE_EXTENSIONS_DIR .'/inc/admin/class-admin.php';

if ( !class_exists('TwitterOAuth')) {
	// Load twitter
	require_once KAPEE_EXTENSIONS_DIR .'/inc/vendor/opauth/twitteroauth/twitteroauth.php';
}

// Load widgets
require_once KAPEE_EXTENSIONS_DIR .'/inc/widgets/init.php';

//Ajax search functions
require_once KAPEE_EXTENSIONS_DIR .'/inc/kp-search.php';

require_once KAPEE_EXTENSIONS_DIR .'/inc/vendor/autoload.php';
require_once KAPEE_EXTENSIONS_DIR .'/inc/admin/import.php';

//Load Visual Addon
require_once KAPEE_EXTENSIONS_DIR .'/inc/vc/vc-fields/init.php';
require_once KAPEE_EXTENSIONS_DIR .'/inc/vc/vc-elements/init.php';