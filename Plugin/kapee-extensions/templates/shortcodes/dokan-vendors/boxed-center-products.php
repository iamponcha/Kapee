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
			$vendor				= dokan()->vendor->get( $vendor_id );
			$store_banner_id	= $vendor->get_banner_id();
			$store_name			= $vendor->get_shop_name();
			$store_url			= $vendor->get_shop_url();
			$store_rating		= $vendor->get_rating();
			$store_phone		= $vendor->get_phone();
			$is_store_featured 	= $vendor->is_featured();
			$store_info			= dokan_get_store_info( $vendor_id);
			$store_address		= dokan_get_seller_short_address( $vendor_id );
			$image_size			= 'full';
			$store_banner_url	= $store_banner_id ? wp_get_attachment_image_src( $store_banner_id, $image_size ) : DOKAN_PLUGIN_ASSEST . '/images/default-store-banner.png';
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
								<?php if ( $is_store_featured ) : ?>
									<div class="kapee-store-featured">							
										<div class="featured-label"><?php esc_html_e( 'Featured', 'kapee-extensions' ); ?></div>
									</div>
								<?php endif ?>								
							</div>
						</div>
					</div>
					<div class="kapee-store-footer">
						<div class="vendor-avatar">
							<?php echo get_avatar( $vendor_id, 150 ); ?>						
						</div>
						<div class="kapee-store-data">
							<h2><?php echo esc_html( $store_name ); ?></h2>
							<?php if ( ! empty( $store_rating['count'] ) ) { ?>
								<div class="star-rating kapee-store-rating" title="<?php echo sprintf( esc_attr__( 'Rated %s out of 5', 'kapee-extensions' ), esc_attr( $store_rating['rating'] ) ) ?>">
									<span style="width: <?php echo ( esc_attr( ( $store_rating['rating'] / 5 ) ) * 100 - 1 ); ?>%">
										<strong class="rating"><?php echo esc_html( $store_rating['rating'] ); ?></strong> <?php esc_html_e( 'out of 5', 'kapee-extensions' ); ?>
									</span>
								</div>
							<?php } ?>							
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