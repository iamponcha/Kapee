<?php
if (!class_exists('PLS_Woocommerce_Custom_Tabs')) {

	class PLS_Woocommerce_Custom_Tabs{
		function __construct() {
			
			add_action( 'woocommerce_product_tabs', array( $this, 'custom_woocommerce_product_tabs' ) );
		}
		
		function custom_woocommerce_product_tabs( $tabs ) {
			$custom_tabs = $this->get_custom_tabs();
			if( !empty( $custom_tabs ) ){
				foreach ( $custom_tabs as $key => $tab ) {
					$post_content = get_post( $tab['block_id'] ); // Fetch the post content
					if ( $post_content ) {
						$tabs[$key] = array(
							'title'    => $tab['title'], 
							'priority' => $tab['priority'], // Set dynamic priority
							'callback' => [$this,'product_tab_content'],
							'block_id'  => $tab['block_id'], // Store the Block ID
						);
					}
				}
			}
			return $tabs;
		}
		
		// Callback Function to Display Tab Content
		function product_tab_content( $key, $tab ) {
			if ( isset( $tab['block_id'] ) ) {
				echo do_shortcode('[kapee_block id="'.esc_attr( $tab['block_id'] ).'"]');
			}
		}

		function get_custom_tabs() {
		
			if( ! kapee_get_option( 'single-product-custom-tabs', 0 ) ) { 
				return;
			}
			
			$defualt_tabs = [ 
				'tab_title'	=> [
					'Shipping',
				],
				'tab_block'	=> [
					'',
				],
				'tab_priority'	=> [
					'40',
				],
			];
			
			$product_tabs = kapee_get_option( 'single-product-custom-tab-list', $defualt_tabs );
			
			if( empty( $product_tabs ) ){
				return;
			}
			
			$tab_title 		= $product_tabs['tab_title'];
			$tab_priority 	= $product_tabs['tab_priority'];
			$tab_block 		= $product_tabs['tab_block'];
			
			$tabs = array();
			foreach( $tab_title as $key => $value ){
				if( empty( trim( $value ) ) || empty( trim( $tab_block[$key] ) )){
					continue;
				}
				$data = array();
				$priority = !empty( trim( $tab_priority[$key] ) ) ? $tab_priority[$key] : 40 ;
				$tab_key = 'pls_custom_tab_'.$key;
				$data['title'] = $value;
				$data['block_id'] =  $tab_block[$key];
				$data['priority'] =  $priority;
				$tabs[$tab_key] = $data;
			}			
			return $tabs;
		}		
	}
	
	function pls_woocommerce_tab_class_init(){
		$obj_custom_tab = new PLS_Woocommerce_Custom_Tabs();
	}
	add_action( 'init', 'pls_woocommerce_tab_class_init',15);	
}