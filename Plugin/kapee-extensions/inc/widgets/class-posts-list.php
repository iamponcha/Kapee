<?php
/**
 *	Kapee Widget: Posts List
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Posts_List extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-posts-lists';
        $this->widget_description 	= esc_html__("Display posts lists.", 'kapee-extensions');
        $this->widget_id 			= 'kapee-posts-list';
        $this->widget_name 			= esc_html__('KP: Posts List', 'kapee-extensions');
		$post_order 				= kapee_post_order();
		$this->image_sizes 			= kapee_get_all_image_sizes(true);
        array_shift($this->image_sizes);
		$this->settings = array(
            'title' => array(
                'type' 	=> 'text',
                'label' => esc_html__('Title:', 'kapee-extensions'),
                'std' 	=> esc_html__('Post Lists', 'kapee-extensions'),
            ),
			'order' => array(
                'type' 		=> 'select',
                'label' 	=> esc_html__('Posts Order:', 'kapee-extensions'),
                'options' 	=> kapee_post_order(),
                'std' 		=> 'latest',
            ),
			'cats_id' => array(
                'type' 		=> 'multi-select',
                'label' 	=> esc_html__('Categories:', 'kapee-extensions'),
                'options' 	=> kapee_get_all_categories(),
            ),
            'number' => array(
                'type' 	=> 'number',
                'step' 	=> 1,
                'min' 	=> 1,
                'max' 	=> '',
                'std' 	=> 5,
                'label' => esc_html__('Number of posts to show:', 'kapee-extensions'),
            ),
            'image_size' => array(
                'type' 		=> 'select',
                'label' 	=> esc_html__('Image Size:', 'kapee-extensions'),
                'options' 	=> $this->image_sizes,
                'std' 		=> 'thumbnail',
            ),
            'show_image' => array(
                'type' 	=> 'checkbox',
                'label' => esc_html__('Show Posts Image?', 'kapee-extensions'),
                'std' 	=> true,
            ),
			'show_category' => array(
                'type' 	=> 'checkbox',
                'label' => __( 'Show Category?', 'kapee-extensions' ),
                'std' 	=> true,
            ),
            'show_date' => array(
                'type' 	=> 'checkbox',
                'label' => __( 'Show Date?', 'kapee-extensions' ),
                'std' 	=> true,
            ),
            'show_comment' => array(
                'type' 	=> 'checkbox',
                'label' => __( 'Show Comment?', 'kapee-extensions' ),
                'std' 	=> true,
            ),
			'exclude_current_post' => array(
                'type' 	=> 'checkbox',
                'label' => esc_html__('	Exclude Current Post in the single post page?', 'kapee-extensions'),
                'std' 	=> false,
            ),
			'style' => array(
                'type' 		=> 'select',
                'label' 	=> esc_html__('Select Style:', 'kapee-extensions'),
                'options' 	=> array(
					'style-1' => esc_html__('Style 1','kapee-extensions'),
					'style-2' => esc_html__('Style 2','kapee-extensions'),
					'style-3' => esc_html__('Style 3','kapee-extensions'),
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
			'post_status'         => array( 'publish' ),
			'posts_per_page'      => 5,
			'ignore_sticky_posts' => true
		);
       
		// Exclude Posts
		if( ! empty( $args['exclude_current_post'] ) && is_single()){
			$exclude_posts[] = get_the_id();
			$query_args['post__not_in'] = $exclude_posts;
		}
		// Posts Number
		if( ! empty( $args['number'] )){
			$query_args['posts_per_page'] = $args['number'];
		}
		
		// Posts Order
		if( ! empty( $args['order'] ) ){

			// Random Posts
			if( $args['order'] == 'rand' ){
				$query_args['orderby'] = 'rand';
			}

			// Most Viewd posts
			elseif( $args['order'] == 'views'){
				$prefix = KAPEE_EXTENSIONS_META_PREFIX;
				$query_args['orderby']  = 'meta_value_num';
				$query_args['meta_key'] = apply_filters( 'kapee_views_meta_field', $prefix.'views_count' );
			}

			// Popular Posts by comments
			elseif( $args['order'] == 'popular' ){
				$query_args['orderby'] = 'comment_count';
			}

			// Recent modified Posts
			elseif( $args['order'] == 'modified' ){
				$query_args['orderby'] = 'modified';
			}
		}
		// Posts Order
		if( ! empty( $args['cats_id'] ) ){
			$query_args['cat'] = $args['cats_id'];
		}
		//return $query_args;
		return new WP_Query(apply_filters('kapee_posts_list_widget_query_args', $query_args));
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
		do_action( 'kapee_before_posts_list');
		$class = $instance['style'];
        
		$query = $this->get_posts($instance);
		
		if ( $query->have_posts() ){ ?>
			<div class="kapee-widget-posts-list <?php echo esc_attr($class);?>">
				<?php
				$size = apply_filters('kapee_posts_list_thumbnail_size', $instance['image_size'] );
				while ( $query->have_posts() ){ $query->the_post(); ?>			
					<div class="widget-post-item">
						<?php if ( has_post_thumbnail() && $instance['show_image']){ ?>
							<div class="widget-post-thumbnail">
								<a href="<?php echo esc_url( get_permalink() );?>" > <?php the_post_thumbnail($size);?></a>
							</div>
						<?php }; ?>
						<div class="widget-post-body">
							<?php if( isset($instance['show_category']) && $instance['show_category'] ): ?>
								<div class="post-categories">
									<span class="cat-links"><?php echo get_the_category_list( esc_html__( ' ', 'kapee-extensions' ));?> </span>
								</div>
							<?php endif; ?>
							<h6 class="post-title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							</h6>
							<?php if( $instance['show_date'] || $instance['show_comment']) { ?>
								<div class="post-meta">
									<?php if( $instance['show_date'] ): ?>
										<span class="post-date">
											<?php echo get_the_date();?>
										</span>
									<?php endif; ?>
									<?php if( isset($instance['show_comment']) && $instance['show_comment'] && ! post_password_required() && ( comments_open() || get_comments_number() ) ): ?>
										<span class="post-comments">
											<?php 
											$comment_tag = '%s<span class="post-meta-label"> %s</span>';			
											comments_popup_link( 
												sprintf( $comment_tag, '0', esc_html__( 'Comments', 'kapee-extensions' ) ),
												sprintf( $comment_tag, '1', esc_html__( 'Comment', 'kapee-extensions' ) ),
												sprintf( $comment_tag, '%', esc_html__( 'Comments', 'kapee-extensions' ) )
											);?>	
										</span>
									<?php endif; ?>
								</div>
							<?php } ?>
						</div>
					</div>			
				<?php } ?>
			</div>
		<?php }		
		
		wp_reset_postdata();
		
        do_action( 'kapee_after_posts_list');
		
		$this->widget_end($args);
		
        echo ob_get_clean();
    }

}