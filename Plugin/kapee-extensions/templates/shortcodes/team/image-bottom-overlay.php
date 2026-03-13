<?php 
 /**
 * Team Member : Image Bottom With Overlay Template
 */

$style  ='';
if( ! empty ( $bg_color ) ) {
	$style_css = 'background-color : '.$bg_color.' !important;' ;
	$style = '#'.$id.'.kapee-team-member .member-info::before, #'.$id.'.kapee-team-member .member-info::after {'.$style_css.'}';
}?>
<div id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr($class);?>">
	<div class="team-member">
		<div class="member-avatar">
			<?php echo ($image);?>
		</div>		
		<div class="member-info">
			<div class="overlay">
				<h3 class="member-name"><?php echo esc_attr($name);?></h3>
				<div class="member-designation"><?php echo esc_attr($designation);?></div>
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
</div>