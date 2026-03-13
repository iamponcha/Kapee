<?php 
/**
 * Button Template
 */
?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class );?>">
	<a class="<?php echo esc_attr( $button_class );?>" href="<?php echo $link_url;?>" target="<?php echo $link_target;?>">
		<?php 
		if($button_icon && $icon_alignment == 'left'){
			echo $icon_html;
		}
		echo $text;
		if($button_icon && $icon_alignment == 'right'){
			echo $icon_html;
		}
		?>
	</a>
</div>
