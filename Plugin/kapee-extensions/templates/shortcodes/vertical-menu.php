<?php 
/**
 * Categories Menu
 **/
?>
<div class="<?php echo esc_attr($class);?>">
	<div class="categories-menu-wrapper">
		<div class="categories-menu-title">
			<span class="title"><?php echo $title;?></span>
		</div>
		<?php if ( has_nav_menu( 'categories-menu' ) ) {
			wp_nav_menu( 
				array( 
					'theme_location' 	=> 'categories-menu',
					'container_class'   => 'categories-menu kapee-navigation',
					'walker' 			=> new Kapee_Mega_Menu_Walker()
				)
			); 
		}?>
	</div>
</div>