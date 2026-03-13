<?php
/**
 *	Kapee Widget: Tab Posts
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Tab_Posts extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-tab-posts';
        $this->widget_description 	= __("Display tab posts.", 'kapee-extensions');
        $this->widget_id 			= 'kapee-tab-posts';
        $this->widget_name 			= __('KP: Tab Posts', 'kapee-extensions');
		$tab_contents_list = array(
				'popular'	=> esc_html__( 'Popular Posts', 'kapee-extensions' ),
				'recent'	=> esc_html__( 'Recent Posts', 'kapee-extensions' ),
				'comments'	=> esc_html__( 'Recent Comments', 'kapee-extensions' ),				
			);
		$post_order = array(
				'comment_count'	=> esc_html__( 'Most Commented', 'kapee-extensions' ),
				'viewed'		=> esc_html__( 'Most Viewed', 'kapee-extensions' ),						
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
                'std' 		=> 'recent',
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
                'std' 	=> 'Popular',
            ),
			'tab2_content' => array(
                'type' 		=> 'select',
                'label' 	=> __('Tab #2 Content:', 'kapee-extensions'),
                'options' 	=> $tab_contents_list,
                'std' 		=> 'popular',
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
                'std' 	=> 'Comments',
            ),
			'tab3_content' => array(
                'type' 		=> 'select',
                'label' 	=> __('Tab #3 Content:', 'kapee-extensions'),
                'options' 	=> $tab_contents_list,
                'std' 	=> 'comments',
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
                'label' => __('Number of posts to show:', 'kapee-extensions'),
            ),
			'show_image' => array(
                'type' 	=> 'checkbox',
                'label' => __('Show Image?', 'kapee-extensions'),
                'std' 	=> true,
            ),
            'image_size' => array(
                'type' 		=> 'select',
                'label' 	=> __('Image Size:', 'kapee-extensions'),
                'options' 	=> kapee_get_all_image_sizes(true),
                'std' 		=> 'thumbnail',
            ),
           'posts_order' => array(
                'type' 		=> 'select',
                'label' 	=> __('Popular Tab Order:', 'kapee-extensions'),
                'options' 	=> $post_order,
                'std' 		=> 'comment_count',
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
    public function get_posts($args, $instance, $type)
    {
        $number 		= !empty($instance['number']) ? absint($instance['number']) : $this->settings['number']['std'];
        $popular_order 	= ( $instance['posts_order'] == 'viewed' ) ? 'views' : $instance['posts_order'];
		
        switch ($type) {
            case 'popular':
                $query_args = array(
                    'post_type' 			=> 'post',
                    'posts_per_page' 		=> $number,
                    'post_status' 			=> 'publish',
                    'no_found_rows' 		=> 1,
                    'ignore_sticky_posts' 	=> 1,
                    'orderby' 				=> 'comment_count',
                );
				
				if( $popular_order == 'views'){
					$prefix 				= KAPEE_PREFIX;
					$query_args['orderby']  = 'meta_value_num';
					$query_args['meta_key'] = apply_filters( 'kapee_views_meta_field', $prefix.'views_count' );
				}
                return new WP_Query(apply_filters('kapee_popular_posts_query_args', $query_args));
                break;
            case 'recent':
                $query_args = array(
                    'post_type' 			=> 'post',
                    'posts_per_page' 		=> $number,
                    'post_status' 			=> 'publish',
                    'no_found_rows' 		=> 1,
                    'ignore_sticky_posts' 	=> 1,
                );
                return new WP_Query(apply_filters('kapee_recent_posts_query_args', $query_args));
                break;
            default:
                break;
        }
    }

    /**
     * Outputs the tab posts
     *
     * @param array $instance
     */
    public  function render_post($instance){
		$size = $instance['image_size'];
		$size = apply_filters('kapee_tab_posts_thumbnail_size',$size);
        ?>
        <div class="widget-post-item">
			<?php if ( has_post_thumbnail() && $instance['show_image']){ ?>
					<div class="widget-post-thumbnail">
						<a href="<?php echo esc_url( get_permalink() );?>" > <?php the_post_thumbnail($size);?></a>
					</div>
			<?php }; ?>
			<div class="widget-post-body">
				<h6 class="post-title">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</h6>
				
				<div class="post-meta">
					<span class="post-date">
						<?php echo get_the_date();?>
					</span>
				</div>				
			</div>
		</div>
        <?php
    }
	
	/**
     * Outputs the tab comments
     *
     * @param array $instance
     */
    public  function render_tab_content($content_type,$args, $instance){
		switch($content_type){
			case 'recent':
				$recent_posts = $this->get_posts($args, $instance, 'recent' );
				if($recent_posts->have_posts()){
					while($recent_posts->have_posts()):$recent_posts->the_post();
						$this->render_post($instance);
					endwhile;wp_reset_postdata();
				}
			break;
			case 'popular':
				$popular_posts = $this->get_posts($args, $instance, 'popular' );
				if($popular_posts->have_posts()){
					while($popular_posts->have_posts()):$popular_posts->the_post();
						$this->render_post($instance);
					endwhile;wp_reset_postdata();
				}
			break;
			case 'comments':
				$this->render_comments($instance);
			break;
		}
	}
	/**
     * Outputs the tab comments
     *
     * @param array $instance
     */
    public  function render_comments($instance){
		$comment_posts 	= $instance['number'];
		$avatar_size 	= 70;
		$comments 		= get_comments( 'post_type=post&status=approve&number='.$comment_posts );
		
		foreach ($comments as $comment){ ?>
			<div class="post-comment">
				<?php
				// Show the avatar if it is active only
				if( get_option( 'show_avatars' ) ){ ?>
					<div class="comments-thumbnail" style="width:<?php echo esc_attr( $avatar_size ) ?>px">
						<a class="author-avatar" href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo esc_attr( $comment->comment_ID ); ?>">
							<?php echo get_avatar( $comment, $avatar_size ); ?>
						</a>
					</div>
				<?php 
				} ?>
				<div class="comment-body">
					<a class="comment-author" href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo esc_attr( $comment->comment_ID ); ?>">
						<?php echo strip_tags($comment->comment_author); ?>
					</a>
					<p><?php echo wp_html_excerpt( $comment->comment_content, 60 ); ?>...</p>
				</div>
			</div>
			<?php
		}
								
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
		do_action( 'kapee_before_tab_posts');
		$widget_id = kapee_uniqid('widget-');
		?>
		
		<div class="kapee-tabs-widget kapee-tabs tabs-classic">
			<?php if( ( isset( $instance['tab_enable1'] ) || isset( $instance['tab_enable2'] ) || isset( $instance['tab_enable3'] ) ) && ( $instance['tab_enable1'] || $instance['tab_enable2'] || $instance['tab_enable3'] ) ){?>
				<ul class="nav nav-tabs" role="tablist">
					<?php if( $instance['tab_enable1'] ) { ?>
						<li class="nav-item">
							<a data-toggle="tab" class="nav-link active" href="#<?php echo esc_attr($widget_id);?>-tab1"><?php echo esc_html($instance['tab_title_1']);?></a>
						</li>
					<?php } ?>
					<?php if( $instance['tab_enable2'] ) { ?>
						<li class="nav-item">				
							<a data-toggle="tab" class="nav-link" href="#<?php echo esc_attr($widget_id);?>-tab2"><?php echo esc_html($instance['tab_title_2']);?></a>
						</li>
					<?php }?>
					<?php if( $instance['tab_enable3'] ) { ?>
						<li class="nav-item">					
							<a data-toggle="tab" class="nav-link" href="#<?php echo esc_attr($widget_id);?>-tab3"><?php echo esc_html($instance['tab_title_3']);?></a>
						</li>
					<?php }?>
				</ul>
				<div class="tab-content">
					<?php if( $instance['tab_enable1'] ) { ?>
						<div id="<?php echo esc_attr( $widget_id ) ?>-tab1" class="tab-pane fade show active tab-content-recent" role="panel">
							<?php $this->render_tab_content( $instance['tab1_content'], $args, $instance ); ?>
						</div>
					<?php }
					if( $instance['tab_enable2'] ) { ?>
						<div id="<?php echo esc_attr( $widget_id ) ?>-tab2" class="tab-pane fade tab-content-popular" role="panel">
							<?php $this->render_tab_content( $instance['tab2_content'], $args, $instance ); ?>
						</div>
					<?php } 
					if( $instance['tab_enable3'] ) {?>
						<div id="<?php echo esc_attr( $widget_id ) ?>-tab3" class="tab-pane fade tab-content-comment" role="panel">						
							<?php $this->render_tab_content($instance['tab3_content'],$args, $instance); ?>
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