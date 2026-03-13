<?php
/**
 *	Kapee Widget: Products
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Products extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-products woocommerce';
        $this->widget_description 	= __("Display products.", 'kapee-extensions');
        $this->widget_id 			= 'kapee-products';
        $this->widget_name 			= __('KP: Products', 'kapee-extensions');
		$tab_contents_list = array(
				'recent'		=> __( 'Recent Products', 'kapee-extensions' ),
				'featured'		=> __( 'Feature Products', 'kapee-extensions' ),
				'on-sale'		=> __( 'On Sale Products', 'kapee-extensions' ),				
				'top-selling'	=> __( 'Top Selling Products', 'kapee-extensions' ),				
				'top-rated'		=> __( 'Top Rated Products', 'kapee-extensions' ),				
			);
		
		$this->settings = array(
            
			'title' => array(
                'type' 	=> 'text',
                'label' => __('Title:', 'kapee-extensions'),
                'std' 	=> __('Products','kapee-extensions'),
            ),
			'show' => array(
                'type' 		=> 'select',
                'label' 	=> __('Show:', 'kapee-extensions'),
                'options' 	=> $tab_contents_list,
                'std' 		=> 'recent',
            ),
			
            'number' => array(
                'type' 	=> 'number',
                'step' 	=> 1,
                'min' 	=> 1,
                'max' 	=> '',
                'std' 	=> 10,
                'label' => __('Number of products to show:', 'kapee-extensions'),
            ),
            'hide_free' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Hide free products?', 'kapee-extensions' )
            ),
            'show_hidden' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Show hidden products?', 'kapee-extensions' )
            ),
			'show_rating' => array(
                'type'  => 'checkbox',
                'std'   => true,
                'label' => __( 'Show rating?', 'kapee-extensions' )
            ),
			'slider' => array(
                'type' 	=> 'checkbox',
                'label' => __( 'Enable slider?', 'kapee-extensions' ),
                'std' 	=> true,
            ),
			'number_slide' => array(
                'type' 	=> 'text',
                'label' => __('Per slide show products:', 'kapee-extensions'),
                'std' 	=> 5,
            ),
			'autoplay' => array(
                'type' 	=> 'checkbox',
                'label' => __('Enable Auto play slider?', 'kapee-extensions'),
                'std' 	=> false,
            ),
			'loop' => array(
                'type' 	=> 'checkbox',
                'label' => esc_html__('Continue slider loop?', 'kapee-extensions'),
                'std' 	=> true,
            ),
			'navigation' => array(
                'type' 	=> 'checkbox',
                'label' => __('Show slider navigation?', 'kapee-extensions'),
                'std' 	=> true,
            ),
			'dots' => array(
                'type' 	=> 'checkbox',
                'label' => __('Show slider dots?', 'kapee-extensions'),
                'std' 	=> false,
            ),
		);
		parent::__construct();
	}
	
	/**
     * Query the products and return them.
     * @param  array $args
     * @param  array $instance
     * @return WP_Query
     */
    public function get_products($args, $instance)
    {
        $number  = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
        $orderby = 'date';
        $order   = 'desc';
		$product_visibility_term_ids = wc_get_product_visibility_term_ids();
        $query_args = array(
            'posts_per_page' => $number,
            'post_status'    => 'publish',
            'post_type'      => 'product',
            'no_found_rows'  => 1,
            'order'          => $order,
            'meta_query'     => array()
        );

        if ( empty( $instance['show_hidden'] ) ) {
            $query_args['meta_query'][] = WC()->query->visibility_meta_query();
            $query_args['post_parent']  = 0;
        }

        if ( ! empty( $instance['hide_free'] ) ) {
            $query_args['meta_query'][] = array(
                'key'     => '_price',
                'value'   => 0,
                'compare' => '>',
                'type'    => 'DECIMAL',
            );
        }

        $query_args['meta_query'][] = WC()->query->stock_status_meta_query();
        $query_args['meta_query']   = array_filter( $query_args['meta_query'] );

        switch ( $instance['show'] ) {
            case 'featured' :
                $query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['featured'],
				);
                break;
            case 'on-sale' :
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$query_args['post__in'] = $product_ids_on_sale;
                break;
			case 'top-selling' :
                $query_args['orderby'] 	= 'meta_value_num';
				$query_args['order'] 	= $order;
				$query_args['meta_key'] = 'total_sales';
                break;
			case 'top-rated' :
				$query_args['orderby'] 	= 'meta_value_num';
				$query_args['order'] 	= $order;
				$query_args['meta_key'] = '_wc_average_rating';
                break;
        }
		
        return new WP_Query( apply_filters( 'woocommerce_products_widget_query_args', $query_args ) );
    }

    /**
     * Output widget.
     *
     * @see WP_Widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance){

        ob_start();
		$number_slide 	= (!empty($instance['number_slide'])) ? (int) $instance['number_slide'] : 5;
		$slider 		= (!empty($instance['slider'])) ? (bool) $instance['slider'] : false;
		$autoplay 		= (!empty($instance['autoplay'])) ? (bool) $instance['autoplay'] : false;
		$loop 			= (!empty($instance['loop'])) ? (bool) $instance['loop'] : false;
		$navigation 	= (!empty($instance['navigation'])) ? (bool) $instance['navigation'] : false;
		$dots 			= (!empty($instance['dots'])) ? (bool) $instance['dots'] : false;
		$show_rating 	= (!empty($instance['show_rating'])) ? (bool) $instance['show_rating'] : false;
		$id 			= $args['widget_id'];
		$class			= '';
		if($slider){
			$class	.=	" kapee-carousel owl-carousel";		
			$owl_data		= array(
				'slider_loop'		=> $loop,
				'slider_autoplay' 	=> $autoplay,
				'slider_nav'		=> $navigation,
				'slider_dots'		=> $dots,
				'rs_extra_large' 			=> 1,
				'rs_large'					=> 1,
				'rs_medium' 				=> 1,
				'rs_small' 					=> 1,
				'rs_extra_small' 			=> 1,
			);
			$slider_data 		= shortcode_atts(kapee_slider_options(),$owl_data);
			global $kapee_owlparam;
			$kapee_owlparam['owlCarouselArg'][$args['widget_id']] = $slider_data;
		}	
        $this->widget_start($args, $instance);
		do_action( 'kapee_before_products_widget');?>
		
		<ul class="product_list_widget<?php echo esc_attr($class); ?>">
			<?php
			$template_args = array(
				'widget_id'   => $args['widget_id'],
				'show_rating' => $show_rating,
			);
			$products = $this->get_products($args, $instance);
			$row=1;
			if($products->have_posts()){
				while($products->have_posts()):
					$products->the_post();
					if($slider && $row==1) { 
						echo '<ul>'; 
					} 
					wc_get_template( 'content-widget-product.php', $template_args );
					if( $slider && ( $row==$number_slide || $products->current_post+1 == $products->post_count ) ){ 
						$row=0; 
						echo '</ul>'; 
					} 
						$row++;	
				endwhile;						
			}
			wp_reset_postdata();
			?>
		</ul>
		
		<?php
		do_action( 'kapee_after_products_widget');
		$this->widget_end($args);
        echo ob_get_clean();
    }

}