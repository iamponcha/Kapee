<?php 
/**
 * Product Brands Template
 */
?>
<div id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr( $class );?>">
	<?php if( ! empty( $title ) ){ ?>
		<div class="section-heading">			
			<h2><?php echo esc_html( $title );?></h2>
		</div>
	<?php } ?>
	<div class="section-content">
		<div class="products <?php echo esc_attr( $slider_class ); ?>">	
			<?php if ( $product_brands ) {
				$count = 0;
				$lastElement = end( $product_brands );
				foreach ( $product_brands as $brand ) {
					$brand_link = get_term_link( $brand ); 
					if( $rows > 1 && $count % $rows == 0 ){
						echo '<div class="carousel-group">';
					} ?>
					<div class="product-brand <?php echo esc_attr($column_class);?>">
						<a href="<?php echo esc_url($brand_link);?>">
							<div class="brand-image">
								<?php $thumbnail_id = get_term_meta( $brand->term_id, 'thumbnail_id', true );
								$brand_img = wp_get_attachment_image_src( $thumbnail_id, 'full' );
								if ( ! empty( $brand_img ) ) { 
									$attribute 			= array();
									$attribute['alt'] 	= esc_html($brand->name);
									 echo kapee_get_image_html( $thumbnail_id,'full', '', $attribute );
									}else{ ?>
									<img src="<?php echo esc_url(KAPEE_EXTENSIONS_URL.'assets/images/brand-placeholder.jpg');?>" alt="<?php esc_html($brand->name);?>"/>
								<?php } ?>
							</div>
							
							<?php if( $show_title ){ ?>
								<div class="brand-title"><?php echo esc_html($brand->name);?></div>
							<?php } ?>
						</a>
					</div>
					<?php 
					if( $rows > 1 && ($count % $rows == $rows - 1 ||  $brand == $lastElement ) ){
						echo '</div>';
					}
					$count++; 
				}
			} ?>
		</div>
	</div>
</div>