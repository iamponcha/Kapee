<?php
/**
 *	Kapee Widget: Newsletter
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Newsletter extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-newsletter';
        $this->widget_description 	= __("Display newsletter form.", 'kapee-extensions');
        $this->widget_id 			= 'kapee-newsletter';
        $this->widget_name 			= __('KP: Newsletter', 'kapee-extensions');
		$this->settings = array(
            
			'title' => array(
                'type' 	=> 'text',
                'label' => __('Title', 'kapee-extensions'),
                'std' 	=> __('Newsletter','kapee-extensions'),
            ),
			'newsletter_tagline' => array(
                'type' 				=> 'textarea',
                'label' 			=> __('Newsletter Tagline', 'kapee-extensions'),
				'allow_esc_html'	=> false,
                'std' 				=> 'Subscribe to our mailing list to get the new updates!',
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

        $this->widget_start($args, $instance);
		do_action( 'kapee_before_newsletter');
		
		$newsletter_tagline = apply_filters('newsletter_tagline', empty($instance['newsletter_tagline']) ? false : $instance['newsletter_tagline']);
		
		?>
		<div class="kapee-newsletter-widget">
			<?php 
			# Text
			if( ! empty( $newsletter_tagline ) ){ ?>
				<div class="subscribe-tagline">
					<?php echo do_shortcode( $newsletter_tagline ) ?>
				</div>
				<?php
			}
			 if( function_exists( 'mc4wp_show_form' ) ) {
				mc4wp_show_form();
			} ?>
		</div>
		
		<?php		
		do_action( 'kapee_after_newsletter');
		
		$this->widget_end($args);
		
        echo ob_get_clean();
    }

}