<?php 
/**
 * Counter Template
 */
?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
	<div class="counter-wrap">
		<div class="counter-icon-wrap">
			<?php if( ! empty( $icon_html ) ){ ?>
				<div class="counter-icon"><?php echo wp_kses_post($icon_html);?></div>
			<?php } ?>
		</div>
		<div class="counter-info">			
			<?php if( ! empty( $counter_value ) ){ ?>
				<div class="counter-number">
					<?php if( ! empty( $counter_prefix ) ){?>
						<span class="counter-prefix"><?php echo esc_html($counter_prefix);?></span>
					<?php } ?>					
					<span class="counter"><?php echo wp_kses_post($counter_value);?> </span>
					<?php if( ! empty($counter_suffix ) ){?>
						<span class="counter-suffix"><?php echo esc_html($counter_suffix);?></span>
					<?php } ?>
				</div>
			<?php } ?>
			<?php if( ! empty( $counter_title ) ){ ?>
				<div class="counter-title"><?php echo wp_kses_post($counter_title);?></div>
			<?php } ?>
		</div>
	</div>
</div>