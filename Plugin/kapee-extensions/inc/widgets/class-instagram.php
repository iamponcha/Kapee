<?php
/**
 *	Kapee Widget: Instagram
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Instagram extends Kapee_Widget_Base {
	public $access_token,$new_refresh_token,$option_name = 'kapee_instagram_access_token';
	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-instagram';
        $this->widget_description 	= esc_html__("Display instagram images.", 'kapee-extensions');
        $this->widget_id 			= 'kapee-instagram';
        $this->widget_name 			= esc_html__('KP: Instagram', 'kapee-extensions');
		$this->settings = array(
            'title' => array(
                'type' 	=> 'text',
                'label' => esc_html__('Title:', 'kapee-extensions'),
                'std' 	=> esc_html__('Instagram', 'kapee-extensions'),
            ),
			'hide_title' => array(
                'type' 	=> 'checkbox',
                'label' => esc_html__('Hide Widget Title?', 'kapee-extensions'),
                'std' 	=> false,
            ),
			'access_token' => array(
                'type' 	=> 'text',
                'label' => esc_html__('Access Token:', 'kapee-extensions'),
                'std' 	=> '',
            ),
			'number_of_photos' => array(
                'type' 	=> 'number',
                'label' => esc_html__('Number Of Photos:', 'kapee-extensions'),
				'std' 	=> 9,
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
		
		do_action( 'kapee_before_instagram_widget');		
		
		$number_of_photos 	= (!empty($instance['number_of_photos'])) ?  $instance['number_of_photos'] : 9;
		$num 				= $number_of_photos;
		
		$this->access_token 	= (!empty($instance['access_token'])) ?  $instance['access_token'] : '';
		$refresh_token = $this->refresh_access_token();
		
		if( is_wp_error( $refresh_token ) ){
			echo esc_html( $refresh_token->get_error_message() );
			$this->access_token = '';
			return;
		}
		
		if( !empty( $this->access_token ) ){
			$instagram_data = $this->instagram_media( $num );
			if( is_wp_error( $instagram_data ) ){
				echo esc_html( $instagram_data->get_error_message() );
			}
		}
		if( is_wp_error( $instagram_data )|| empty( $instagram_data ) ){
			return;
		}?>
		
		<div class="kapee-instagram-widget">
			<?php foreach( $instagram_data as $item ){	
				$image_url 		= $item['image_url']; ?>	
				<div class="instagram-picture-wrap">
					<div class="instagram-picture">
						<a href="<?php echo esc_url( $item['image_link'] ); ?>" target="_blank"></a>
						<?php echo kapee_get_src_image_loaded($image_url);?>
					</div>
				</div>		
			<?php } ?>	
		</div>
		<?php
		do_action( 'kapee_after_instagram_widget');

		$this->widget_end($args);

        echo ob_get_clean();
    }
	
	public function instagram_media( $limit = 10 ){
		
		$transient_key = 'kapee_'.sanitize_title_with_dashes($this->access_token).'_'.$limit;
		
		$stored_transient 	= get_transient( $transient_key ); // Getting cache value
		$stored_transient	= !empty($stored_transient) ? json_decode($stored_transient, true) : false;
		if ( false === $stored_transient ) {
			$args = [
				'fields'       => 'id,caption,media_type,media_url,permalink,thumbnail_url,username',
				'limit'		=> $limit,
				'access_token' => $this->access_token,
			];
			$result_data = array();
			$url = add_query_arg( $args, 'https://graph.instagram.com/me/media' );

			$response = wp_remote_get( $url );
			
			$response = wp_remote_retrieve_body( $response );		
			$response   = json_decode( $response, true );
			
			if( !is_array($response) ){
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram has returned invalid data.', 'kapee-extensions' ) );
			}
			
			if( isset($response['error']['message']) ){
				return new WP_Error( 'error_response', $response['error']['message'] );
			}
			
			foreach ( $response['data'] as $media ) {
				$result_data[] = array(
					'username'    => $media['username'],
					'type'    => $media['media_type'],
					'caption' => isset( $media['caption'] ) ? $media['caption'] : $media['id'],
					'image_link'    => $media['permalink'],
					'image_url'  => strtolower( $media['media_type'] ) == 'video' ? $media['thumbnail_url'] : $media['media_url'],
				);
			}
			set_transient( $transient_key, json_encode($result_data), apply_filters( 'kapee_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
		}else{
			$result_data = $stored_transient;
		}
		if ( ! empty( $result_data ) ) {
			return array_slice( $result_data, 0, $limit );
		} else {
			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'kapee-extensions' ) );
		}
	}
	public function refresh_access_token(){
		$token_data = array();
		$generate_new_taken = true;
		$access_token = get_option( $this->option_name, [] );
		
		if ( !empty( $access_token ) && isset($access_token[$this->access_token]) ) {
			if( isset( $access_token[$this->access_token]['timestamp'] ) && 
			 $access_token[$this->access_token]['timestamp'] > time() ){
				$generate_new_taken = false;
			}
			$this->access_token = $access_token[$this->access_token]['refreshed_token'];			
		}
		
		if($generate_new_taken){
			$args = [
				'grant_type' => 'ig_refresh_token',
				'access_token'  => $this->access_token
			];
			$url = add_query_arg( $args, 'https://graph.instagram.com/refresh_access_token' );
			$response 	= wp_remote_get( $url );
			$data 		= wp_remote_retrieve_body( $response );			
			$data = json_decode( $data, true );			
			if( isset($data['access_token']) ){
				$token_data[$this->access_token]['refreshed_token'] = $data['access_token'];
				$token_data[$this->access_token]['timestamp'] = time() + MONTH_IN_SECONDS;
				if(!empty($access_token)){
					$token_data = array_merge($access_token, $token_data);
				}
				update_option($this->option_name, $token_data);
				$this->access_token = $data['access_token'];
				return true;
			}else{
				return new WP_Error( 'access_token_refresh', esc_html__( "can't refresh token. Please check your access key.", 'kapee-extensions' ) );
			}
		}		
	}

}