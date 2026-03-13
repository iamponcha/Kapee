<?php
/*
Element: Blog
*/
class vcBlog extends WPBakeryShortCode {

    function __construct() {
        $this->_mapping();
        add_shortcode( 'kapee_blog', array( $this, '_html' ) );
	}
	public function _mapping() {
		if ( !defined( 'WPB_VC_VERSION' ) ) { return; }	
		$image_sizes 		= kapee_get_all_image_sizes(true);
		array_shift($image_sizes);
		$blog_post_orderby 	= kapee_post_order();
		vc_map( array(
			'name'			=> esc_html__( 'Blog', 'kapee-extensions' ),
			'base' 			=> 'kapee_blog',
			'category' 		=> esc_html__( 'Kapee', 'kapee-extensions' ),
			'description' 	=> esc_html__( 'Site Blog', 'kapee-extensions' ),
        	'icon' 			=> KAPEE_URI.'/inc/admin/assets/images/vc-icon.png',
			'params' 		=> array(
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Style', 'kapee-extensions' ),
					'admin_label'	=> true,
					'param_name' 	=> 'blog_style',
					'value' 		=> array( 
						esc_html__( 'Blog Center', 'kapee-extensions' ) 		=> 'blog-center',
						esc_html__( 'Small Image', 'kapee-extensions' ) 		=> 'blog-small-image',
						esc_html__( 'Blog Chess', 'kapee-extensions' ) 			=> 'blog-chess',
						esc_html__( 'Blog Grid', 'kapee-extensions' ) 			=> 'blog-grid',
						//esc_html__( 'Blog Timeline', 'kapee-extensions' ) 	=> 'blog-timeline',
					),
					'std'			=> 'blog-center',
					'description' 	=> esc_html__( 'Select style.', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'autocomplete',
					'heading' 		=> esc_html__( 'Specific Categories', 'kapee-extensions' ),
					'admin_label'	=> true,
					'param_name' 	=> 'categories',
					'settings' 		=> array(
						'multiple' 	=> true,
					),
				),
				array(
					'type' 			=> 'autocomplete',
					'heading'		=> esc_html__( 'Exclude Post', 'kapee-extensions' ),
					'param_name'	=> 'exclude',
					'settings' 		=> array(
						'multiple'	=> true,
					),
					'description'	=> esc_html__('Exclude some blogs post which you do not want to display.','kapee-extensions'),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Per Page', 'kapee-extensions' ),
					'param_name' 	=> 'limit',
					'std' 			=> '10',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order By', 'kapee-extensions' ),
					'param_name' 	=> 'orderby',
					'value'			=> array_flip($blog_post_orderby),
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
					'type'        	=> 'dropdown',
					'param_name'  	=> 'pagination',
					'admin_label' 	=> true,
					'heading'     	=> esc_html__( 'Pagination', 'kapee-extensions' ),
					'value'       	=> array(
						esc_html__( 'None', 'kapee-extensions' )       => 'none',
						esc_html__( 'Default', 'kapee-extensions' )       => 'default',
						esc_html__( 'Infinity Scroll', 'kapee-extensions' )  => 'infinity-scroll',
						esc_html__( 'Load More', 'kapee-extensions' )  => 'load-more-button',
					),
					'std' 			=> 'none',
					'description' 	=> esc_html__( 'Select pagination style.', 'kapee-extensions' ),
					'dependency' 	=> array(
						'element' 	=> 'layout',
						'value' 	=> array( 'grid' ),
					),
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Extra class name', 'kapee-extensions' ),
					'param_name' 	=> 'el_class',
					'description' 	=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kapee-extensions' )
				),
				//Grid setting
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Grid Layout', 'kapee-extensions' ),
					'param_name' 	=> 'grid_layout',
					'std' 			=> 'simple-grid',
					'value'			=> array( 
						esc_html__('Simple','kapee-extensions') 	=> 'simple-grid',
						esc_html__('Masonry','kapee-extensions') 	=> 'masonry-grid'
					),
					'group'			=> esc_html__( 'Grid Settings', 'kapee-extensions' ),
					'dependency'    => array(
						'element' => 'blog_style',
						'value'   => 'blog-grid',
					)
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Grid Style', 'kapee-extensions' ),
					'admin_label'	=> true,
					'param_name' 	=> 'grid_style',
					'value' 		=> array( 
						esc_html__( 'Blog Grid Center', 'kapee-extensions' ) 		=> 'blog-grid-center',
						esc_html__( 'Gradient Overlay', 'kapee-extensions' ) 		=> 'blog-grid-gradient-overlay',
					),
					'std' 			=> 'blog-grid-center',
					'description' 	=> esc_html__( 'Select style.', 'kapee-extensions' ),
					'dependency'    => array(
						'element' => 'blog_style',
						'value'   => 'blog-grid',
					),
					'group'			=> esc_html__( 'Grid Settings', 'kapee-extensions' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Column', 'kapee-extensions' ),
					'param_name' 	=> 'grid_column',
					'std' 			=> '2',
					'value'			=> array( 
						esc_html__('2 Column','kapee-extensions') => 2,
						esc_html__('3 Column','kapee-extensions') => 3,
					),
					'group'			=> esc_html__( 'Grid Settings', 'kapee-extensions' ),
					'dependency'    => array(
						'element' => 'blog_style',
						'value'   => 'blog-grid',
					)
				),
				//Blog setting
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Banner Image Size', 'kapee-extensions' ),
					'param_name'	=> 'image_size',
					'std'			=> 'full',
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
						esc_html__( 'Fancy Square Date', 'kapee-extensions' ) 	=> 'fancy-square-date',
						esc_html__( 'Fancy Box 2 Date', 'kapee-extensions' ) 	=> 'fancy-box2-date',
						esc_html__( 'Fancy Box Date', 'kapee-extensions' ) 		=> 'fancy-box-date',
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
					'std' 			=> 1,
					'value'			=> array( 
						esc_html__('Show','kapee-extensions') => 1,
						esc_html__('Hide','kapee-extensions') => 0,
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
			'blog_style' 			=> 'blog-center',
			'categories' 			=> '',				
			'exclude' 				=> '',
			'limit' 				=> '10',				
			'orderby' 				=> 'date',				
			'sortby' 				=> 'desc',			
			'pagination' 			=> 'none',
			'css_animation' 		=> 'none',	
			'el_class' 				=> '',
			'grid_layout' 			=> 'simple-grid',
			'grid_style' 			=> 'blog-grid-center',
			'grid_column' 			=> 2,
			'image_size' 			=> 'full',
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
			'css'					=> '',
		), $atts ) );	 
		extract( $args );
		$default_atts 		= $args;
		$class				= array();
		$class[]			= 'kapee-element';
		$class[]			= 'kapee-blog';
		$class[]			= $el_class;
		$class[]			= kapee_get_css_animation($css_animation);
		$css_class 			= vc_shortcode_custom_css_class( $css, ' ' );
		$class[]			= $css_class;
		$args['class'] 		= implode(' ',array_filter($class));
		$args['id']			= kapee_uniqid( 'kapee-blog-' );
		
		// Pagination parameter
		if(is_home() || is_front_page()) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = get_query_var( 'paged' );
		}
		$args['paged'] = $paged;
		
		$query_args  	= kapee_get_posts($args);
		$the_query 		= new WP_Query( $query_args );
		$args['query'] 	= $the_query;		
			
		$total   = $the_query->max_num_pages;
		$current = $paged;
		$base    = esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) );
		$format  = '?page=%#%';
		$show_pagination  = true;
		if ( $total <= 1 || $pagination == 'none' ) {
			$show_pagination  = false;
		}
		
		$args['show_pagination'] 	= $show_pagination;
		$args['total'] 				= $total;
		$args['base'] 				= $base;
		$args['current'] 			= $current;
		$args['format'] 			= $format;
		$args['atts'] 				= wp_json_encode( $default_atts );	
		
		kapee_set_loop_prop( 'name', 'posts-loop-shortcode' );
		kapee_set_loop_prop( 'blog-post-style', $blog_style );
		kapee_set_loop_prop( 'post-fancy-date', $post_fancy_date );
		kapee_set_loop_prop( 'fancy-date-style', $fancy_date_style );
		kapee_set_loop_prop( 'post-meta', $post_meta);		
		if( 'blog-grid' == $blog_style ){
			kapee_set_loop_prop( 'blog-grid-post-style', $grid_style );
			kapee_set_loop_prop( 'blog-grid-layout', $grid_layout );
			kapee_set_loop_prop( 'blog-grid-columns', $grid_column );
		}		
		kapee_set_loop_prop( 'show-blog-post-content', $show_blog_content );
		kapee_set_loop_prop( 'blog-post-content', $blog_content );
		kapee_set_loop_prop( 'blog-excerpt-length', $blog_excerpt_length );
		if(!$show_blog_content){
			kapee_set_loop_prop( 'read-more-button', 0);
		}else{
			kapee_set_loop_prop( 'read-more-button', $read_more_btn);
		}
		kapee_set_loop_prop( 'read-more-button-style', $read_more_btn_style );
		kapee_set_loop_prop( 'blog-custom-thumbnail-size', $image_size );
		kapee_set_loop_prop( 'blog-post-thumbnail', $blog_thumbnail );
		kapee_set_loop_prop( 'blog-post-title', $blog_title );
		
		ob_start();
			kapee_get_pl_templates( 'shortcodes/blog', $args );			
		return ob_get_clean();
	}	
}
new vcBlog();