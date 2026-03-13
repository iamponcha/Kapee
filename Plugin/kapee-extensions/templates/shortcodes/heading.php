<?php 
/**
 * Heading Template
 */
?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">	
	<?php if( ! empty( $sub_title ) ){ ?>
		<div class="heading-subtitle"> <?php echo $sub_title;?> </div>
	<?php } ?>
		
	<?php if( ! empty( $title ) ){ ?>
		<div class="heading-wrap">
			<span class="separator-left"></span>
			<?php echo $title;?>
			<span class="separator-right<?php echo esc_attr( $separator_class );?>"></span>
			<?php if( ! empty( $separator_image_src ) ){ ?>
				<span class="image-separator"> 
					<img src="<?php echo esc_url($separator_image_src)?>" alt=""/>
				</span>
			<?php } ?>
		</div>
	<?php } ?>
	
    <?php if( ! empty( $tagline ) ){ ?>
		<div class="heading-tagline"> <?php echo $tagline;?> </div>
	<?php } ?>
</div>