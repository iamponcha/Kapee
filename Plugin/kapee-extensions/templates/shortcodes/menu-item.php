<?php 
/***
* Menu Block template
**/
?>
<li class="<?php echo esc_attr( $class ); ?>">
	<a class="nav-link" <?php echo ( $attributes ); ?>>
		<?php echo ($icon_html); ?>
		<span><?php echo esc_html( $title ); ?></span><?php echo ($label_html); ?>
	</a>
</li>