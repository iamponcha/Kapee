<?php
/**
 * Element: Products Widget
 */
class vcProductsWidget extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_products_widget', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }
		
		vc_map( array(
			'name' 			=> esc_html__( 'Products Widget', 'kapee-extensions' ),
			'base' 			=> 'kapee_products_widget',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__( "Title", 'kapee-extensions' ),
					"param_name" 	=> "title",
					"admin_label"   => true,
					"description"   => esc_html__( "Enter title", 'kapee-extensions' ),					
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Layout', 'kapee-extensions' ),
					'param_name' 	=> 'layout',
					'std' 			=> 'list',
					'value'			=> array( 
						esc_html__('List','kapee-extensions') 	=> 'list',
						esc_html__('Slider','kapee-extensions') => 'slider'
					),
					"admin_label"   => true,
				),		
				array(
					'type'        	=> 'dropdown',
					'param_name'  	=> 'data_source',
					'heading'     	=> esc_html__( 'Data source', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'Recent Products', 'kapee-extensions' )       => 'recent_products',
						esc_html__( 'Featured Products', 'kapee-extensions' )     => 'featured_products',
						esc_html__( 'On Sale Products', 'kapee-extensions' )      => 'sale_products',
						esc_html__( 'Best-Selling Products', 'kapee-extensions' ) => 'best_selling_products',
						esc_html__( 'Top Rated Products', 'kapee-extensions' )    => 'top_rated_products',
						esc_html__( 'List of Products', 'kapee-extensions' )      => 'products',
					),
					'description' 	=> esc_html__( 'Select data source for your product grid', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'autocomplete',
					'heading'		=> esc_html__( 'Include Product Ids', 'kapee-extensions' ),
					'param_name'	=> 'product_ids',
					'settings' 		=> array(
						'multiple' 	=> true,
					),
					'dependency'	=> array(
						'element' => 'data_source',
						'value'   => 'products',
					),
					'description'	=> esc_html__( 'Add products by title.', 'kapee-extensions' ),					
				),				
				array(
					'type' 				=> 'autocomplete',
					'heading' 			=> esc_html__( 'Category', 'kapee-extensions' ),
					'param_name' 		=> 'categories',
					'settings' 		=> array(
						'multiple'	=> true,
					),
					"description" 		=> __( "Select specific categories.", 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'autocomplete',
					'heading'		=> esc_html__( 'Exclude Products', 'kapee-extensions' ),
					'param_name'	=> 'exclude',
					'settings' 		=> array(
						'multiple' 	=> true,
					),
					'description'	=> esc_html__('Exclude some products which you do not want to display. Add product by title.','kapee-extensions'),
					
				),
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Number Of Products', 'kapee-extensions' ),
					'param_name' 	=> 'limit',
					'std'			=> 5,
					
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order By', 'kapee-extensions' ),
					'param_name' 	=> 'orderby',
					"value" 		=> array(
						esc_html__( "Date", 'kapee-extensions' )   		=> "date",
						esc_html__( "Title", 'kapee-extensions' )   	=> "title",
						esc_html__( "Name(Slug)", 'kapee-extensions' ) 	=> "name",
						esc_html__( "Menu Order", 'kapee-extensions' ) 	=> "menu_order",
						esc_html__( "Random", 'kapee-extensions' )   	=> "rand",
						esc_html__( "ID", 'kapee-extensions' )   		=> "id",
					),
					'std' 			=> 'date',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Sort By', 'kapee-extensions' ),
					'param_name' 	=> 'sortby',
					'std' 			=> 'desc',
					'value'			=> array( 
						esc_html__('Descending','kapee-extensions') => 'desc',
						esc_html__('Ascending','kapee-extensions') => 'asc',
					),
				),
				array(
					'type' 				=> 'checkbox',
					'heading' 			=> esc_html__( 'Show Rating?', 'kapee-extensions' ),
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 1,
					'param_name' 		=> 'show_rating',
					"edit_field_class"	=> "vc_col-md-6",
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				//Carousel setting
				array(
					'type' 			=> 'kapee_number',
					'heading' 		=> esc_html__( 'Product Per Slide', 'kapee-extensions' ),
					'param_name' 	=> 'rows',
					'std' 			=> 5,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Autoplay', 'kapee-extensions' ),
					'param_name' 	=> 'slider_autoplay',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'      	=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),				
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Loop', 'kapee-extensions' ),
					'param_name' 	=> 'slider_loop',
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 0,
					'description' 	=> esc_html__( 'True for infinate loop.', 'kapee-extensions' ),
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Center Mode', 'kapee-extensions' ),
					'param_name' 	=> 'slider_center',
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 0,
					'description' 	=> esc_html__( 'Center item. Works well with an odd number of items.', 'kapee-extensions' ),
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Nav', 'kapee-extensions' ),
					'param_name' 	=> 'slider_nav',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 1,
					'description' 	=> esc_html__( 'True for display navigation icon.', 'kapee-extensions' ),
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),	
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Dots', 'kapee-extensions' ),
					'param_name' 	=> 'slider_dots',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'description' 	=> esc_html__( 'True for display dots.', 'kapee-extensions' ),
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'slider' ),
					),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				//Style
				array(
					'type' 			=> 'css_editor',
					'heading' 		=> esc_html__( 'CSS box', 'kapee-extensions' ),
					'param_name' 	=> 'css',
					'group' 		=> esc_html__( 'Design Options', 'kapee-extensions' )
				)
			)
		) );
	}
	
	public function _html( $atts, $content ) {
		$args = ( shortcode_atts( array(
			'title' 					=> '',
			'layout' 					=> 'list',
			'data_source' 				=> 'recent_products',
			'product_ids' 				=> '',
			'categories' 				=> '',
			'exclude' 					=> '',
			'limit' 					=> '5',
			'orderby' 					=> 'date',
			'sortby' 					=> 'desc',
			'show_rating' 				=> 1,
			'el_class' 					=> '',	
			'columns' 					=> 4,	
			'rows' 						=> 5,	
			'slider_autoplay' 			=> 0,
			'slider_loop' 				=> 0,
			'slider_center' 			=> 0,
			'slider_nav' 				=> 1,
			'slider_dots' 				=> 0,
			'rs_extra_large' 			=> 1,
			'rs_large'					=> 1,
			'rs_medium' 				=> 1,
			'rs_small' 					=> 1,
			'rs_extra_small' 			=> 1,
			"css"            			=> "",  
		), $atts ) );	 
		extract( $args );
		$args['id']			= kapee_uniqid('kapee-products-widget-');
		$class				= array( 'kapee-element', 'widget', 'kapee-products-widget', 'woocommerce' );
		$class[]			= $el_class;
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		$widget_css			= '';
		
		
		$query = kapee_get_products( $data_source, $args );
		
		$the_query = new WP_Query( $query );		
		$args['query'] 			= $the_query;
		$show_button  = false;
		$max_num_page = $the_query->max_num_pages;
		$query_paged  = $the_query->query_vars['paged'];
		if ( $query_paged >= 0 && ( $query_paged < $max_num_page ) ) {
			$show_button = true;
		} else {
			$show_button = false;
		}
		if ( $max_num_page <= 1 ) {
			$show_button = false;
		}
		if($layout == 'list'){
			kapee_set_loop_prop('products-columns',$columns);
			//wc_set_loop_prop('columns',$columns);
		}else{
			
			$owl_data	= array(
				'slider_loop'				=> $slider_loop ? true : false,
				'slider_autoplay' 			=> $slider_autoplay ? true : false,
				'slider_center' 			=> false,
				'slider_nav'				=> $slider_nav ? true : false,
				'slider_dots'				=> $slider_dots ? true : false,
				'slider_autoHeight'			=>  false,
				'rs_extra_large' 			=> 1,
				'rs_large' 					=> 1,
				'rs_medium' 				=> 1,
				'rs_small' 					=> 1,
				'rs_extra_small' 			=> 1,
			);
			$unique_id 		= $args['id'];
			$slider_data 	= shortcode_atts( kapee_slider_options() ,$owl_data);
			global $kapee_owlparam;
			$kapee_owlparam['owlCarouselArg'][$unique_id] = $slider_data;
			$widget_css = " kapee-carousel owl-carousel grid-col-1";
			
		}
		$args['class'] = implode(' ',array_filter($class));
		$args['args'] = wp_json_encode( $args );
		$args['widget_css'] = $widget_css;
		$args['template_args'] = array(
				'show_rating' => $show_rating,
			);
		ob_start();
			kapee_get_pl_templates('shortcodes/products-widget',$args );			
		return ob_get_clean();
	}	
}
new vcProductsWidget();