<?php
/**
 *	Kapee Widget: Contact Us
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Contact_Us extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-contact-us';
        $this->widget_description 	= esc_html__("Add Contact info.", 'kapee-extensions');
        $this->widget_id 			= 'kapee-contact-us';
        $this->widget_name 			= esc_html__('KP: Contact Us', 'kapee-extensions');
		$this->image_sizes 			= kapee_get_all_image_sizes(true);
        array_shift($this->image_sizes);
		
		$this->settings = array(
            'title' => array(
                'type' => 'text',
                'label' => esc_html__('Title:', 'kapee-extensions'),
				'std' => __('Contact Us','kapee-extensions'),
            ),
			'hide_title' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Hide Title?', 'kapee-extensions'),
				'std' => true,
            ),
			'logo' => array(
                'type' => 'image',
                'label' => esc_html__('Upload Logo:', 'kapee-extensions'),                
            ),
			'logo_size' => array(
                'type' => 'select',
                'label' => esc_html__('Logo Size:', 'kapee-extensions'),
                'options' => $this->image_sizes,
                'std' => 'full',
            ),	
			'our_site_url' => array(
                'type' => 'text',
                'label' => esc_html__('Site Url:', 'kapee-extensions'),
            ),
			'about_tagline' => array(
                'type' => 'textarea',
                'label' => esc_html__('About Tagline:', 'kapee-extensions')
            ),
			'address' => array(
                'type' => 'text',
                'label' => esc_html__('Address:', 'kapee-extensions'),
            ),
			'phone_number' => array(
                'type' => 'text',
                'label' => esc_html__('Phone Number:', 'kapee-extensions'),
            ),
			'fax_number' => array(
                'type' => 'text',
                'label' => esc_html__('Fax Number:', 'kapee-extensions'),
            ),
			'email_address' => array(
                'type' => 'text',
                'label' => esc_html__('Email:', 'kapee-extensions'),
            ),
			'website' => array(
                'type' => 'text',
                'label' => esc_html__('Website:', 'kapee-extensions'),
            ),
			'days_hours' => array(
                'type' => 'text',
                'label' => esc_html__('Working Days/Hours:', 'kapee-extensions'),
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
		
		do_action( 'kapee_before_contact_us');
		//kapee_pre($instance);
		$logo 			= (!empty($instance['logo'])) ?  $instance['logo'] : '';
		$logo 			= apply_filters('kapee_widget_contact_us_logo', $logo );
		$logo_size 		= (!empty($instance['logo_size'])) ? esc_attr($instance['logo_size']) : 'thumbnail';	
		$logo_url 		= ($logo) ?  kapee_get_image_src( $logo,$logo_size) : '';
		$our_site_url 	= (!empty($instance['our_site_url'])) ?  $instance['our_site_url'] : '#';
		$about_tagline 	= apply_filters('about_tagline', empty($instance['about_tagline']) ? false : $instance['about_tagline']);
		$address 		= (!empty($instance['address'])) ?  $instance['address'] : '';
		$phone_number 	= (!empty($instance['phone_number'])) ?  $instance['phone_number'] : '';
		$fax_number 	= (!empty($instance['fax_number'])) ?  $instance['fax_number'] : '';
		$email_address 	= (!empty($instance['email_address'])) ?  $instance['email_address'] : '';
		$website 		= (!empty($instance['website'])) ?  $instance['website'] : '';
		$days_hours 	= (!empty($instance['days_hours'])) ?  $instance['days_hours'] : '';
		
		$html='<div class="contact-us-widget">';
		
		if($logo_url != '')
			$html.='<p class="contact-logo"><a href="'.esc_url($our_site_url) .'"><img src="'. esc_url($logo_url) .'" alt="logo" /></a></p>';			
		
		if($about_tagline != '')
			$html.='<p>'. esc_attr($about_tagline) .'</p>';			
		
		$html.='<ul class="contact-us">';
			if($address != '')
				$html.='<li><i class="pls-home"></i><span>'. esc_attr($address) .'</span></li>';				
			
			if($phone_number != '')
				$html.='<li><i class="pls-phone"></i><span>'. esc_attr($phone_number) .'</span></li>';
			
			if($fax_number != '')
				$html.='<li><i class="pls-printer"></i><span>'. esc_attr($fax_number) .'</span></li>';
			
			if($email_address != ''):
				$html.='<li><i class="pls-envelope"></i><span>';
				if(is_email($email_address)){
					$html.='<a href="mailto:'. esc_attr($email_address).' ">'.esc_attr($email_address) .'</a>';
				}else{
					esc_html_e("Invalid Email Address",'kapee-extensions');
				}
				$html.='</span>';
				$html.='</li>';
			endif;
			
			if($website != '')
				$html.='<li><i class="pls-worldwide"></i><span><a href="'.esc_url($website) .'">'.  $website .'</a></span></li>';
			
			if($days_hours != '')
				$html.='<li><i class="pls-clock"></i><span>'. esc_attr($days_hours) .'</span></li>';

		$html.='</ul>';
		$html.='</div>';
		
		echo $html;

		do_action( 'kapee_after_contact_us');

		$this->widget_end($args);

        echo ob_get_clean();
    }

}
