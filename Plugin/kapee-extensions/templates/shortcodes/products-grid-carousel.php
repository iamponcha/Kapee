<?php 
/***
* Products Grid Carousel Template
**/
?>
<div id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr( $class );?>">	
	<?php if( ! empty( $title ) ) { ?>
		<div class="section-heading">
			<h2><?php echo esc_html($title); ?></h2>
			<?php if( $show_view_more_button ){ ?>
				<div class="view-all-btn">
					<a class="button" href="<?php echo esc_url( $view_all_link );?>"><?php echo esc_html( $view_more_button_text );?></a>
				</div>
			<?php } ?>
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
	if($show_pagination) { ?>
	<div class="kapee-pagination">
	<?php	
	
		if ( $pagination != 'default'){
			$load_more_label 		= kapee_get_loop_prop( 'products-pagination-load-more-button-text' );
			$loading_finished_msg 	= kapee_get_loop_prop( 'products-pagination-finished-message' );
		?>
		<div class="kapee-products-load-more" data-pagination_style = "<?php echo esc_attr($pagination);?>" data-total="<?php echo esc_attr($total);?>">
			<a data-attribute="<?php echo base64_encode($atts); ?>" data-page="2" href="javascript:void(0);" class="btn kapee-load-more <?php echo esc_attr($pagination); ?>"
			data-pagination_style = "<?php echo esc_attr($pagination);?>" data-total="<?php echo esc_attr($total);?>"
			data-load_more_label="<?php echo esc_html($load_more_label); ?>"
			data-loading_finished_msg="<?php echo esc_html($loading_finished_msg); ?>">
				<?php echo esc_html($load_more_label); ?>
			</a>
		</div>
		<?php
		}
		else{
			echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
				'base'         => $base,
				'format'       => $format,
				'add_args'     => false,
				'current'      => max( 1, $current ),
				'total'        => $total,
				'prev_text'    => esc_html__('Previous','kapee-extensions'),
				'next_text'    => esc_html__('Next','kapee-extensions'),
				'type'         => 'list',
				'end_size'     => 2,
				'mid_size'     => 2,
			) ) );
		}
	?>
	</div>
	<?php
	}
	wp_reset_postdata();
	kapee_reset_loop();
	?>	
</div>