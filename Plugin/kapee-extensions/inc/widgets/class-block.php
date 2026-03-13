<?php
/**
 *	Kapee Widget: Block
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Block extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-block';
        $this->widget_description 	= esc_html__("Add block.", 'kapee-extensions');
        $this->widget_id 			= 'kapee-block';
        $this->widget_name 			= esc_html__('KP: Block', 'kapee-extensions');
		$this->blocks				= kapee_get_posts_dropdown('block');
		
		$this->settings = array(
            'title' => array(
                'type' 	=> 'text',
                'label' => esc_html__('Title:', 'kapee-extensions'),
				'std' 	=> __('Block','kapee-extensions'),
            ),
			'hide_title' => array(
                'type' 	=> 'checkbox',
                'label' => esc_html__('Hide Title?', 'kapee-extensions'),
				'std' 	=> true,
            ),
			'block_id' => array(
                'type' 		=> 'select',
                'label' 	=> esc_html__('Select Block:', 'kapee-extensions'),
                'options' 	=> $this->blocks,
                'std' 		=> 'thumbnail',
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
		
		do_action( 'kapee_before_block');

		$block_id =$instance['block_id'];
		echo kapee_block_shortcode( array( 'id' => $block_id ) );
		
		do_action( 'kapee_after_block');

		$this->widget_end($args);

        echo ob_get_clean();
    }

}
