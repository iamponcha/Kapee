<?php
/**
 *	Kapee Widget: Recent Comments
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Recent_Comments extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-recent-comments';
        $this->widget_description 	= esc_html__("Display recent comments", 'kapee-extensions');
        $this->widget_id 			= 'kapee-recent-comments';
        $this->widget_name 			= esc_html__('KP: Recent Comments', 'kapee-extensions');
		$this->image_sizes 			= kapee_get_all_image_sizes(true);
        array_shift($this->image_sizes);
		
		$this->settings = array(
            'title' => array(
                'type' 	=> 'text',
                'label' => __('Title:', 'kapee-extensions'),
                'std' 	=> __('Recently Comments', 'kapee-extensions'),
            ),
            'number' => array(
                'type' 	=> 'number',
                'step' 	=> 1,
                'min' 	=> 1,
                'max' 	=> '',
                'std' 	=> 5,
                'label' => esc_html__('Number of comments to show:', 'kapee-extensions'),
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
    public function widget($args, $instance){

        ob_start();
		
		$this->widget_start($args, $instance);			
			
		do_action( 'kapee_before_recent_comments_widget'); ?>
		
		<div class="widget-recent-comments">
			<?php
			$comment_posts = $instance['number'];
			$avatar_size = 70;
			$comments = get_comments( 'status=approve&number='.$comment_posts );
			foreach ( $comments as $comment ){ ?>
				<div class="post-comment">
					<?php
					// Show the avatar if it is active only
					if( get_option( 'show_avatars' ) ){?>						
						<div class="comments-thumbnail" style="width:<?php echo esc_attr( $avatar_size ) ?>px">
							<a class="author-avatar" href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo esc_attr( $comment->comment_ID ); ?>">
								<?php echo get_avatar( $comment, $avatar_size ); ?>
							</a>
						</div>
					<?php } ?>
					<div class="comment-body">
						<a class="comment-author" href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo esc_attr( $comment->comment_ID ); ?>">
							<?php echo strip_tags($comment->comment_author); ?>
						</a>
						<p><?php echo wp_html_excerpt( $comment->comment_content, 60 ); ?>...</p>
					</div>
				</div>
			<?php }	?>
		</div>
		
		<?php		
		do_action( 'kapee_after_recent_comments_widget');

		$this->widget_end($args);

        echo ob_get_clean();
    }

}
