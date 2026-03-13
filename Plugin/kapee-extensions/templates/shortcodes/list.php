<?php 
/*
 * List template
 */
?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
	<ul>
		<?php foreach ( $list_items as $item ): ?>
			<li>
				<?php
				$link_attributes = isset($item['item_link']) ? kapee_get_link_attributes($item['item_link']) : '';
				if( $list_type != 'none' ) {?>
					<span class="list-icon">
						<?php if( ! empty( $icon_html ) ) {
							echo wp_kses_post( $icon_html ); 
						}?>
					</span>
				<?php }
				if( empty( $link_attributes ) ){ ?>
					<span class="list-content"><?php echo esc_html( $item['item_content'] ); ?></span>
				<?php }else{ ?>
					<span class="list-content"><a <?php echo $link_attributes;?>> <?php echo esc_html( $item['item_content'] ); ?></a></span>
				<?php } ?>
			</li>
		<?php endforeach ?>
	</ul>
</div>