<?php
/**
 *	Kapee Widget: Flickr
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Flickr extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-flickr';
        $this->widget_description 	= esc_html__("Display flickr images.", 'kapee-extensions');
        $this->widget_id 			= 'kapee-flickr';
        $this->widget_name 			= esc_html__('KP: Flickr', 'kapee-extensions');
		$this->settings 			= array(
            'title' => array(
                'type' => 'text',
                'label' => __('Title', 'kapee-extensions'),
                'std' => __('Flickr','kapee-extensions'),
            ),
			
			'flickr_id' => array(
                'type' 				=> 'text',
                'label' 			=> __('Flickr ID:', 'kapee-extensions'),
				'allow_esc_html'	=> false,
                'desc' 				=> sprintf( __( '<a href="%s">Find your ID at idGettr</a>', 'kapee-extensions' ), 'http://www.idgettr.com' ),
            ),
			'number_of_photos' => array(
                'type' 	=> 'number',
                'label' => __('Number Of Photos:', 'kapee-extensions'),
				'std' 	=> 9,
            ),			
			'flickr_display'=> array(
				'type' 		=> 'select',
                'label' 	=> __('Photos Order:', 'kapee-extensions'),
                'options' 	=> array(
                    'latest' => __('Most recent', 'kapee-extensions'),
                    'random' => __('Random', 'kapee-extensions'),
                ),
                'std' => 'latest',
            ),
			'link_text' => array(
                'type' 	=> 'text',
                'label' => esc_html__('Link Text:', 'kapee-extensions'),
				'std' 	=> 'Follow us on Flickr',
            ),
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
		
		$hide_title 	= (!empty($instance['hide_title'])) ? (bool) $instance['hide_title'] : false;
		if($hide_title) unset($instance['title']);
		
		$this->widget_start($args, $instance);
		
		do_action( 'kapee_before_flickr_widget');
		
		$number_of_photos   = isset( $instance['number_of_photos'] )   ? $instance['number_of_photos'] : 6;
		$flickr_display 	= isset( $instance['flickr_display'] ) ? $instance['flickr_display'] : 'latest';
		$link_text 			= isset( $instance['link_text'] ) ? $instance['link_text'] : '';

		if( ! empty( $instance['flickr_id'] )){
			?>

				<div class="flickr-images-wrapper">
					<script src="//www.flickr.com/badge_code_v2.gne?count=<?php echo esc_attr( $number_of_photos ); ?>&amp;display=<?php echo esc_attr( $flickr_display ); ?>&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo esc_attr( $instance['flickr_id'] ); ?>"></script>
					<div class="clearfix"></div>
				</div><!-- .flickr-images-wrapper -->
				<?php if( ! empty( $instance['link_text'] )){ ?>
					<a target="_blank" href="https://www.flickr.com/photos/<?php echo esc_attr( $instance['flickr_id'] )?>/" class="button dark-btn fullwidth"><?php esc_html_e($link_text); ?></a>
				<?php } ?>
			<?php
			}

		do_action( 'kapee_after_flickr_widget');

		$this->widget_end($args);

        echo ob_get_clean();
    }

}
