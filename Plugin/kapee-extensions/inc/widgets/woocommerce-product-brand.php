<?php
/**
 *	Kapee Widget: Kapee Product Brands
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'WC_Widget' ) ) {
	return;
}

/**
 * Product Brand Widget.
 *
 */
class Kapee_Widget_Product_Brands extends WC_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {


		$this->widget_cssclass    = 'woocommerce kapee-product-brands';
		$this->widget_description = esc_html__( 'Display product brands.', 'kapee-extensions' );
		$this->widget_id          = 'kapee-product-brand';
		$this->widget_name        = esc_html__( 'KP: Product Brands', 'kapee-extensions' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Product Brands', 'kapee-extensions' ),
				'label' => esc_html__( 'Title', 'kapee-extensions' )
			)
		);

		parent::__construct();
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		if ( ! kapee_is_catalog() ) {
			return;
		}
		$current_taxonomy = 'product_brand';
		$term_id          = 0;
		/* $queried_object   = get_queried_object();
		if ( $queried_object && isset ( $queried_object->term_id ) ) {
			$term_id = $queried_object->term_id;
		} */

		if ( empty( $instance['title'] ) ) {
			$taxonomy          = get_taxonomy( $current_taxonomy );
			$instance['title'] = $taxonomy->labels->name;
		}

		$this->widget_start( $args, $instance );

		$terms  = get_terms( $current_taxonomy );
		$found  = false;
		$output = array();
		if ( $terms ) {

			foreach ( $terms as $term ) {

				$css_class = '';
				if ( $term_id == $term->term_id ) {
					$css_class = 'selected';
					$found     = true;
				}

				$output[] = sprintf( '<li><a href="%s" class="%s">%s</a></li>', esc_url( get_term_link( $term ) ), esc_attr( $css_class ), $term->name );
			}

		}
		$css_class = $found ? '' : 'selected';

		printf(
			'<ul class="kapee_product_brands">' .
			'<li><a href="%s" class="%s">%s</a></li>' .
			'%s' .
			'</ul>',
			esc_url( esc_url( get_permalink( get_option( 'woocommerce_shop_page_id' ) ) ) ),
			esc_attr( $css_class ),
			esc_html__( 'All', 'kapee-extensions' ),
			implode( ' ', $output )
		);

		$this->widget_end( $args );
	}

}
