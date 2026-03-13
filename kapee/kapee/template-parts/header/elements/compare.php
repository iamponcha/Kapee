<?php
/**
 * Template part for displaying compare in header.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/header
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! kapee_get_option( 'header-compare', 1 ) || ! KAPEE_WOOCOMMERCE_ACTIVE || ! defined( 'YITH_WOOCOMPARE' ) ) { return; }

if(class_exists('YITH_WooCompare_Products_List') ){
	wp_enqueue_script( 'yith-woocompare-main' );
	$PL_YITH_Products_List = new YITH_WooCompare_Products_List();			
	$compare_count = $PL_YITH_Products_List->count(); 
	
}else{
	global $yith_woocompare; 
	$compare_count = count( $yith_woocompare->obj->products_list ); 
}
?>			

<div class="header-compare">
	<a href="#" class="yith-woocompare-open"><span class="header-compare-icon"><span class="header-compare-count"><?php echo esc_html( $compare_count );?></span></span></a>	
</div>
