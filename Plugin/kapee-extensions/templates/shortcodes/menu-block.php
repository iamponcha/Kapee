<?php 
/**
 * Menu Block template
 */
?>
<ul class="<?php echo esc_attr( $class ); ?>" >
	<li class="<?php echo esc_attr( $liclass ); ?>">
		<a class="nav-link" <?php echo ( $attributes ); ?>>
			<?php echo ($icon_html); ?>
			<span><?php echo esc_html( $title ); ?></span><?php echo ($label_html); ?>
		</a>
		
		<?php if( ! empty( $content ) ){ ?>
			<ul class="kapee-sub-megamenu">
				<?php echo do_shortcode( $content );?>
			</ul>
		<?php } ?>
	</li>
</ul>