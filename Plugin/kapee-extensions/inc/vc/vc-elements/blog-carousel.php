<?php
/*
Element: Blog Carousel
*/
class vcBlogCarousel extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_blog_carousel', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }	
		$image_sizes 		= kapee_get_all_image_sizes(true);
		array_shift($image_sizes);
		$blog_post_orderby 	= kapee_post_order();
		vc_map( array(
			'name'			=> esc_html__( 'Blog Carousel', 'kapee-extensions' ),
			'base' 			=> 'kapee_blog_carousel',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Blog carousel', 'kapee-extensions' ),
			'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__( "Blog Title", 'kapee-extensions' ),
					"param_name" 	=> "title",
					"admin_label"   => true,
					"description"   => esc_html__( "Enter title", 'kapee-extensions' ),					
				),
				array(
					'type'			=> 'dropdown',
					'heading' 		=> esc_html__( 'Blog Style', 'kapee-extensions' ),
					"admin_label"   => true,
					'param_name' 	=> 'grid_style',
					'value' 		=> array( 						
						esc_html__( 'Blog Grid Center', 'kapee-extensions' ) 	=> 'blog-grid-center',
						esc_html__( 'Gradient Overlay', 'kapee-extensions' ) 	=> 'blog-grid-gradient-overlay',
					),
					'std' 			=> 'blog-center',
					'description' 	=> esc_html__( 'Select style.', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Blog View Mode', 'kapee-extensions' ),
					'param_name' 	=> 'blog_view_mode',
					'std' 			=> 'vertical',
					'value'			=> array( 
						esc_html__('Vertical','kapee-extensions') => 'vertical',
						esc_html__('Horizontal','kapee-extensions') 	=> 'horizontal',
					),
					'dependency'	=> array(
						'element' => 'grid_style',
						'value'   => 'blog-grid-center',
					),
					"admin_label"   => true,
				),				
				array(
					'type' 			=> 'autocomplete',
					'heading' 		=> esc_html__( 'Category', 'kapee-extensions' ),
					'param_name' 	=> 'categories',
					'settings' 		=> array(
						'multiple' 	=> true,
					),
				),
				array(
					'type' 			=> 'autocomplete',
					'heading'		=> esc_html__( 'Exclude Post Ids', 'kapee-extensions' ),
					'param_name'	=> 'exclude_blogs',
					'settings' 		=> array(
						'multiple' 	=> true,
					),
					'description'	=> esc_html__('Exclude some blogs post which you do not want to display. You can pass multiple ids by comma separated','kapee-extensions'),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Per Page', 'kapee-extensions' ),
					'param_name' 	=> 'limit',
					'std' 			=> 8,
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Order By', 'kapee-extensions' ),
					'param_name'	=> 'orderby',
					'value'			=> array_flip($blog_post_orderby),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Sort By', 'kapee-extensions' ),
					'param_name' 	=> 'sortby',
					'std' 			=> 'desc',
					'value'			=> array( 
						esc_html__('Descending','kapee-extensions')	=> 'desc',
						esc_html__('Ascending','kapee-extensions')	=> 'asc',
					),
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type'			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name'	=> 'el_class',
					'description'	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				//Carousel setting
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Autoplay', 'kapee-extensions' ),
					'param_name' 	=> 'slider_autoplay',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'group'      	=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),				
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Loop', 'kapee-extensions' ),
					'param_name' 	=> 'slider_loop',
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 0,
					'description' 	=> esc_html__( 'True for infinate loop.', 'kapee-extensions' ),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Center Mode', 'kapee-extensions' ),
					'param_name' 	=> 'slider_center',
					'value' 		=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 			=> 0,
					'description' 	=> esc_html__( 'Center item. Works well with an odd number of items.', 'kapee-extensions' ),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Nav', 'kapee-extensions' ),
					'param_name' 	=> 'slider_nav',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 1,
					'description' 	=> esc_html__( 'True for display navigation icon.', 'kapee-extensions' ),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),	
				array(
					'type' 			=> 'checkbox',
					'heading' 		=> esc_html__( 'Dots', 'kapee-extensions' ),
					'param_name' 	=> 'slider_dots',
					'value' 			=> array( esc_html__( 'Yes', 'kapee-extensions' ) => 1 ),
					'std' 				=> 0,
					'description' 	=> esc_html__( 'True for display dots.', 'kapee-extensions' ),
					'group'			=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
							
				array(
					"type"       	=> "dropdown",
					"heading"    	=> esc_html__("Extra large devices (large desktops, 1200px and up)", 'kapee-extensions' ),
					"param_name" 	=> "rs_extra_large",
					"value" 		=> array(
						"1"  	=> 1,
						"2" 	=> 2,
						"3" 	=> 3,
						"4" 	=> 4,
					),
					"std"        	=> 3,
					'group'      	=> esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					"type"          => "dropdown",
					"heading"       => esc_html__("Large devices (desktops, 992px and up)", 'kapee-extensions' ),
					"param_name"    => "rs_large",
					"value" 		=> array(
						"1"  	=> 1,
						"2" 	=> 2,
						"3" 	=> 3,
					),
					"std"           => 3,
					'group'         => esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					"type"          => "dropdown",
					"heading"       => esc_html__("Medium devices (tablets, 768px and up)", 'kapee-extensions' ),
					"param_name"    => "rs_medium",
					"value" 		=> array(
						"1"  	=> 1,
						"2" 	=> 2,
					),
					"std"           => 2,
					'group'         => esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					"type"          => "dropdown",
					"heading"       => esc_html__("Small devices (landscape phones, 576px and up)", 'kapee-extensions' ),
					"param_name"    => "rs_small",
					"value" 		=> array(
						"1"  	=> 1,
						"2" 	=> 2,
					),
					"std"           => 2,
					'group'         => esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				array(
					"type"          => "dropdown",
					"heading"       => esc_html__("Extra small devices (portrait phones, less than 576px)", 'kapee-extensions' ),
					"param_name"    => "rs_extra_small",
					"value" 		=> array(
						"1"  	=> 1,
					),
					"std"           => 1,
					'group'         => esc_html__( 'Carousel Settings', 'kapee-extensions' ),
				),
				//Blog setting
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Banner Image Size', 'kapee-extensions' ),
					'param_name'	=> 'image_size',
					'std'			=> 'medium',
					'value'			=> array_flip($image_sizes),
					'group'         => esc_html__( 'Blog Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Post Thumbnail', 'kapee-extensions' ),
					'param_name' 	=> 'blog_thumbnail',
					'std' 			=> 1,
					'value'			=> array( 
						esc_html__('Show','kapee-extensions') => 1,
						esc_html__('Hide','kapee-extensions') => 0,
					),
					'description' 	=> esc_html__( 'Show/hide blog post thumbnail.', 'kapee-extensions' ),
					'group'         => esc_html__( 'Blog Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Post Fancy Date', 'kapee-extensions' ),
					'param_name' 	=> 'post_fancy_date',
					'std' 			=> 0,
					'value'			=> array( 
						esc_html__('Show','kapee-extensions') => 1,
						esc_html__('Hide','kapee-extensions') => 0,
					),
					'description' 	=> esc_html__( 'Show/hide blog fancy date.', 'kapee-extensions' ),
					'group'         => esc_html__( 'Blog Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Fancy Date Style', 'kapee-extensions' ),
					'param_name' 	=> 'fancy_date_style',
					'std' 			=> 'fancy-square-date',
					'value'			=> array( 
						esc_html__('Fancy Square Date','kapee-extensions') 		=> 'fancy-square-date',
						esc_html__('Fancy Box 2 Date','kapee-extensions') 		=> 'fancy-box2-date',
						esc_html__('Fancy Box Date','kapee-extensions') 		=> 'fancy-box-date',
					),
					'dependency'    => array(
						'element' => 'post_fancy_date',
						'value'   => '1',
					),
					'group'			=> esc_html__( 'Blog Settings', 'kapee-extensions' ),					
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Post Meta', 'kapee-extensions' ),
					'param_name' 	=> 'post_meta',
					'std' 			=> '1',
					'value'			=> array( 
						esc_html__('Show','kapee-extensions') => '1',
						esc_html__('Hide','kapee-extensions') => '0',
					),
					'description' 	=> esc_html__( 'Show/hide blog fancy date.', 'kapee-extensions' ),
					'group'         => esc_html__( 'Blog Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Post Title', 'kapee-extensions' ),
					'param_name' 	=> 'blog_title',
					'std' 			=> 1,
					'value'			=> array( 
						esc_html__('Show','kapee-extensions') => 1,
						esc_html__('Hide','kapee-extensions') => 0,
					),
					'description' 	=> esc_html__( 'Show/hide blog post title.', 'kapee-extensions' ),
					'group'         => esc_html__( 'Blog Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Show Post content', 'kapee-extensions' ),
					'param_name' 	=> 'show_blog_content',
					'std' 			=> 1,
					'value'			=> array( 
						esc_html__('Show','kapee-extensions') => 1,
						esc_html__('Hide','kapee-extensions') => 0,
					),
					'description' 	=> esc_html__( 'Show/hide blog post content.', 'kapee-extensions' ),
					'group'         => esc_html__( 'Blog Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Post Content', 'kapee-extensions' ),
					'param_name' 	=> 'blog_content',
					'std' 			=> 'excerpt-content',
					'value'			=> array( 
						esc_html__('Expert','kapee-extensions') 	=> 'excerpt-content',
						esc_html__('Full','kapee-extensions') 		=> 'full-content',
					),
					'dependency'    => array(
						'element' => 'show_blog_content',
						'value'   => '1',
					),
					'group'			=> esc_html__( 'Blog Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Expert Length', 'kapee-extensions' ),
					'param_name' 	=> 'blog_excerpt_length',
					'std' 			=> 30,
					'description' 	=> esc_html__( 'Show/hide blog read more button.', 'kapee-extensions' ),
					'dependency'	=> array(
						'element' => 'blog_content',
						'value'   => 'excerpt-content',
					),
					'dependency'    => array(
						'element' => 'show_blog_content',
						'value'   => '1',
					),
					'group'         => esc_html__( 'Blog Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Read More Button', 'kapee-extensions' ),
					'description' 	=> esc_html__( 'Show/hide blog read more button.', 'kapee-extensions' ),
					'param_name' 	=> 'read_more_btn',
					'std' 			=> 1,
					'value'			=> array( 
						esc_html__('Show','kapee-extensions') => 1,
						esc_html__('Hide','kapee-extensions') => 0,
					),
					'dependency'    => array(
						'element' => 'show_blog_content',
						'value'   => '1',
					),
					'group'         => esc_html__( 'Blog Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Read More Style', 'kapee-extensions' ),
					'param_name' 	=> 'read_more_btn_style',
					'std' 			=> 'read-more-link',
					'value'			=> array( 
						esc_html__('Link','kapee-extensions') 			=> 'read-more-link',
						esc_html__('Button','kapee-extensions') 		=> 'read-more-button',
						esc_html__('Button Fill','kapee-extensions') 	=> 'read-more-button-fill',
					),
					'dependency'    => array(
						'element' => 'read_more_btn',
						'value'   => '1',
					),
					'group'			=> esc_html__( 'Blog Settings', 'kapee-extensions' ),					
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
	
	public function _html( $atts) {
		$args = ( shortcode_atts( array(
			'title' 				=> '',
			'blog_view_mode'		=> 'vertical',
			'grid_style' 			=> 'blog-grid-center',
			'categories' 			=> '',				
			'exclude_blogs' 		=> '',
			'limit' 				=> 8,				
			'orderby' 				=> 'date',				
			'sortby' 				=> 'desc',
			'css_animation' 		=> 'none',
			'el_class' 				=> '',
			'slider_autoplay' 		=> 0,
			'slider_loop' 			=> 0,
			'slider_center' 		=> 0,
			'slider_nav' 			=> 1,
			'slider_dots' 			=> 0,
			'rs_extra_large' 		=> 3,
			'rs_large'				=> 3,
			'rs_medium' 			=> 2,
			'rs_small' 				=> 2,
			'rs_extra_small' 		=> 1,
			'image_size' 			=> 'medium',
			'blog_thumbnail' 		=> 'true',
			'post_fancy_date'		=> 0,
			'fancy_date_style' 		=> 'fancy-square-date',
			'post_meta' 			=> 1,
			'blog_title' 			=> 1,
			'show_blog_content' 	=> 1,
			'blog_content' 			=> 'excerpt-content',				
			'blog_excerpt_length' 	=> 30,				
			'read_more_btn' 		=> 1,				
			'read_more_btn_style' 	=> 'read-more-link',			
			'css' 					=> '',				
		), $atts ) );	 
		extract( $args );
		
		$args['id'] 		= kapee_uniqid('kapee-blog-carousel-');		
		$class				= array ( 'kapee-element', 'kapee-blog-carousel', $el_class );
		$class[]			= ( 'horizontal' == $blog_view_mode ) ? 'kapee-blog-'.$blog_view_mode : '';
		$class[]			= kapee_get_css_animation($css_animation);
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		$args['class'] 		= implode(' ',array_filter( $class ) );
		
		$owl_data	= array(
			'slider_loop'				=> $slider_loop ? true : false,
			'slider_autoplay' 			=> $slider_autoplay ? true : false,
			'slider_center' 			=> $slider_center ? true : false,
			'slider_nav'				=> $slider_nav ? true : false,
			'slider_dots'				=> $slider_dots ? true : false,			
			'slider_margin' 			=> 30,
			'rs_extra_large' 			=> $rs_extra_large,
			'rs_large' 					=> $rs_large,
			'rs_medium' 				=> $rs_medium,
			'rs_small' 					=> $rs_small,
			'rs_extra_small' 			=> $rs_extra_small,
		);
		$slider_data 		= shortcode_atts( kapee_slider_options(), $owl_data );
		global $kapee_owlparam;
		$kapee_owlparam['owlCarouselArg'][$args['id']] = $slider_data;
		
		
		$query_args = array(
			'post_type'          => 'post',
			'post_status'        => array('publish'),
			'posts_per_page'     => $limit,
			'ignore_sticky_posts'=> true,
		);
		
		$categories = trim($categories);
		if( !empty($categories) ){
			$categories_array = explode(',', $categories);
			if( is_array($categories_array) && !empty($categories_array) ){
				$query_args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $categories_array
					)
				);
			}	
		}
		
		$query_args['orderby'] = 'date';
		
		// Posts Order
		if( ! empty( $orderby ) ){

			// Random Posts
			if( $orderby == 'rand' ){
				$query_args['orderby'] = 'rand';
			}

			// Most Viewd posts
			elseif( $orderby == 'views'){
				$prefix = KAPEE_EXTENSIONS_META_PREFIX;
				$query_args['orderby']  = 'meta_value_num';
				$query_args['meta_key'] = apply_filters( 'kapee_views_meta_field', $prefix.'views_count' );
			}

			// Popular Posts by comments
			elseif( $orderby == 'popular' ){
				$query_args['orderby'] = 'comment_count';
			}

			// Recent modified Posts
			elseif( $orderby == 'modified' ){
				$query_args['orderby'] = 'modified';
			}
		}
		
		$query_args['order'] = $sortby;
		
		// Exclude Posts
		if( ! empty( $exclude_blogs )){
			$exclude_blogs_array = explode(',', $exclude_blogs);
			if( is_array($exclude_blogs_array) && !empty($exclude_blogs_array) ){
				$query_args['post__not_in'] = $exclude_blogs_array;		
			}
		}
		
		$the_query = new WP_Query( $query_args );
		$args['query'] 			= $the_query; 
		
		kapee_set_loop_prop( 'name', 'posts-slider-shortcode' );
		kapee_set_loop_prop( 'blog-post-style', 'blog-grid');
		kapee_set_loop_prop( 'post-fancy-date', $post_fancy_date);
		kapee_set_loop_prop( 'fancy-date-style', $fancy_date_style);
		kapee_set_loop_prop( 'post-meta', $post_meta);
		kapee_set_loop_prop( 'specific-post-meta', array( 'post-author', 'post-date' ) );
		kapee_set_loop_prop( 'blog-grid-post-style', $grid_style );
		kapee_set_loop_prop( 'blog-grid-layout', 'simple-grid' );
		kapee_set_loop_prop( 'blog-grid-columns', $rs_extra_large );
		kapee_set_loop_prop('rs_extra_large',$rs_extra_large);
		kapee_set_loop_prop('rs_large',$rs_large);
		kapee_set_loop_prop('rs_medium',$rs_medium);
		kapee_set_loop_prop('rs_small',$rs_small);
		kapee_set_loop_prop('rs_extra_small',$rs_extra_small);
		kapee_set_loop_prop( 'show-blog-post-content', $show_blog_content );
		kapee_set_loop_prop( 'blog-post-content', $blog_content );
		kapee_set_loop_prop( 'blog-excerpt-length', $blog_excerpt_length );
		if(!$show_blog_content){
			kapee_set_loop_prop( 'read-more-button', 0);
		}else{
			kapee_set_loop_prop( 'read-more-button', $read_more_btn);
		}
		kapee_set_loop_prop( 'read-more-button-style', $read_more_btn_style );
		kapee_set_loop_prop( 'blog-post-thumbnail', $blog_thumbnail);
		kapee_set_loop_prop( 'blog-custom-thumbnail-size', $image_size );
		kapee_set_loop_prop( 'blog-post-title', $blog_title );
		
		ob_start();
			kapee_get_pl_templates('shortcodes/blog-carousel',$args );			
		return ob_get_clean();
	}	
}
new vcBlogCarousel();