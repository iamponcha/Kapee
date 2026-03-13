<?php 
/***
* Progress bar template
**/
?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
	<?php if( ! empty( $title ) ) { ?>
		<div class="section-heading">
			<h2><?php echo esc_html($title); ?></h2>
		</div>
	<?php }?>
	
	<div class="progress-wrap">
		<?php
		$barNum = 0;
		foreach($bar_items as $bar_item){
			if(empty($bar_item)){ continue;}
			//var_dump($bar_item);
			$bar_id = 'bar-'.$barNum.'-'.uniqid();
			$barNum++;
			$style  ='';
			$style .=  'background-color : '.$bar_item['bar_color'].';';
			
			$inline_style = '#'.$bar_id.' .progress-bar{'.$style.'}';
			$bar_attributes = array();
			$bar_attributes[] = 'class="progress-bar'.esc_attr($stripe_class).'"';
			$bar_attributes[] = 'role="progressbar"';
			if(isset($bar_item['bar_value'])){
			$bar_attributes[] = 'data-value="'.$bar_item['bar_value'].'"';
			$bar_attributes[] = 'aria-valuenow="'.$bar_item['bar_value'].'"';
			}
			$bar_attributes[] = 'aria-valuemin="0"';
			$bar_attributes[] = 'aria-valuemax="100"'; ?>

			<div id="<?php echo esc_attr($bar_id);?>" class="progress">
				<div <?php echo implode(' ',$bar_attributes)?>>
					<span class="bar-label"><?php if(isset($bar_item['bar_label']))echo $bar_item['bar_label'];?></span>
					<span class="bar-value"><?php if(isset($bar_item['bar_value'])) echo $bar_item['bar_value'].$units;?></span>
				</div>
				<style>
				<?php echo $inline_style;?>
				</style>
			</div>
		<?php } ?>
	</div>
</div>