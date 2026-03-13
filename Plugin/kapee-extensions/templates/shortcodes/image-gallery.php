<?php 
/**
 * Image Gallery
 */
?>
<div id="<?php echo esc_attr( $id );?>" class="<?php echo esc_attr( $class );?>">
	<div class="section-content">
		<div class="<?php echo esc_attr( $slider_class ); ?>">	
			<?php if ( ! empty( $gallery_images ) ) {
				$count = 0;
				$lastElement = end( $gallery_images );	
				$total_images = count( $gallery_images );
				$row=1;
				foreach( $gallery_images as $attchID ){
					$image_url = wp_get_attachment_image_src( $attchID, 'full' );
					if( $row == 1 && $rows > 1) { 
						echo '<div class="carousel-group">'; 
					}?>
					
					<div class="kapee-gallery <?php echo esc_attr ( $column_class );?>">
						<a href="<?php if( ! empty( $image_url ) ) echo esc_url( $image_url[0] );?>">
							<?php if( wp_get_attachment_url( $attchID ) ) :
								//echo kapee_get_image_html( $attchID, 'full' );
								$image_output = wp_get_attachment_image( $attchID, 'full', false );
								echo $image_output;
							else:?>
								<img src="<?php echo esc_url(KAPEE_EXTENSIONS_URL.'assets/images/product-placeholder.jpg');?>" alt="<?php esc_html_e('Gallery Image','kapee-extensions');?>"/>
							<?php endif;?>
						</a>
					</div>
					<?php 
					if( ( $row == $rows || $attchID == $lastElement ) && $rows > 1 ){
						$row=0;
						echo '</div>';
					} $row++;
				}
			} ?>
		</div>
	</div>
</div>