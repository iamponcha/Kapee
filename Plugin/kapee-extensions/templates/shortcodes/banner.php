<?php 
/**
 * Banner Template
 */
?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class );?>">
	<div class="banner-wrapper" <?php echo $link_on_box_title;?>>
		<?php if( ! empty( $image_src ) ){ ?>
			<div class="banner-image-wrap">			
				<div class="banner-image">
					<img src="<?php echo esc_url( $image_src );?>" alt="">
				</div>			
			</div>
		<?php } ?>
		<?php if( ! empty( $title ) || ! empty( $subtitle ) || ! empty( $content ) || ! empty( $button_text ) ) { ?>
			<div class="banner-content-wrap <?php echo esc_attr( $content_class ); ?>">
				<div class="banner-content">
					<?php if(! empty( $subtitle ) ) { ?>
						<div class="banner-subtitle-wrap">
							<span class="banner-subtitle"><?php echo $subtitle; ?></span>
						</div>
					<?php }
					if(! empty( $title ) ) { ?>
					<div class="banner-title-wrap">
						<h3 class="banner-title"> <?php echo $title; ?></h3>
					</div>				
					<?php }					
					if(! empty( $content ) ) { ?>
						<div class="banner-content-text">
							<?php echo do_shortcode($content); ?>
						</div>
					<?php }
					if(! empty( $button_text ) ) { ?>
						<div class="banner-button kapee-button">
							<a href="<?php echo $link_url;?>" target="<?php echo esc_attr($link_target);?>" class="<?php echo esc_attr( $button_class );?>"><?php echo $button_text;?></a>
						</div>
					<?php } ?>
				</div>
				
			</div>
		<?php } ?>
	</div>
</div>
