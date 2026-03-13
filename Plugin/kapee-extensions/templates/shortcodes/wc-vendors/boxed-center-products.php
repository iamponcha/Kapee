<?php 
/**
 * Dokan Vendors Template
 */
?>
<div id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr( $class );?>">	
	<?php if( ! empty( $title ) ) { ?>
		<div class="section-heading">
			<h2><?php echo esc_html($title); ?></h2>
		</div>
	<?php } ?>
	<div class="kapee-vendors-list <?php echo esc_attr($slider_class);?>">
		<?php
		$count = 0;
		foreach ( $vendors as $key => $vendor_id ) {
			$store_banner_id	= get_user_meta( $vendor_id, '_wcv_store_banner_id', true );
			$store_name			= WCV_Vendors::get_vendor_shop_name( $vendor_id );
			$store_url			= WCV_Vendors::get_vendor_shop_page( $vendor_id );
			$vendor_meta = array_map(
				function ( $a ) {
						return $a[0];
				},
				get_user_meta( $vendor_id )
			);
			
			// Migrate to store address array
			$address1       = ( array_key_exists( '_wcv_store_address1', $vendor_meta ) ) ? $vendor_meta['_wcv_store_address1'] : '';
			$address2       = ( array_key_exists( '_wcv_store_address2', $vendor_meta ) ) ? $vendor_meta['_wcv_store_address2'] : '';
			$city           = ( array_key_exists( '_wcv_store_city', $vendor_meta ) ) ? $vendor_meta['_wcv_store_city'] : '';
			$state          = ( array_key_exists( '_wcv_store_state', $vendor_meta ) ) ? $vendor_meta['_wcv_store_state'] : '';
			$store_phone          = ( array_key_exists( '_wcv_store_phone', $vendor_meta ) ) ? $vendor_meta['_wcv_store_phone'] : '';
			$store_postcode = ( array_key_exists( '_wcv_store_postcode', $vendor_meta ) ) ? $vendor_meta['_wcv_store_postcode'] : '';

			$store_address = ( $address1 != '' ) ? $address1 . ', ' . $city . ', ' . $state . ', ' . $store_postcode : '';


			$store_banner_url	= get_user_meta( $vendor_id, '_wcv_store_banner_id', true ) ? wp_get_attachment_image_src( get_user_meta( $vendor_id, '_wcv_store_banner_id', true ), 'full' ) : WCVendors_Pro::get_option( 'default_store_banner_src' );
			$has_bg_class 		= $store_banner_id ? "has-vendor-background" : '';
			if( $rows > 1 && $count % $rows == 0 ){
				echo '<div class="carousel-group">';
			}
			?>
			<div class="kapee-single-vendor woocommerce <?php echo esc_attr($column_class);?>">
				<div class="kapee-store-wrapper">
					<div class="kapee-store-content">
						<div class="kapee-store-content-wrapper <?php echo esc_attr($has_bg_class);?>" style="background-image: url( '<?php echo is_array( $store_banner_url ) ? esc_attr( $store_banner_url[0] ) : esc_attr( $store_banner_url ); ?>');">
							<div class="kapee-store-content-container">
															
							</div>
						</div>
					</div>
					<div class="kapee-store-footer">
						<div class="vendor-avatar">
							<?php echo get_avatar( $vendor_id, 150 ); ?>						
						</div>
						<div class="kapee-store-data">
							<h2><?php echo esc_html( $store_name ); ?></h2>
													
						</div>
						<?php
						if( $recent_products ) {
							$args = array(
								'posts_per_page' => 4,
								'author' => $vendor_id,
							);
							$query = kapee_vendor_products( $args );
							if ( $query->have_posts() ){
								echo '<div class="kapee-store-products">';				
								while ( $query->have_posts() ) : $query->the_post();
									echo '<div class="store-product">';
									echo '<a href="'. get_permalink( $query->ID ) .'">';
										$image_size = 'thumbnail';
										echo kapee_get_post_thumbnail( $image_size );
									echo '</a>';
									echo '</div>';
								endwhile;
								echo '</div>';
							}
							wp_reset_postdata(); 
						} 
						?>
						<a class="button kapee-store-link" href="<?php echo esc_attr( $store_url ); ?>"><?php esc_html_e( 'Visit Store', 'kapee-extensions' )?></a>
					</div>
				</div>
			</div>	
		<?php 
			if( $rows > 1 && ($count % $rows == $rows - 1 || $count == $vendors_count - 1) ){
				echo '</div>';
			}
			$count++;
		}	?>
	</div>
</div>