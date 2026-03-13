<?php 
/***
* Icon Box template
**/
?>
<div class="<?php echo esc_attr($class);?>">	
	<div class="video-wrapper">
		<a class="kapee-video-popup" href="<?php echo esc_url($video_url);?>">
			<img src="<?php echo esc_url($image_placeholder_src);?>" alt="<?php esc_html_e('Video','kapee-extensions');?>">
			<span class="video-play-btn-holder">
				<span class="video-play-btn"></span>
			</span>
		</a>
	</div>
</div>