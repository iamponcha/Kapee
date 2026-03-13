<?php
/**
 *	Kapee Widget: Products Tab
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Products_Tab extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-products-tab woocommerce';
        $this->widget_description 	= esc_html__("Display products tab.", 'kapee-extensions');
        $this->widget_id 			= 'kapee-products-tab';
        $this->widget_name 			= esc_html__('KP: Products Tab', 'kapee-extensions');
		$tab_contents_list = array(
				'recent'		=> esc_html__( 'Recent Products', 'kapee-extensions' ),
				'featured'		=> esc_html__( 'Feature Products', 'kapee-extensions' ),
				'on-sale'		=> esc_html__( 'On Sale Products', 'kapee-extensions' ),				
				'top-selling'	=> esc_html__( 'Top Selling Products', 'kapee-extensions' ),				
				'top-rated'		=> esc_html__( 'Top Rated Products', 'kapee-extensions' ),				
			);
		
		$this->settings = array(
            'post_settings1' => array(
                'type' 	=> 'heading',
                'label' => __('Tab1 Settings', 'kapee-extensions'),
            ),
			'tab_enable1' => array(
                'type' 	=> 'checkbox',
                'label' => __('Enable?', 'kapee-extensions'),
                'std' 	=> true,
            ),
			'tab_title_1' => array(
                'type' 	=> 'text',
                'label' => __('Title:', 'kapee-extensions'),
                'std' 	=> 'Recent',
            ),
			'tab1_content' => array(
                'type' 		=> 'select',
                'label' 	=> __('Tab #1 Content:', 'kapee-extensions'),
                'options' 	=> $tab_contents_list,
                'std' 	=> 'recent',
            ),
			'post_settings2' => array(
                'type' 	=> 'heading',
                'label' => __('Tab2 Settings', 'kapee-extensions'),
            ),
			'tab_enable2' => array(
                'type' 	=> 'checkbox',
                'label' => __('Enable?', 'kapee-extensions'),
                'std' 	=> true,
            ),
			'tab_title_2' => array(
                'type' 	=> 'text',
                'label' => __('Title:', 'kapee-extensions'),
                'std' 	=> 'Feature',
            ),
			'tab2_content' => array(
                'type' 		=> 'select',
                'label' 	=> __('Tab #2 Content:', 'kapee-extensions'),
                'options' 	=> $tab_contents_list,
                'std' 		=> 'featured',
            ),
			'post_settings3' => array(
                'type' 	=> 'heading',
                'label' => __('Tab3 Settings', 'kapee-extensions'),
            ),
			'tab_enable3' => array(
                'type' 	=> 'checkbox',
                'label' => __('Enable?', 'kapee-extensions'),
                'std' 	=> true,
            ),
			'tab_title_3' => array(
                'type' 	=> 'text',
                'label' => __('Title:', 'kapee-extensions'),
                'std' 	=> 'On Sale',
            ),
			'tab3_content' => array(
                'type' 		=> 'select',
                'label' 	=> __('Tab #3 Content:', 'kapee-extensions'),
                'options' 	=> $tab_contents_list,
                'std' 		=> 'on-sale',
            ),
			'general_post_settings1' => array(
                'type' 	=> 'heading',
                'label' => __('General', 'kapee-extensions'),
            ),
            'number' => array(
                'type' 	=> 'number',
                'step' 	=> 1,
                'min' 	=> 1,
                'max' 	=> '',
                'std' 	=> 5,
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
            )
		);
		parent::__construct();
	}
	
	/**
     * Query the products and return them.
     * @param  array $args
     * @param  array $instance
     * @return WP_Query
     */
    public function get_products($args, $instance, $type)
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

        switch ( $type ) {
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
		$this->widget_start($args, $instance);
		do_action( 'kapee_before_products_tab');
		$widget_id = kapee_uniqid('widget-');
		
		$template_args = array(
				'widget_id'   => $args['widget_id'],
				'show_rating' => true,
			);?>
		
		<div class="products-tabs-widget kapee-tabs tabs-classic">
			<?php if( ( isset( $instance['tab_enable1'] ) || isset( $instance['tab_enable2'] ) || isset( $instance['tab_enable3'] ) ) && ( $instance['tab_enable1'] || $instance['tab_enable2'] || $instance['tab_enable3'] ) ){?>
				<ul class="nav nav-tabs" role="tablist">
					<?php if($instance['tab_enable1']) { ?>
						<li class="nav-item">
							<a data-toggle="tab" class="nav-link active" href="#<?php echo esc_attr($widget_id);?>-tab1"><?php echo esc_html($instance['tab_title_1']);?></a>
						</li>
					<?php }
					if($instance['tab_enable2']) { ?>
						<li class="nav-item">
							<a data-toggle="tab" class="nav-link" href="#<?php echo esc_attr($widget_id);?>-tab2"><?php echo esc_html($instance['tab_title_2']);?></a>
						</li>
					<?php }
					if($instance['tab_enable3']) { ?>
						<li class="nav-item">
							<a data-toggle="tab" class="nav-link" href="#<?php echo esc_attr($widget_id);?>-tab3"><?php echo esc_html($instance['tab_title_3']);?></a>
						</li>
					<?php } ?>
				</ul>
				<div class="tab-content">
					<?php if($instance['tab_enable1']) { ?>
						<div id="<?php echo esc_attr( $widget_id ) ?>-tab1" class="tab-pane fade show active" role="panel">
							<ul class="product_list_widget">
								<?php  
								$products_tab1 = $this->get_products($args, $instance, $instance['tab1_content']);
								if($products_tab1->have_posts()){
									while($products_tab1->have_posts()):$products_tab1->the_post();
										wc_get_template( 'content-widget-product.php', $template_args );
									endwhile;wp_reset_postdata();
								}
								?>
							</ul>
						</div>
					<?php }
					if($instance['tab_enable2']) { ?>
						<div id="<?php echo esc_attr( $widget_id ) ?>-tab2" class="tab-pane fade" role="panel">
							<ul class="product_list_widget">
								<?php 
								$products_tab2 = $this->get_products($args, $instance, $instance['tab2_content']);
								if($products_tab2->have_posts()){
									while($products_tab2->have_posts()):$products_tab2->the_post();
										wc_get_template( 'content-widget-product.php', $template_args );
									endwhile;wp_reset_postdata();
								}
								?>
							</ul>
						</div>
					<?php } 
					if($instance['tab_enable3']) {?>
						<div id="<?php echo esc_attr( $widget_id ) ?>-tab3" class="tab-pane fade" role="panel">
							<ul class="product_list_widget">
								<?php 
								$products_tab3 = $this->get_products($args, $instance, $instance['tab3_content']);
								if($products_tab3->have_posts()){
									while($products_tab3->have_posts()):$products_tab3->the_post();
										wc_get_template( 'content-widget-product.php', $template_args );
									endwhile;wp_reset_postdata();
								}
								?>
							</ul>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>		
		<?php
		do_action( 'kapee_after_tab_posts');
		$this->widget_end($args);
        echo ob_get_clean();
    }

}