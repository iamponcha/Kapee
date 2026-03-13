<?php
/**
 *	Kapee Widget: Social Links
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Social_Links extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-social-link';
        $this->widget_description 	= __("Display social links.", 'kapee-extensions');
        $this->widget_id 			= 'kapee-social-links';
        $this->widget_name 			= __('KP: Social Links', 'kapee-extensions');
		$this->settings = array(
            'title' => array(
                'type' 	=> 'text',
                'label' => __('Title:', 'kapee-extensions'),
				'std' => __('Social', 'kapee-extensions'),
            ),
			'hide_title' => array(
                'type' 	=> 'checkbox',
                'label' => __('Hide Widget Title?', 'kapee-extensions'),
                'std' 	=> true,
            ),
			'social_Style' => array(
                'type' => 'select',
                'label' => esc_html__('Icons Style:', 'kapee-extensions'),
                'options' => array(
					'icons-default' 		=> esc_html__('Default','kapee-extensions'),					
                    'icons-colour' 			=> esc_html__('Colour','kapee-extensions'),
                    'icons-bordered' 		=> esc_html__('Bordered','kapee-extensions'),
					'icons-fill-colour'		=> esc_html__('Fill Colour','kapee-extensions'),
					'icons-theme-colour'	=> esc_html__('Theme Colour','kapee-extensions'),
										
                ),
                'std' => 'icons-fill-colour',
            ),
			'social_shape' => array(
                'type' => 'select',
                'label' => esc_html__('Icons Shape:', 'kapee-extensions'),
                'options' => array(
                    'icons-shape-circle' => esc_html__('Circle','kapee-extensions'),
					'icons-shape-square' => esc_html__('Square','kapee-extensions'),										
                ),
                'std' => 'icons-shape-square',
            ),
			'social_icon_size' => array(
                'type' => 'select',
                'label' => esc_html__('Icons Size:', 'kapee-extensions'),
                'options' => array(
                    'icons-size-default'=> esc_html__('Default','kapee-extensions'),
					'icons-size-small' 	=> esc_html__('Small','kapee-extensions'),
					'icons-size-large' 	=> esc_html__('Large','kapee-extensions'),
                ),
                'std' => 'icons-size-small',
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
		
		$hide_title = (!empty($instance['hide_title'])) ? (bool) $instance['hide_title'] : false;
		if($hide_title) unset($instance['title']);
		
		$this->widget_start($args, $instance);
		
		do_action( 'kapee_before_social_links');
		
		$social_Style 		= (!empty($instance['social_Style'])) ?  $instance['social_Style'] : 'icons-fill-colour';
		$social_shape 		= (!empty($instance['social_shape'])) ?  $instance['social_shape'] : 'icons-shape-square';
		$social_icon_size 	= (!empty($instance['social_icon_size'])) ?  $instance['social_icon_size'] : 'icons-size-small';
		
		
		?>
		<div class="kapee-social-links-widget">
		
			<?php //Get Social link
			if ( function_exists( 'kapee_social_share' ) ){
				kapee_social_share(array('type'=>'profile','style' =>$social_Style,'shape'=> $social_shape,'size' => $social_icon_size ));
			}?>
		</div>
		<?php
		do_action( 'kapee_after_social_links');

		$this->widget_end($args);

        echo ob_get_clean();
    }

}