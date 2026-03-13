<?php 
/** 
 * Tabs Template
 */

if( empty( $sections ) && is_array( $sections ) && count( $sections ) > 0 )  return; ?>

<div id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr( $class );?>">
	<ul class="nav nav-tabs" role="tablist" <?php echo $nav_tabs_css;?>>
		<?php 
		$i 	= $sum = 0;
		$tab_ids = array();
		foreach( $sections as $section ){ 
			$icon = $content_shortcode = '';
			$i++;
			$tab_id = kapee_uniqid('kp-tab-');
			$tab_ids[$i] = $tab_id;
			
			/* Get icon from section tabs */
			$type_icon = isset( $section[ 'i_type' ] ) ? $section[ 'i_type' ] : 'fontawesome';
			$add_icon  = isset( $section[ 'add_icon' ] ) ? $section[ 'add_icon' ] : '';
			vc_icon_element_fonts_enqueue( $type_icon );
			$class_icon = kapee_get_icon_class($type_icon,$section);
			$position_icon = isset( $section[ 'i_position' ] ) ? $section[ 'i_position' ] : '';
			$tab_nav_class = array('nav-link');
			if ( $i == $active_tab ){
				$tab_nav_class[] = 'active';
				$tab_nav_class[] = 'loaded';
				
			}
			$nav_class = implode(' ',array_filter($tab_nav_class));
			$expanded 	= ( $i == $active_tab ) ? 'true' : 'false';	?>
			
			<li class="nav-item" <?php echo $nav_item_css;?>>
				<a id="nav-<?php echo esc_attr( $tab_id ); ?>" 
				class="<?php echo esc_attr( $nav_class ); ?>" 
				href="#<?php echo esc_attr( $tab_id ); ?>" 
				data-href="<?php echo esc_attr( $tab_id ); ?>" 
				data-toggle="tab" role="tab" aria-controls="<?php echo esc_attr( $tab_id ); ?>" 
				aria-selected="<?php echo esc_attr($expanded);?>">
				<?php if ( $add_icon == true && $position_icon != 'right' ) : ?>
					<i class="before-icon <?php echo esc_attr( $class_icon ); ?>"></i>
				<?php endif; ?>
				<?php echo esc_html( $section[ 'title' ] ); ?>
				<?php if ( $add_icon == true && $position_icon == 'right' ) : ?>
					<i class="after-icon <?php echo esc_attr( $class_icon ); ?>"></i>
				<?php endif; ?>
				</a>
			</li>
		<?php } ?>
	</ul>	
	<div class="tab-content">	
		<?php $i = 0;
		foreach( $sections as $section ){  
			$i++;
			$tab_id = $tab_ids[$i];
			$tab_content_class = ($i == $active_tab ) ? 'tab-pane fade show active' : 'tab-pane fade'; ?>
			
			<div class="<?php echo esc_attr($tab_content_class);?>"
				 id="<?php echo esc_attr( $tab_id ); ?>"
				 role="panel" aria-labelledby="nav-<?php echo esc_attr($tab_id );?>">
				<?php echo do_shortcode( $section[ 'content' ] ); ?>
			</div>
		<?php } ?>
	</div>	
</div>