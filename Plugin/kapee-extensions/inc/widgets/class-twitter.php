<?php
/**
 *	Kapee Widget: Twitter Feed
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kapee_Widget_Base' ) ) {
	return;
}

class Kapee_Twitter extends Kapee_Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass 		= 'kapee-twitter';
        $this->widget_description 	= esc_html__("Display twitter feed.", 'kapee-extensions');
        $this->widget_id 			= 'kapee-twitter';
        $this->widget_name 			= esc_html__('KP: Twitter', 'kapee-extensions');
		$this->settings = array(
            'title' => array(
                'type' 	=> 'text',
                'label' => esc_html__('Title:', 'kapee-extensions'),
				'std' 	=> 'Twitter Feed',
            ),
			'username' => array(
                'type' 	=> 'text',
                'label' => esc_html__('Twitter Name (without @ symbol):', 'kapee-extensions'),
				'std'	=> 'Twitter',
            ),
			'number_of_tweets' => array(
                'type' => 'text',
                'label' => esc_html__('Number Of Tweets:', 'kapee-extensions'),
				'std' => 5,
            ),
			'consumer_key' => array(
                'type' 	=> 'text',
                'label' => esc_html__('Consumer Key:', 'kapee-extensions')
            ),
			'consumer_secret_key' => array(
                'type' 	=> 'text',
                'label' => esc_html__('Consumer Secret:', 'kapee-extensions')
            ),
			'access_token' => array(
                'type' 	=> 'text',
                'label' => esc_html__('Access Token:	', 'kapee-extensions')
            ),
			'access_token_secret' => array(
                'type' 	=> 'text',
                'label' => esc_html__('Access Token Secret:', 'kapee-extensions')
            ),
			'show_avatar' => array(
                'type' 	=> 'checkbox',
                'label' => esc_html__('Show your avatar image?', 'kapee-extensions'),
                'std' 	=> false,
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
		
		do_action( 'kapee_before_twitter_widget');
		
		$username 				= (!empty($instance['username'])) ?  $instance['username'] : 'Twitter';
		$number_of_tweets		= (!empty($instance['number_of_tweets'])) ?  $instance['number_of_tweets'] : 5;
		$consumer_key 			= (!empty($instance['consumer_key'])) ?  $instance['consumer_key'] : '';
		$consumer_secret_key 	= (!empty($instance['consumer_secret_key'])) ?  $instance['consumer_secret_key'] : '';
		$access_token 			= (!empty($instance['access_token'])) ?  $instance['access_token'] : '';
		$access_token_secret 	= (!empty($instance['access_token_secret'])) ?  $instance['access_token_secret'] : '';
		$show_avatar 			= (!empty($instance['show_avatar'])) ? (bool) $instance['show_avatar'] : false;
		
		$connection = new TwitterOAuth(
			$consumer_key,   		// Consumer key
			$consumer_secret_key,   	// Consumer secret
			$access_token,   		// Access token
			$access_token_secret	// Access token secret
		);
		
		$my_tweets = $connection->get(
			'statuses/user_timeline',
			array(
				'screen_name'    => $username,
				'count'          => $number_of_tweets,
			)
		);
		$number_of_tweets = min( $number_of_tweets, count( $my_tweets ) );
		
		if( $connection->http_code == 200 ) {
			for( $i = 0; $i < $number_of_tweets; $i++ ) {
				$tweet = $my_tweets[$i];
				
				// Core info.
				$name = $tweet->user->name;
				
				// COMMUNITY REQUEST !!!!!! (2)
				$screen_name = $tweet->user->screen_name;

				$permalink = 'http://twitter.com/'. $screen_name .'/status/'. $tweet->id_str;
				$tweet_id = $tweet->id_str;

				//  Check for SSL via protocol https then display relevant image - thanks SO - this should do
				if ( isset( $_SERVER['HTTPS'] ) && ( $_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1 ) || isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) {
					$image = $tweet->user->profile_image_url_https;
				}else {
					$image = $tweet->user->profile_image_url;
				}

				// Process Tweets - Use Twitter entities for correct URL, hash and mentions
				$text = kapee_twitter_process_links( $tweet );

				// lets strip 4-byte emojis
				$text = preg_replace( '/[\xF0-\xF7][\x80-\xBF]{3}/', '', $text );

				// Need to get time in Unix format.
				$time = $tweet->created_at;
				$date_formate = date("Y/m/d", strtotime($time));
				//echo date("Y-m-d", strtotime($time));
				$time = date_parse( $time );
				$uTime = mktime( $time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year'] );
				
				//echo 'Tieme => '.$time;
				// Now make the new array.
				$tweets[] = array(
					'text' => $text,
					'name' => $name,
					'permalink' => $permalink,
					'image' => $image,
					'time' => $date_formate,
					'tweet_id' => $tweet_id
					);
					
			}
		}
		
		if( ! empty( $tweets ) ){ ?>
			<ul class="kapee-twitter-list <?php if($show_avatar) echo esc_attr( 'enable-avatar' );?>">
				<?php foreach( $tweets as $tweet ){ ?>
					<li class="twitter-item">
						<?php if( $show_avatar ){ ?>
							<div class="twitter-image">
								<img width="48px" height="48px" src="<?php echo esc_url( $tweet['image'] ); ?>" alt="<?php esc_html_e( 'Avatar', 'kapee-extensions' ); ?>">
							</div>
						<?php } ?>
						<div class="twitter-body">
							<?php echo wp_kses( $tweet['text'], array( 'a' => array('href' => true,'target' => true,'rel' => true) ) ); ?>
							<span class="tweet-meta">
								<a href="<?php echo esc_url( $tweet['permalink'] ); ?>" target="_blank">
									<?php echo $tweet['time']; ?>
								</a>
							</span>
						</div>
					</li>
				<?php } ?>
			</ul>
		<?php }
		
		do_action( 'kapee_after_twitter_widget');

		$this->widget_end($args);

        echo ob_get_clean();
    }

}
