<?php 
/***
* Products Tabs Template
**/

if( empty( $tabs ) )  return; ?>

<div id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr( $class );?>">
	
	<div class="nav-tabs-wrapper">
		<ul class="nav nav-tabs">
			<?php $i = 1;
			foreach($tabs as $tab_data){ 
				
				$class 		= ($i == 1) ? 'nav-link active' : 'nav-link';
				$expanded 	= ($i == 1) ? 'true' : 'false';
				$ajax_tab 	= 1;?>
				<li class="nav-item">
					<a id="nav-<?php echo esc_html($tab_data['id']);?>" class="<?php echo esc_attr($class);?>" href="#<?php echo esc_html($tab_data['id']);?>" data-href="<?php echo esc_html($tab_data['id']);?>" data-toggle="tab" aria-controls="<?php echo esc_html($tab_data['id']);?>" aria-selected="<?php echo esc_attr($expanded);?>"><?php echo esc_html($tab_data['title']);?></a>
				</li>
				<?php 
				$i++;
			}?>
		</ul>
	</div>
	
	<div class="tab-content woocommerce">
	
		<?php $i = 1;
		//$number_of_row = 2;
		
		foreach( $tabs as $tab_data ){
			kapee_set_loop_prop('name','kapee-carousel');
			kapee_set_loop_prop('products_view','grid-view');			
			kapee_set_loop_prop('products-columns',$rs_extra_large);
			kapee_set_loop_prop('rs_extra_large',$rs_extra_large);
			kapee_set_loop_prop('rs_large',$rs_large);
			kapee_set_loop_prop('rs_medium',$rs_medium);
			kapee_set_loop_prop('rs_small',$rs_small);
			kapee_set_loop_prop('rs_extra_small',$rs_extra_small);
			$unique_id 	= kapee_uniqid('section-');
			kapee_set_loop_prop('unique_id',$unique_id);	
			kapee_set_loop_prop('slider_data',$slider_data);
			global $kapee_owlparam;
			$kapee_owlparam['owlCarouselArg'][$unique_id] = $slider_data;			
			$class = ($i == 1) ? 'tab-pane fade show active' : 'tab-pane fade'; ?>
			
			<div id="<?php echo esc_attr($tab_data['id']);?>" class="<?php echo esc_attr($class);?>" role="panel" aria-labelledby="nav-<?php echo esc_attr($tab_data['id']);?>">				
				<?php
				woocommerce_product_loop_start();
					$count = 0;
					while ( $tab_data['query']->have_posts() ) {
						$tab_data['query']->the_post();				
						if( $rows > 1 && $count % $rows == 0 ){
							echo '<div class="carousel-group">';
						}
						wc_get_template_part( 'content', 'product' );
						if( $rows > 1 && ($count % $rows == $rows - 1 || $count == $tab_data['query']->post_count - 1) ){
							echo '</div>';
						}
						$count++;
					}
					wp_reset_postdata();					
				woocommerce_product_loop_end();	
				kapee_reset_loop();
				?>				
			</div>
			<?php $i++; 
		} ?>
	</div>
</div>