<?php 
/***
* Contact Form template
**/
?>
<div class="<?php echo esc_attr($class);?>">
	<?php if(!empty($title)) { ?>
	<h3> <?php echo $title; ?> </h3>
	<?php } 
	if( ! empty( $description ) ){ ?>
		<div class="form-description">
			<?php echo do_shortcode( $description ) ?>
		</div>
		<?php
	}
	echo do_shortcode('[contact-form-7 id="'.$id.'"]');
	?>
</div>