<?php 
/**
 * Categories Default Template
 */
?>
<div id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr( $class );?>">
	<?php if( ! empty( $title ) ){ ?>
		<div class="section-heading">			
			<h2><?php echo esc_html( $title );?></h2>
			<?php if( $show_view_more_button ){ ?>
				<div class="view-all-btn">
					<a class="button" href="<?php echo esc_url( $view_all_link );?>"><?php echo esc_html( $view_more_button_text );?></a>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	<div class="section-content <?php echo esc_attr( $section_class ); ?>">
		<div class="products <?php echo esc_attr( $slider_class ); ?>">	
			<?php if ( $product_categories ) {
				$count = 0;
				$total_categories = count($product_categories);
				foreach ( $product_categories as $cat ) {
					$cate_link = get_term_link( $cat );
					if( $rows > 1 && $count % $rows == 0 ){
						echo '<div class="carousel-group">';
					}
					?>
					<div class="product-category product <?php echo esc_attr($category_box_style);?> <?php echo esc_attr($column_class);?>">
						<div class="product-wrapper">
							<a href="<?php echo esc_url($cate_link);?>">
								<?php $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
								$catalog_img = wp_get_attachment_image_src( $thumbnail_id, $image_size );
								if ( ! empty( $catalog_img ) ) {
									$attribute 			= array();
									$attribute['alt'] 	= esc_html($cat->name);
									 
									echo kapee_get_image_html( $thumbnail_id, $image_size, '', $attribute ); 
								}else{ ?>
									<img src="<?php echo esc_url(wc_placeholder_img_src( $image_size ));?>" alt="<?php esc_html($cat->name);?>"/>
								<?php } ?>
								<h3 class="woocommerce-loop-category__title">
									<?php echo esc_html($cat->name);
									if( $show_count ) {
										echo sprintf(
											'<span class="product-count">%1$s</span>',
											sprintf( _n( '%s Product', '%s Products', $cat->count, 'kapee-extensions' ), $cat->count )
										);
									} ?>
								</h3>
							</a>
						</div>
					</div>
					<?php 
					if( $rows > 1 && ($count % $rows == $rows - 1 || $count == $total_categories - 1) ){
						echo '</div>';
					}
					$count++; 
				}
			} ?>
		</div>
	</div>
</div>