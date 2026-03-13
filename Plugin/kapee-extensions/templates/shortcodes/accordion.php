<?php 
/** 
 * Accordion Template
 */

if( empty( $sections ) && is_array( $sections ) && count( $sections ) > 0 )  return; ?>

<div id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr( $class );?>">
	
	<?php $i = 0;
	foreach( $sections as $section ) {
		
		$i++;
		$tab_id = kapee_uniqid('kp-accordions-');
		$type_icon = isset( $section[ 'i_type' ] ) ? $section[ 'i_type' ] : 'fontawesome';
		$add_icon  = isset( $section[ 'add_icon' ] ) ? $section[ 'add_icon' ] : '';
		vc_icon_element_fonts_enqueue( $type_icon );
		$class_icon = kapee_get_icon_class($type_icon,$section);
		$position_icon = isset( $section[ 'i_position' ] ) ? $section[ 'i_position' ] : 'left';
		$icon = '';
		
		if ( $add_icon == true ) {
			$icon = '<i class="' . esc_attr( $class_icon ) .' icon-'.$position_icon.'"></i>';
		} ?>
		
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">					
					<a class="card-link <?php echo ( $i != $active_tab ) ? 'collapsed' : '';?>" data-toggle="collapse" href="#<?php echo esc_attr( $tab_id ); ?>">
						<?php echo ( $add_icon == true && $position_icon != 'right' ) ? balanceTags( $icon ) : ''; ?>
						<?php echo esc_html( $section[ 'title' ] ); ?>
						<?php echo ( $add_icon == true && $position_icon == 'right' ) ? balanceTags( $icon ) : ''; ?>
					</a>					
				</h4>
			</div>
			<div id="<?php echo esc_attr( $tab_id ); ?>" class="collapse <?php echo ( $i == $active_tab ) ? 'show' : '';?>" <?php echo $data_parent;?>>
				<div class="card-body">
					<?php echo do_shortcode( $section[ 'content' ] ); ?>
				</div>
			</div>
		</div>
	<?php } ?>
</div>