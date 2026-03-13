<?php 
/**
 * Load VC Elements
 */
if( defined( 'WPB_VC_VERSION' ) ) :
    add_action( 'vc_before_init', 'kapee_load_vc_element' );
    function kapee_load_vc_element() {
		if ( !defined( 'KAPEE_URI' ) ) { return; }
		if( class_exists( 'WooCommerce' ) ) {
			require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/woo-products-grid-carousel.php';
			require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/woo-products-with-banner.php';
			require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/woo-products-tabs.php';
			require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/woo-products-category-tab.php';
			require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/woo-products-and-categories-box.php';
			require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/woo-hot-deal-products.php';
			require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/woo-product-categories.php';
			require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/woo-product-categories-thumbnails.php';
			require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/woo-products-recently-viewed.php';
			require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/woo-product-brands.php';
			require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/woo-products-widget.php';
			if( class_exists('WeDevs_Dokan') ){
				require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/woo-dokan-vendors.php';
			}
			if( class_exists('WCMp') ){
				require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/woo-wcmp-vendors.php';
			}
			
			if( class_exists('WCVendors_Pro') ){
				require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/woo-wc-vendors.php';
			}
			
			if( class_exists('WCFMmp') ){
				require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/woo-wcfm-vendors.php';
			}
			
		}
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/vertical-menu.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/blog.php';
        require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/blog-carousel.php';
        require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/portfolio.php';
        require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/portfolio-carousel.php';
        require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/block.php';
        require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/button.php';
        require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/menu-block.php';
        require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/menu-item.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/list.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/heading.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/banner.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/banner-carousel.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/image-gallery.php';		
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/testimonials.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/testimonials-item.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/team.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/team-member.php';   
        require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/info-box.php';
        require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/counter.php';
        require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/countdown.php';
        require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/social-buttons.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/instagram.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/twitter-feed.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/video-player.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/spacing.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/newsletter.php';
		if( class_exists( 'WPCF7' ) ) {
			require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/contact-us.php';
		}
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/progress-bar.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/tabs.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/tour.php';
		require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/accordion.php';
		
		$vc_set_deafult_posttype = array('page','post',KAPEE_EXTENSIONS_PORTFOLIO_POST_TYPE,KAPEE_EXTENSIONS_BLOCK_POST_TYPE,KAPEE_EXTENSIONS_SIZE_CHART_POST_TYPE,'product');
		vc_set_default_editor_post_types( $vc_set_deafult_posttype );
    }
	
	require_once KAPEE_EXTENSIONS_DIR. '/inc/vc/vc-elements/vc-config.php';
	
	/* Shortcode : kapee_products_grid_carousel */
	add_filter( 'vc_autocomplete_kapee_products_grid_carousel_product_ids_callback',	'kapee_product_id_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_grid_carousel_product_ids_render', 'kapee_product_id_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_grid_carousel_categories_callback',	'kapee_product_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_grid_carousel_categories_render', 'kapee_product_category_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_grid_carousel_exclude_callback',	'kapee_product_id_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_grid_carousel_exclude_render', 'kapee_product_id_render', 10, 1 );
	/* Shortcode : kapee_products_with_banner */
	add_filter( 'vc_autocomplete_kapee_products_with_banner_exclude_callback',	'kapee_product_id_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_with_banner_exclude_render', 'kapee_product_id_render', 10, 1 );	
	add_filter( 'vc_autocomplete_kapee_products_with_banner_categories_callback',	'kapee_product_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_with_banner_categories_render', 'kapee_product_category_render', 10, 1 );
	/* Shortcode : kapee_products_tabs */
	add_filter( 'vc_autocomplete_kapee_products_tabs_categories_callback',	'kapee_product_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_tabs_categories_render', 'kapee_product_category_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_tabs_exclude_callback',	'kapee_product_id_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_tabs_exclude_render', 'kapee_product_id_render', 10, 1 );
	/* Shortcode : kapee_products_category_tab */
	add_filter( 'vc_autocomplete_kapee_products_category_tab_categories_callback',	'kapee_product_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_category_tab_categories_render', 'kapee_product_category_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_category_tab_exclude_callback',	'kapee_product_id_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_category_tab_exclude_render', 'kapee_product_id_render', 10, 1 );
	/* Shortcode : kapee_products_and_categories_box */
	add_filter( 'vc_autocomplete_kapee_products_and_categories_box_categories_callback',	'kapee_product_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_and_categories_box_categories_render', 'kapee_product_category_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_and_categories_box_parent_category_callback',	'kapee_product_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_and_categories_box_parent_category_render', 'kapee_product_category_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_and_categories_box_exclude_categories_callback',	'kapee_product_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_and_categories_box_exclude_categories_render', 'kapee_product_category_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_and_categories_box_exclude_callback',	'kapee_product_id_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_and_categories_box_exclude_render', 'kapee_product_id_render', 10, 1 );
	/* Shortcode : kapee_hot_deal_products */
	add_filter( 'vc_autocomplete_kapee_hot_deal_products_categories_callback',	'kapee_product_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_hot_deal_products_categories_render', 'kapee_product_category_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_hot_deal_products_product_ids_callback',	'kapee_product_id_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_hot_deal_products_product_ids_render', 'kapee_product_id_render', 10, 1 );
	/* Shortcode : kapee_product_categories */
	add_filter( 'vc_autocomplete_kapee_product_categories_categories_callback',	'kapee_product_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_product_categories_categories_render', 'kapee_product_category_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_product_categories_parent_category_callback',	'kapee_product_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_product_categories_parent_category_render', 'kapee_product_category_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_product_categories_exclude_categories_callback',	'kapee_product_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_product_categories_exclude_categories_render', 'kapee_product_category_render', 10, 1 );
	/* Shortcode : kapee_product_categories_thumbnail */
	add_filter( 'vc_autocomplete_kapee_product_categories_thumbnail_categories_callback',	'kapee_product_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_product_categories_thumbnail_categories_render', 'kapee_product_category_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_product_categories_thumbnail_parent_category_callback',	'kapee_product_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_product_categories_thumbnail_parent_category_render', 'kapee_product_category_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_product_categories_thumbnail_exclude_categories_callback',	'kapee_product_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_product_categories_thumbnail_exclude_categories_render', 'kapee_product_category_render', 10, 1 );
	/* Shortcode : kapee_products_widget */
	add_filter( 'vc_autocomplete_kapee_products_widget_categories_callback',	'kapee_product_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_widget_categories_render', 'kapee_product_category_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_widget_product_ids_callback',	'kapee_product_id_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_widget_product_ids_render', 'kapee_product_id_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_widget_exclude_callback',	'kapee_product_id_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_products_widget_exclude_render', 'kapee_product_id_render', 10, 1 );
	/* Shortcode : kapee_product_brands */
	add_filter( 'vc_autocomplete_kapee_product_brands_brands_callback',	'kapee_product_brand_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_product_brands_brands_render', 'kapee_product_brand_render', 10, 1 );
	/* Shortcode : kapee_blog */
	add_filter( 'vc_autocomplete_kapee_blog_categories_callback',	'kapee_post_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_blog_categories_render', 'kapee_post_category_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_blog_exclude_callback',	'kapee_post_id_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_blog_exclude_render', 'kapee_post_id_render', 10, 1 );
	/* Shortcode : kapee_blog_carousel */
	add_filter( 'vc_autocomplete_kapee_blog_carousel_categories_callback',	'kapee_post_category_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_blog_carousel_categories_render', 'kapee_post_category_render', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_blog_carousel_exclude_blogs_callback',	'kapee_post_id_search', 10, 1 );
	add_filter( 'vc_autocomplete_kapee_blog_carousel_exclude_blogs_render', 'kapee_post_id_render', 10, 1 );
endif;

if( class_exists( 'WPBakeryShortCodesContainer' ) ){
	VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Accordion' );

	class WPBakeryShortCode_kapee_tabs extends WPBakeryShortCode_VC_Tta_Accordion {	}
	class WPBakeryShortCode_kapee_tour extends WPBakeryShortCode_VC_Tta_Accordion {	}
	class WPBakeryShortCode_kapee_accordion extends WPBakeryShortCode_VC_Tta_Accordion { }
    class WPBakeryShortCode_kapee_menu_block extends WPBakeryShortCodesContainer { }
	class WPBakeryShortCode_kapee_testimonials extends WPBakeryShortCodesContainer {   }
	class WPBakeryShortCode_kapee_team extends WPBakeryShortCodesContainer {  }
	class WPBakeryShortCode_kapee_banner_carousel extends WPBakeryShortCodesContainer {  }
}
if( class_exists( 'WPBakeryShortCode' ) ){
    class WPBakeryShortCode_kapee_menu_item extends WPBakeryShortCode {    }
	class WPBakeryShortCode_kapee_testimonial extends WPBakeryShortCode {    }
	class WPBakeryShortCode_kapee_team_member extends WPBakeryShortCode {    }
	//class WPBakeryShortCode_kapee_team_member extends WPBakeryShortCode {    }
}

?>