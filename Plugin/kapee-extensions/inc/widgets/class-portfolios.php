<?php
/**
 *	Kapee Widget: Portfolios
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Portfolios extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-portfolios-lists';
        $this->widget_description 	= esc_html__("Display portfolios lists.", 'kapee-extensions');
        $this->widget_id 			= 'kapee-portfolios';
        $this->widget_name 			= esc_html__('KP: Portfolios', 'kapee-extensions');
		$post_order 				= kapee_post_order();
		$this->image_sizes 			= kapee_get_all_image_sizes(true);
        array_shift($this->image_sizes);
		$this->settings = array(
            'title' => array(
                'type' 	=> 'text',
                'label' => __('Title:', 'kapee-extensions'),
                'std' 	=> __('Portfolios', 'kapee-extensions'),
            ),
			'orderby' => array(
                'type' 		=> 'select',
                'label' 	=> esc_html__('Order By:', 'kapee-extensions'),
				'std' 		=> 'date',
                'options' 	=> array( 
								'date' 	=> esc_html__('Date','kapee-extensions'),
								'title' => esc_html__('Title','kapee-extensions'),
								'name' 	=> esc_html__('Name(Slug)','kapee-extensions'),							
								'rand' 	=> esc_html__('Rand','kapee-extensions'),							
								'id' 	=> esc_html__('ID','kapee-extensions'),							
							),
            ),
			'order' => array(
                'type' 		=> 'select',
                'label' 	=> esc_html__('Sort By:', 'kapee-extensions'),
				'std' 		=> 'desc',
                'options' 	=> array( 
								'desc' => esc_html__('Descending','kapee-extensions'),
								'asc' => esc_html__('Ascending','kapee-extensions'),				
							),
            ),
            'number' => array(
                'type' 	=> 'number',
                'step' 	=> 1,
                'min' 	=> 1,
                'max' 	=> '',
                'std' 	=> 5,
                'label' => __('Number of portfolios to show', 'kapee-extensions'),
            ),
            'image_size' => array(
                'type' 		=> 'select',
                'label' 	=> esc_html__('Image Size:', 'kapee-extensions'),
                'options' 	=> $this->image_sizes,
                'std' 	=> 'thumbnail',
            ),
            'show_image' => array(
                'type' 	=> 'checkbox',
                'label' => __('Show Portfolios Image..', 'kapee-extensions'),
                'std' 	=> true,
            ),
			'show_date' => array(
                'type' 	=> 'checkbox',
                'label' => __( 'Show Date?', 'kapee-extensions' ),
                'std' 	=> true,
            ),
			'exclude_current_post' => array(
                'type' 	=> 'checkbox',
                'label' => __('	Exclude Current Post in the single post page.', 'kapee-extensions'),
                'std' 	=> false,
            ),
			'style' => array(
                'type' 		=> 'select',
                'label' 	=> __('Select Style:', 'kapee-extensions'),
                'options' 	=> array(
					'style-1' => __('Style 1','kapee-extensions'),
					'style-2' => __('Style 2','kapee-extensions'),
					'style-3' => __('Style 3','kapee-extensions'),
				),
            ),
			
		);
		parent::__construct();
	}
	
	/**
     * Query the posts and return them.
     * @param  array $args
     * @param  array $instance
     * @return WP_Query
     */
    public function get_posts($args)
    {
		$query_args = array(
			'post_type'         	=> 'portfolio',
			'post_status'         	=> array( 'publish' ),
			'posts_per_page'      	=> 5,
			'ignore_sticky_posts' 	=> true,
			'orderby'				=> 'date',
			'order'					=> 'desc',
		);
       
		// Exclude Posts
		if( ! empty( $args['exclude_current_post'] ) && is_single()){
			$query_args['post__not_in'] = get_the_id();
		}
		// Posts Number
		if( ! empty( $args['number'] )){
			$query_args['posts_per_page'] = $args['number'];
		}
		// Posts OrderBy
		if( ! empty( $args['orderby'] )){
			$query_args['orderby'] = $args['orderby'];
		}
		// Posts Order
		if( ! empty( $args['order'] )){
			$query_args['order'] = $args['order'];
		}
		//return $query_args;
		return new WP_Query(apply_filters('kapee_portfolios_widget_query_args', $query_args));
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

        static $counter_instance = 0;
        $counter_instance++;

        ob_start();
		
		$this->widget_start($args, $instance);
		
        do_action( 'kapee_before_portfolios');
		$class = $instance['style'];
		$query = $this->get_posts($instance);
		
		if ( $query->have_posts() ){ ?>
			<div class="kapee-widget-portfolios-list <?php echo esc_attr($class);?>">
				<?php
				$size = $instance['image_size'];
				$size = apply_filters('kapee_portfolio_thumbnail_size',$size);
				while ( $query->have_posts() ){ $query->the_post(); ?>			
					<div class="widget-portfolio-item">
						<?php if ( has_post_thumbnail() && $instance['show_image'] ){ ?>
							<div class="portfolio-thumbnail">
								<a href="<?php echo esc_url( get_permalink() );?>"><?php the_post_thumbnail( $size );?></a>
							</div>
						<?php }; 
						if( $instance['style'] != 'style-3' ){ ?>
							<div class="portfolio-body">
								<h6 class="portfolio-title">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
								</h6>
								<?php if( $instance['show_date'] ) : ?>
									<div class="portfolio-meta">
										<span class="portfolio-date">
											<?php echo get_the_date(); ?>
										</span>
									</div>
								<?php endif; ?>
							</div>
						<?php } //End style-3 condition?>
					</div>			
				<?php } ?>
			</div>
		<?php }
		
		wp_reset_postdata();
        
		do_action( 'kapee_after_portfolios');
		
		$this->widget_end($args);
		
        echo ob_get_clean();
    }

}