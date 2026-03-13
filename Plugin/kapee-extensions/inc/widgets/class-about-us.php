<?php
/**
 *	Kapee Widget: About Us
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_About_Us extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-about-us';
        $this->widget_description 	= esc_html__("Small information about site. ", 'kapee-extensions');
        $this->widget_id 			= 'kapee-about-us';
        $this->widget_name 			= esc_html__('KP: About Us', 'kapee-extensions');
		$this->image_sizes 			= kapee_get_all_image_sizes(true);
        array_shift($this->image_sizes);
		
		$this->settings = array(
            'title' => array(
                'type' => 'text',
                'label' => esc_html__('Title:', 'kapee-extensions'),
				'std' => __('About Us','kapee-extensions'),
            ),
			'logo' => array(
                'type' => 'image',
                'label' => esc_html__('Upload Logo:', 'kapee-extensions'),                
            ),
			'logo_size' => array(
                'type' => 'select',
                'label' => esc_html__('Logo Size:', 'kapee-extensions'),
                'options' => $this->image_sizes,
                'std' => 'thumbnail',
            ),
			'circle' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Circle Shape?', 'kapee-extensions'),
				'std' => false,
            ),
			'text' => array(
                'type' => 'textarea',
                'label' => esc_html__('Text', 'kapee-extensions')
            ),
			'center' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Center the content?', 'kapee-extensions'),
				'std' => false,
            ),			
			'show_social' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Show Social Icons?', 'kapee-extensions'),
				'std' => false,
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
                'std' => 'icons-default',
            ),
			'social_shape' => array(
                'type' => 'select',
                'label' => esc_html__('Icons Shape:', 'kapee-extensions'),
                'options' => array(
                    'icons-shape-circle' => esc_html__('Circle','kapee-extensions'),
					'icons-shape-square' => esc_html__('Square','kapee-extensions'),										
                ),
                'std' => 'icons-shape-circle',
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
		
		$this->widget_start($args, $instance);
		
		do_action( 'kapee_before_about_us');
		
		$logo 				= (!empty($instance['logo'])) ?  $instance['logo'] : '';
		$logo_size 			= ($instance['logo_size']) ? esc_attr($instance['logo_size']) : 'thumbnail';	
		$logo_url 			= ($logo) ?  kapee_get_image_src( $logo,$logo_size) : '';
		$text 				= (!empty($instance['text'])) ?  $instance['text'] : '';
		$social_Style 		= (!empty($instance['social_Style'])) ?  $instance['social_Style'] : 'icons-default';
		$social_shape 		= (!empty($instance['social_shape'])) ?  $instance['social_shape'] : 'icons-shape-circle';
		$social_icon_size 	= (!empty($instance['social_icon_size'])) ?  $instance['social_icon_size'] : 'icons-size-small';
		
		$custom_class = 'about-us-widget';		
		$custom_class .= $instance['center'] ? ' text-center' : '';		
		$custom_class .= $instance['circle'] ? ' image-is-circle' : '';
		
		$img_class 	= 'about-us-img';
				
		echo '<div class="'.esc_attr($custom_class).'">';
		
		if($logo_url != '')
			echo '<img src="'. esc_url($logo_url) .'" class="'.$img_class.'" alt="'.esc_html__('About us image', 'kapee-extensions').'" />';			
		
		if($text != '')
			echo '<div class="about-us-widget-content">'.do_shortcode($text).'</div>';			
		
		if($instance['show_social']){
			kapee_social_share(array('type'=>'profile','style' =>$social_Style,'shape'=> $social_shape,'size' => $social_icon_size ));
		}
		
		echo '</div>';
		
		

		do_action( 'kapee_after_about_us');

		$this->widget_end($args);

        echo ob_get_clean();
    }

}
