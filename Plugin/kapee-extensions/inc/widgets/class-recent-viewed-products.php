<?php
/**
 *	Kapee Widget: Recent Viewed Poroducts
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Recent_Viewed_Products extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-recent-viewed-products woocommerce';
        $this->widget_description 	= __("Display recent viewed products.", 'kapee-extensions');
        $this->widget_id 			= 'kapee-recent-viewed-products';
        $this->widget_name 			= __('KP: Recent Viewed Products', 'kapee-extensions');
		$this->settings = array(
            
			'title' => array(
                'type' 	=> 'text',
                'label' => __('Title:', 'kapee-extensions'),
                'std' 	=> 'Recently Viewed Products',
            ),
			'number' => array(
                'type' 	=> 'number',
                'step' 	=> 1,
                'min' 	=> 1,
                'max' 	=> '',
                'std' 	=> 5,
                'label' => __('Number of products to show:', 'kapee-extensions'),
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
    public function get_products($args, $instance,$viewed_products)
    {
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];

		$query_args = array(
			'posts_per_page' => $number,
			'no_found_rows'  => 1,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'post__in'       => $viewed_products,
			'orderby'        => 'post__in',
		);

		if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'outofstock',
					'operator' => 'NOT IN',
				),
			); // WPCS: slow query ok.
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
		
		$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array(); // @codingStandardsIgnoreLine
		$viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

		if ( empty( $viewed_products ) ) {
			return;
		}
        ob_start();

        $this->widget_start($args, $instance);
		do_action( 'kapee_before_products_widget');
		
		?>
		<div class="container-wrapper product-container-wrapper">
			<div class="widget-container">
				<ul class="product_list_widget">
				<?php
					$products = $this->get_products($args, $instance,$viewed_products);
					if($products->have_posts()){
						while($products->have_posts()):$products->the_post();
							wc_get_template_part( 'content', 'widget-product' );
						endwhile;wp_reset_postdata();
					}
				?>
				</ul>
			</div>
		</div>
		<?php
		do_action( 'kapee_after_products_widget');
        echo ob_get_clean();
    }

}