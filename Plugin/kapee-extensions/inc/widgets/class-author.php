<?php
/**
 *	Kapee Widget: Author
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Author extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass = 'kapee-about-author';
        $this->widget_description = esc_html__("About the post&rsquo;s author", 'kapee-extensions');
        $this->widget_id = 'kapee-author';
        $this->widget_name = esc_html__('KP: About the post&rsquo;s author', 'kapee-extensions');
		$this->settings = array(
			'title_prefix' => array(
                'type' => 'text',
                'label' => esc_html__('Title Prefix:', 'kapee-extensions'),
				'std' => __('About','kapee-extensions'),
            ),
			'hide_title' => array(
                'type' 	=> 'checkbox',
                'label' => esc_html__('Hide Widget Title?', 'kapee-extensions'),
                'std' 	=> false,
            ),
            'message' => array(
                'type' 	=> 'hint',
                'label' => esc_html__('This Widget appears in the single post page only.', 'kapee-extensions'),
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

        
		if ( ! is_single() ){
			return;
		}
		
		$hide_title 	= (!empty($instance['hide_title'])) ? (bool) $instance['hide_title'] : false;
		$title_prefix = (isset($instance['title_prefix']) && !empty($instance['title_prefix']) )? $instance['title_prefix'] : ''; 
		$instance['title'] =  $title_prefix.' '.get_the_author();
		echo ( $args['before_widget'] );

		if ( !$hide_title ){
			echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
		}
		do_action( 'kapee_before_author_widget');
		kapee_author_box();
		do_action( 'kapee_after_author_widget');
		echo ( $args['after_widget'] );
    }

}
