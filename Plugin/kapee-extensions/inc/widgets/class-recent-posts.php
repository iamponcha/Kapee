<?php
/**
 *	Kapee Widget: Kapee_Recent_Posts
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Recent_Posts extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-recent-posts';
        $this->widget_description 	= esc_html__("Display recent posts", 'kapee-extensions');
        $this->widget_id 			= 'kapee-recent-posts';
        $this->widget_name 			= esc_html__('KP: Recent Posts', 'kapee-extensions');
		$this->image_sizes 			= kapee_get_all_image_sizes(true);
        array_shift($this->image_sizes);
		
		$this->settings = array(
            'title' => array(
                'type' 	=> 'text',
                'label' => __('Title:', 'kapee-extensions'),
				'std' 	=> esc_html__('Recent Posts', 'kapee-extensions'),
            ),
			'category' => array(
                'type' 	=> 'dropdown-taxonomies',
                'label' => __('Select Category:', 'kapee-extensions'),
                'desc' 	=> __('Leave empty if you don\'t want the posts to be category specific', 'kapee-extensions'),
                'args' => array(
                    'taxonomy' 			=> 'category',
                    'class' 			=> 'widefat',
                    'hierarchical' 		=> true,
                    'show_count' 		=> 1,
                    'show_option_all' 	=> __('&mdash; Select &mdash;', 'kapee-extensions'),
                ),
            ),
            'number' => array(
                'type' 	=> 'number',
                'step' 	=> 1,
                'min' 	=> 1,
                'max' 	=> '',
                'std' 	=> 5,
                'label' => __( 'Number of posts to show:', 'kapee-extensions' ),
            ),
            'image_size' => array(
                'type' 		=> 'select',
                'label' 	=> __( 'Image Size:', 'kapee-extensions' ),
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
                'std' 	=> false,
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
			'style' => array(
                'type' 		=> 'select',
                'label' 	=> esc_html__('Select Style:', 'kapee-extensions'),
                'options' 	=> array(
					'style-1' => esc_html__('Style 1','kapee-extensions'),
					'style-2' => esc_html__('Style 2','kapee-extensions'),
					'style-3' => esc_html__('Style 3','kapee-extensions'),
				),
            ),
			'slider' => array(
                'type' 	=> 'checkbox',
                'label' => __( 'Enable slider?', 'kapee-extensions' ),
                'std' 	=> true,
            ),
			'number_slide' => array(
                'type' 	=> 'text',
                'label' => __('Per slide show posts:', 'kapee-extensions'),
                'std' 	=> 5,
            ),
			'autoplay' => array(
                'type' 	=> 'checkbox',
                'label' => __('Enable Auto play slider?', 'kapee-extensions'),
                'std' 	=> 5,
            ),
			'loop' => array(
                'type' 	=> 'checkbox',
                'label' => esc_html__('Continue slider loop?', 'kapee-extensions'),
                'std' 	=> 5,
            ),
			'navigation' => array(
                'type' 	=> 'checkbox',
                'label' => __('Show slider navigation?', 'kapee-extensions'),
                'std' 	=> 5,
            ),
			'dots' => array(
                'type' 	=> 'checkbox',
                'label' => __('Show slider dots?', 'kapee-extensions'),
                'std' 	=> 5,
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
    public function get_posts($args, $instance)
    {
        $number = !empty($instance['number']) ? absint($instance['number']) : $this->settings['number']['std'];
        
        $query_args = array(
            'posts_per_page' 		=> $number,
            'post_status' 			=> 'publish',
            'no_found_rows' 		=> 1,
            'ignore_sticky_posts' 	=> 1
        );

        if (!empty($instance['category']) && -1 != $instance['category'] && 0 != $instance['category']) {
            $query_args['tax_query'][] = array(
                'taxonomy' 	=> 'category',
                'field' 	=> 'term_id',
                'terms' 	=> $instance['category'],
            );
        }

        return new WP_Query(apply_filters('kapee_recent_posts_query_args', $query_args));
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
		//kapee_pre($args);
        ob_start();
		if (($recent_posts = $this->get_posts($args, $instance)) && $recent_posts->have_posts()) {
			
			$this->widget_start($args, $instance);			
			
			do_action( 'kapee_before_recent_posts');
			
			$image_size 	= ($instance['image_size']) ? esc_attr($instance['image_size']) : 'thumbnail';
			$number 		= (!empty($instance['number'])) ? (int) $instance['number'] : 10;
			$class 			= ' '.$instance['style'];
			$number_slide 	= (!empty($instance['number_slide'])) ? (int) $instance['number_slide'] : 5;
			$slider 		= (!empty($instance['slider'])) ? (bool) $instance['slider'] : false;
			$autoplay 		= (!empty($instance['autoplay'])) ? (bool) $instance['autoplay'] : false;
			$loop 			= (!empty($instance['loop'])) ? (bool) $instance['loop'] : false;
			$navigation 	= (!empty($instance['navigation'])) ? (bool) $instance['navigation'] : false;
			$dots 			= (!empty($instance['dots'])) ? (bool) $instance['dots'] : false;
			$id 			= $args['widget_id'];
			
			$owl_data				= array(
									'slider_loop'				=> $loop,
									'slider_autoplay' 			=> $autoplay,
									'slider_nav'				=> $navigation,
									'slider_dots'				=> $dots,
									'rs_extra_large' 			=> 1,
									'rs_large'					=> 1,
									'rs_medium' 				=> 1,
									'rs_small' 					=> 1,
									'rs_extra_small' 			=> 1,
									);
									
			$slider_data 		= shortcode_atts(kapee_slider_options(),$owl_data);
			global $kapee_owlparam;
			$kapee_owlparam['owlCarouselArg'][$args['widget_id']] = $slider_data;
			
			if($slider){
				$class	.=	" kapee-carousel owl-carousel";
			}
			
			$size = apply_filters('kapee_recent_posts_list_thumbnail_size', $instance['image_size'] );
			?>
			<div class="kapee-widget-recent-posts<?php echo esc_attr($class); ?>">
				<?php 
					
					$row=1;
					while ($recent_posts->have_posts()) : $recent_posts->the_post();
					
						if($slider && $row==1) { 
							echo '<div class="slide-row">'; 
						} ?>						
						<div class="widget-post-item">
							<?php if ( has_post_thumbnail() && $instance['show_image']){ ?>
								<div class="widget-post-thumbnail">
									<a href="<?php echo esc_url( get_permalink() );?>" > <?php the_post_thumbnail($size);?></a>
								</div>
							<?php }; ?>
							<div class="widget-post-body">
								<?php if( $instance['show_category'] ): ?>
									<div class="post-categories">
										<span class="cat-links"><?php echo get_the_category_list( esc_html__( ' ', 'kapee-extensions' ));?> </span>
									</div>
								<?php endif; ?>
								<h6 class="post-title">
									<a href="<?php the_permalink() ?>" title="<?php get_the_title();?>"><?php the_title(); ?></a>
								</h6>							
								<?php if( $instance['show_date'] || $instance['show_comment']) { ?>
									<div class="post-meta">
										<?php if( $instance['show_date'] ): ?>
											<span class="post-date">
												<?php echo get_the_date();?>
											</span>
										<?php endif; ?>
										<?php if( $instance['show_comment'] && ! post_password_required() && ( comments_open() || get_comments_number() ) ): ?>
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
								<?php }?>
							</div>
						</div>						
						<?php if( $slider && ( $row==$number_slide || $recent_posts->current_post+1 == $recent_posts->post_count ) ){ 
							$row=0; 
							echo '</div>'; 
						} 
						$row++;	
						
				endwhile; 
				wp_reset_postdata();?>
			</div>
			<?php
			do_action( 'kapee_after_recent_posts');

			$this->widget_end($args);
		}
        echo ob_get_clean();
    }

}
