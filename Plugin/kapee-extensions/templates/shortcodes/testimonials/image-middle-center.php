<?php 
/**
 * Testimonial item
 */
?>

<div class="testimonial">
	<div class="testimonial-wrap">		
		<div class="testimonial-content">
			<div class="testimonial-description">
				<?php echo wp_kses_post($description);?>
			</div>
			<div class="testimonial-avatar">
				<?php echo ($image);?>
			</div>
			<div class="testimonial-meta">
				<div class="testimonial-name"><?php echo esc_html($name);?></div>
				<?php if( ! empty($designation)){ ?>
					<div class="testimonial-designation"><?php echo esc_html($designation);?></div>
				<?php }?>				
				<?php if( $rating > 0){ ?>
					<div class="testimonial-rating woocommerce"> 
						<div class="star-rating">
							<span style="width:<?php echo esc_html($rating);?>%"></span>
						</div>
					</div>
				<?php }?>
			</div>
		</div>
	</div>	
</div>