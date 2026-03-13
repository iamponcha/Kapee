<?php
/** 
Registers Kapee Post types
*/

class Kapee_PostTypes{
	
	function __construct() {		
		add_action('init', array( $this, 'kapee_portfolio_post_type' ) );
		add_action('init', array( $this, 'kapee_blocks_post_type' ) );
		add_action('init', array( $this, 'kapee_size_chart_post_type' ) );
		add_filter( 'manage_'.KAPEE_EXTENSIONS_BLOCK_POST_TYPE.'_posts_columns', array($this, 'kapee_block_posts_columns') );
		add_action('manage_'.KAPEE_EXTENSIONS_BLOCK_POST_TYPE.'_posts_custom_column', array($this, 'kapee_block_post_columns_data'), 10, 2);
	}
	
	/**
	*	Register portfolio content type
	*/
    function kapee_portfolio_post_type() {
		
		$kapee_options = get_option('kapee_options',array());
		
		if( isset($kapee_options['enable-portfolio']) && $kapee_options['enable-portfolio'] != 1 ){
			return;
		}
		
		$singular_name = !empty($kapee_options['portfolio-singular-name'])? $kapee_options['portfolio-singular-name'] : esc_html__('Portfolio', 'kapee-extensions') ;
		$name = !empty( $kapee_options['portfolio-name'] ) ? $kapee_options['portfolio-name'] :  esc_html__('Portfolios', 'kapee-extensions');
		$slug = !empty($kapee_options['portfolio-slug']) ? $kapee_options['portfolio-slug'] : 'portfolio';
		$cat_name = $singular_name.esc_html__(' Category','kapee-extensions');
		$cats_name = $singular_name.esc_html__(' Categories','kapee-extensions');
		$cat_slug_name = !empty($kapee_options['portfolio-cat-slug']) ? $kapee_options['portfolio-cat-slug'] : 'portfolio_cat';
		$skill_name = $singular_name.esc_html__(' Skill','kapee-extensions');
		$skills_name = $singular_name.esc_html__(' Skills','kapee-extensions');
		$skill_slug_name = !empty($kapee_options['portfolio-skill-slug']) ? $kapee_options['portfolio-skill-slug'] : 'portfolio_skill' ;
		$has_archive = true;
		
        register_post_type(
            KAPEE_EXTENSIONS_PORTFOLIO_POST_TYPE,apply_filters('kapee_extensions_register_post_type_portfolio',
            array(
                'labels' => $this->kapee_getLabels($singular_name,$name),
                'exclude_from_search' => false,
                'public' => true,
                'rewrite' => array('slug' => apply_filters('kapee_extensions_portfolio_slug',$slug)),
				'has_archive' => $has_archive,
				'supports' => array('title', 'editor', 'thumbnail', 'comments', 'page-attributes'),
                'can_export' => true,
				'show_in_nav_menus' => true
            ))
        );
		
		register_taxonomy(
            KAPEE_EXTENSIONS_PORTFOLIO_CAT,
            KAPEE_EXTENSIONS_PORTFOLIO_POST_TYPE,
            array(
                'hierarchical' => true,
                'show_in_nav_menus' => true,
                'labels' => $this->kapee_getTaxonomyLabels($cat_name, $cats_name),
				'query_var' => true,
                'rewrite' => array('slug' => apply_filters('kapee_extensions_portfolio_cat_slug',$cat_slug_name))
            )
        );
		
		register_taxonomy(
            KAPEE_EXTENSIONS_PORTFOLIO_SKILL,
            KAPEE_EXTENSIONS_PORTFOLIO_POST_TYPE,
            array(
                'hierarchical' => true,
                'show_in_nav_menus' => true,
                'labels' => $this->kapee_getTaxonomyLabels($skill_name, $skills_name),
                'query_var' => true,
                'rewrite' => array('slug' => apply_filters('kapee_extensions_portfolio_skill_slug',$skill_slug_name))
            )
        );
		
    }
	
	/**
	*	Register Custom Block content type
	*/
	function kapee_blocks_post_type() {
		
		$singular_name = __('Block', 'kapee-extensions') ;
		$name = __('Blocks', 'kapee-extensions');
		$slug = 'blocks';
		$has_archive = true;
		$cat_name = 'Blocks Category';
		$cats_name = 'Blocks Categories';
		$cat_slug_name = 'block_cat';
		
        register_post_type(
            KAPEE_EXTENSIONS_BLOCK_POST_TYPE,apply_filters('kapee_extensions_register_post_type_blocks',
            array(
                'labels' 				=> $this->kapee_getLabels($singular_name,$name),
                'exclude_from_search' 	=> true,
                'public' 				=> true,
				'show_ui' 				=> true,
                'menu_icon' 			=> 'dashicons-format-aside',
				'supports' 				=> array('title', 'editor'),
				'show_in_nav_menus' 	=> false,
            ))
        );
		
		register_taxonomy(
            KAPEE_EXTENSIONS_BLOCK_POST_CAT,
            KAPEE_EXTENSIONS_BLOCK_POST_TYPE,
            array(
                'hierarchical' => true,
                'show_in_nav_menus' => false,
                'labels' => $this->kapee_getTaxonomyLabels($cat_name, $cats_name),
				'query_var' => false,
            )
        );
	}
	
	/**
	*	Add shortcode column in block post type
	*/
	function kapee_block_posts_columns( $columns ) {
	    $new_column['block_shortcode'] 	= esc_html__('Shortcode', 'kapee-extensions');
	    $columns = kapee_add_array( $columns, $new_column, 1, true );
	    return $columns;
	}
	
	/**
	*	Add column data to shortcode column
	*/
	function kapee_block_post_columns_data( $column, $post_id ) {		
	    switch ($column) {
			case 'block_shortcode':
				echo '<div class="block-shortcode-preview">[kapee_block id="'.$post_id.'"]</div>';
	    		break;
		}
	}
	
	/**
	*	Register Size Chart content type
	*/
	function kapee_size_chart_post_type() {
		
		$singular_name = __('Size Chart', 'kapee-extensions') ;
		$name = __('Size Charts', 'kapee-extensions');
		 register_post_type(
            KAPEE_EXTENSIONS_SIZE_CHART_POST_TYPE,apply_filters('kapee_extensions_register_post_type_size_chart',
            array(
                'labels' 				=> $this->kapee_getLabels($singular_name,$name),
                'public' 				=> false,
				'show_ui' 				=> true,
				'show_in_menu' 			=> true,
				'query_var' 			=> true,
				'rewrite' 				=> false,
				'capability_type' 		=> 'post',
				'has_archive' 			=> false,
				'hierarchical' 			=> false,
				'menu_position' 		=> null,
				'show_in_nav_menus' 	=> false,
				'exclude_from_search' 	=> true,
                'menu_icon' 			=> 'dashicons-format-aside',
				'supports' 				=> array('title', 'editor'),
				
            ))
        );
	}
	
	/**
	*	Get content type labels
	*/
    function kapee_getLabels($singular_name, $name, $title = FALSE) {
        if( !$title )
            $title = $name;
		
        return array(
            "name" => $title,
            "singular_name" => $singular_name,
            "add_new" => esc_html__("Add New", 'kapee-extensions'),
            "add_new_item" => sprintf( esc_html__("Add New %s", 'kapee-extensions'), $singular_name),
            "edit_item" => sprintf( esc_html__("Edit %s", 'kapee-extensions'), $singular_name),
            "new_item" => sprintf( esc_html__("New %s", 'kapee-extensions'), $singular_name),
            "view_item" => sprintf( esc_html__("View %s", 'kapee-extensions'), $singular_name),
            "search_items" => sprintf( esc_html__("Search %s", 'kapee-extensions'), $name),
            "not_found" => sprintf( esc_html__("No %s found", 'kapee-extensions'), $name),
            "not_found_in_trash" => sprintf( esc_html__("No %s found in Trash", 'kapee-extensions'), $name),
            "parent_item_colon" => "",
			'menu_name'            	=> $name,
			'featured_image'		=> sprintf( esc_html__('%s Image', 'kapee-extensions'),$singular_name),
			'set_featured_image'	=> sprintf( esc_html__('Set %s Image', 'kapee-extensions'),$singular_name),
			'remove_featured_image'	=> sprintf( esc_html__('Remove %s image', 'kapee-extensions'),$singular_name),
			'use_featured_image'	=> sprintf( esc_html__('Use as %s image', 'kapee-extensions'),$singular_name),
        );
    }

    // Get content type taxonomy labels
    function kapee_getTaxonomyLabels($singular_name, $name) {
        return array(
            "name" => $name,
            "singular_name" => $singular_name,
            "search_items" => sprintf( esc_html__("Search %s", 'kapee-extensions'), $name),
            "all_items" => sprintf( esc_html__("All %s", 'kapee-extensions'), $name),
            "parent_item" => sprintf( esc_html__("Parent %s", 'kapee-extensions'), $singular_name),
            "parent_item_colon" => sprintf( esc_html__("Parent %s:", 'kapee-extensions'), $singular_name),
            "edit_item" => sprintf( esc_html__("Edit %s", 'kapee-extensions'), $singular_name),
            "update_item" => sprintf( esc_html__("Update %s", 'kapee-extensions'), $singular_name),
            "add_new_item" => sprintf( esc_html__("Add New %s", 'kapee-extensions'), $singular_name),
            "new_item_name" => sprintf( esc_html__("New %s Name", 'kapee-extensions'), $singular_name),
            "menu_name" => $name,
        );
    }
	
}
$kapee_posttype = new Kapee_PostTypes();
?>