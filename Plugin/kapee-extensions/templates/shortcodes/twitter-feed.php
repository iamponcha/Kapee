<?php 
/**
 * Twitter Feed template
 */
?>
<div class="<?php echo esc_attr($class);?>">
	<?php if( ! empty( $title  ) ) { ?>
		<div class="section-heading">
			<h2><?php echo esc_html($title); ?></h2>
		</div>
	<?php } 
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
		<?php 
	} ?>
</div>