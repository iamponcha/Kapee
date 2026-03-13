<?php 
/**
 * Hot Deal Products Template
 */
?>
<div id="<?php echo esc_attr( $id );?>" class="<?php echo esc_attr( $class );?>">	
	<?php if( ! empty( $title ) ) { ?>
		<div class="section-heading">
			<h2><?php echo esc_html($title); ?></h2>
		</div>
	<?php }	
	$count = 0;
	woocommerce_product_loop_start();		
		while ( $query->have_posts() ) {			
			$query->the_post();
			if( $rows > 1 && $count % $rows == 0 ){
				echo '<div class="carousel-group">';
			}
			wc_get_template_part( 'content', 'product' );
			if( $rows > 1 && ($count % $rows == $rows - 1 || $count == $query->post_count - 1) ){
				echo '</div>';
			}
			$count++;
		}					
	woocommerce_product_loop_end();	
	wp_reset_postdata();
	kapee_reset_loop();
	?>	
</div>