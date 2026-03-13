<?php 
 /**
 * Team Member : Image Top With Info Box 2 Template
 */

 $style  ='';
if( ! empty ( $hover_bg_color ) ) {
	$style_css = 'background-color : '.$hover_bg_color.' !important;' ;
	$style = '#'.$id.'.kapee-team-member:hover .member-info{'.$style_css.'}';
}?>
<div id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr($class);?>">
	<div class="team-member">
		<div class="member-avatar">
			<?php echo ($image);?>
		</div>		
		<div class="member-info" <?php echo $member_info_css;?>>
			<div class="member-designation"><?php echo esc_attr($designation);?></div>
			<h3 class="member-name"><?php echo esc_attr($name);?></h3>
			<div class="member-description"><?php echo wp_kses_post($description);?></div>
			<?php if( !empty( $team_social_data ) ){ ?>
				<div class="member-social">
					<?php foreach( $team_social_data as $social_data ){ ?>
							<a class="team-icon <?php echo esc_attr($social_data['class']);?>" href="<?php echo esc_url($social_data['link']);?>" target="_blank"><i class="<?php echo esc_attr($social_data['icon']);?>"></i></a>
					<?php } ?>		
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