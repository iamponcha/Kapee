<?php 
/***
* Product Categories With Banner
**/
?>
<div class="<?php echo esc_attr( $class );?>">
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
	<div class="section-content row <?php echo esc_attr( $banner_layout );?>">
		<div class="col-md-3 banner-image">
			<?php if( ! empty( $banner_image ) ) { ?>		
				<a href="<?php echo esc_attr( $view_all_link );?>">
					<?php echo kapee_get_image_html($banner_image,'full'); ?>					
				</a>	
			<?php } ?>
		</div>
		<div class="col-md-9">
			<?php if ( $product_categories ) { ?>
				<div id="<?php echo esc_attr($id); ?>" <?php if(!empty($section_class)) { ?> class="<?php echo esc_attr( $section_class ); ?>" <?php } ?>>
					<div class="products <?php echo esc_attr( $slider_class ); ?>">			
						<?php 
							$count = 0;
							$total_categories = count($product_categories);
							foreach ( $product_categories as $cat ) {
								$cate_link = get_term_link( $cat ); 
								if( $rows > 1 && $count % $rows == 0 ){
									echo '<div class="carousel-group">';
								} 
							?>
							<div class="product-category product <?php echo esc_attr($column_class);?>">
								<div class="product-wrapper">	
									<a href="<?php echo esc_url($cate_link);?>">
										<?php $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
										$catalog_img = wp_get_attachment_image_src( $thumbnail_id, $image_size );
										if ( ! empty( $catalog_img ) ) {
											$attribute 			= array();
											$attribute['alt'] 	= esc_html($cat->name);
											 
											echo kapee_get_image_html($thumbnail_id, $image_size,'',$attribute); 
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
									<!--<div class="category-image">
										<?php $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
										$catalog_img = wp_get_attachment_image_src( $thumbnail_id, $image_size );
										if ( ! empty( $catalog_img ) ) { 
											$attribute 			= array();
											$attribute['alt'] 	= esc_html($cat->name);
											?>
											<a href="<?php echo esc_url($cate_link);?>">
												<?php echo kapee_get_image_html($thumbnail_id, $image_size,'',$attribute); ?>
											</a>
										<?php }else{ ?>
											<img src="<?php echo esc_url(KAPEE_EXTENSIONS_URL.'assets/images/product-placeholder.jpg');?>" alt="<?php esc_html($cat->name);?>"/>
										<?php } ?>
									</div>
									<div class="category-content">
										<a href="<?php echo esc_url($cate_link);?>">
											<h3 class="category-title"><?php echo esc_html($cat->name);?></h3>
											<span class="cat-explore"><?php esc_html_e('Explore Now','kapee-extensions');?></span>
										</a>
									</div>-->
								</div>
							</div>
						<?php 
							if( $rows > 1 && ($count % $rows == $rows - 1 || $count == $total_categories - 1) ){
								echo '</div>';
							}
							$count++; 
						} ?>					
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>