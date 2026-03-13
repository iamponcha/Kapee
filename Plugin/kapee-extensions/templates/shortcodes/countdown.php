<?php 
/**
 * Countdown template
 */

?>
<div  id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
	<div class="product-countdown" 
	data-end-date="<?php echo esc_attr( date('Y-m-d H:i:s', $date ) );?>" 
	data-timezone="<?php echo esc_attr( $timezone );?>" 
	data-countdown-style="<?php echo esc_attr( $countdown_style );?>"></div>
</div>