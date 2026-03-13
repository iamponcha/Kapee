<?php 
/**
 * Info Box Template
 */
 
$style  ='';
if( ! empty ( $box_bg_hover_color ) ) {
	$style_css = 'background-color : '.$box_bg_hover_color.'!important;' ;
	$style = '#'.$id.'.kapee-info-box:hover{'.$style_css.'}';
}?>
<div id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr($class);?>">
	<div class="info-box-wrap" <?php echo $link_on_complete_box; ?> >
		<div class="box-icon-wrap">
			<?php if( ! empty( $icon_html ) ){ ?>
				<div class="info-box-icon"><?php echo wp_kses_post($icon_html);?></div>
			<?php } ?>
		</div>
		<div class="info-box-content">			
			<?php if( ! empty( $box_title ) ){ ?>
				<div class="info-box-title mb" <?php echo $link_on_box_title;?>>				
					<?php echo '<'.$title_tag.'>'.wp_kses_post($box_title).'</'.$title_tag.'>';?>					
				</div>
			<?php } ?>
			<?php if( ! empty( $description ) ){ ?>
				<div class="info-box-description mb">
					<p><?php echo wp_kses_post($description);?></p>
				</div>
			<?php } 
			if( $apply_to_link == 'display_read_more' && !empty( $read_more_text ) ) { ?>
				<div class="info-box-btn">
					<a href="<?php echo $link_url;?>" target="<?php echo esc_attr($link_target);?>"><?php echo $read_more_text;?></a>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php if( $style != ''){ ?>
		<style>
			<?php echo $style;?>
		</style>
	<?php }?>
</div>