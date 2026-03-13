<?php

/* Theme Widget sidebars. */
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/widget-base/abstract-widget-base.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-about-us.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-contact-us.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-block.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-author.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-recent-posts.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-social-links.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-tab-posts.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-instagram.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-twitter.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-facebook-page.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-flickr.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-posts-list.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-portfolios.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-products-tab.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-products.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-recent-viewed-products.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-recent-comments.php';
require KAPEE_EXTENSIONS_DIR . '/inc/widgets/class-newsletter.php';

add_action('widgets_init','kapee_register_widget');
function kapee_register_widget(){
	register_widget( 'Kapee_About_Us' );
	register_widget( 'Kapee_Contact_Us' );
	register_widget( 'Kapee_Author' );
	register_widget( 'Kapee_Recent_Posts' );
	register_widget( 'Kapee_Social_Links' );
	register_widget( 'Kapee_Tab_Posts' );
	register_widget( 'Kapee_Instagram' );
	register_widget( 'Kapee_Twitter' );
	register_widget( 'Kapee_Facebook_Page' );
	register_widget( 'Kapee_Flickr' );
	register_widget( 'Kapee_Posts_List' );
	register_widget( 'Kapee_Portfolios' );
	register_widget( 'Kapee_Products_Tab' );
	register_widget( 'Kapee_Products' );
	register_widget( 'Kapee_Recent_Viewed_Products' );
	register_widget( 'Kapee_Recent_Comments' );
	register_widget( 'Kapee_Newsletter' );
	if ( class_exists( 'WC_Widget' ) ) {	
		require KAPEE_EXTENSIONS_DIR . '/inc/widgets/woocommerce-product-attributes-filter.php';
		require KAPEE_EXTENSIONS_DIR . '/inc/widgets/woocommerce-product-brand.php';
		require KAPEE_EXTENSIONS_DIR . '/inc/widgets/woocommerce-product-sorting.php';
		require KAPEE_EXTENSIONS_DIR . '/inc/widgets/woocommerce-price-filter.php';
		
		register_widget( 'Kapee_Widget_Attributes_Filter' );		
		register_widget( 'Kapee_Widget_Product_Brands' );		
		register_widget( 'Kapee_WC_Widget_Product_Sorting' );		
		register_widget( 'Kapee_Price_Filter_List_Widget' );
	}
}