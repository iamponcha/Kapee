<?php 
/** 
 * Banner With Categories Template
 */

if ( ! defined( 'ABSPATH' ) ):
	exit; // Exit if accessed directly
endif; ?>

<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class );?>">
	<div class="section-inner row">
		<div class="section-categories col-12 col-md-3 col-lg-2">
			<?php if( !empty( $title ) ) { ?>
			<div class="section-title">
				<h3><?php echo esc_attr($title);?></h3>
			</div>
			<?php } ?>
			<ul class="sub-categories">
				<?php foreach($product_categories as $cate):
						$cate_link = get_term_link( $cate ); ?>
					<li><a href="<?php echo esc_url($cate_link);?>"><?php echo esc_html($cate->name);?></a></li>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="section-banner-content col-12 col-md-9 col-lg-10">
			<div class="row">
				<div class="section-banner col-xl-5 d-none d-xl-block">
					<div id="<?php echo esc_attr($banner_id);?>" class="banner-img">
						<?php if($banner_style=="banner_with_slider"):?>
							<ul class="kapee-carousel owl-carousel grid-col-1">
								<?php foreach(explode(",",$banner_images) as $attchID):?>
									<?php //$cate_link = get_term_link( $cate ); ?>
									<li>
										<a href="#">
										<?php if(wp_get_attachment_url( $attchID )) :
											echo kapee_get_image_html($attchID,'full');
										else:?>
											<img src="<?php echo esc_url(wc_placeholder_img_src());?>" alt="<?php esc_html_e('Banner','kapee-extensions');?>"/>
										<?php endif;?>
										</a>
									</li>
								<?php endforeach;
								?>
							</ul>
						<?php else:?>
							<a href="<?php //echo  $term_link ? esc_url( $term_link ) : ''; ?>">
								<?php if(wp_get_attachment_url( $banner_image )) :
									echo kapee_get_image_html($banner_image,'full');
								else:?>
									<img src="<?php echo esc_url(wc_placeholder_img_src());?>" alt="<?php esc_html_e('Banner','kapee-extensions');?>"/>
								<?php endif;?>
							</a>
						<?php endif;?>
					</div>
				</div>
				<div class="section-content col-12 col-xl-7">
					<?php if ( ! empty($product_categories) ) :	$lastElement = end( $product_categories );	?>
						<?php $row=1; ?>
						<div id="<?php echo esc_attr( $cat_section_id );?>" class="row">
							<div class="products <?php echo esc_attr($slider_class);?>">
								<?php foreach( $product_categories as $cat ): 	
									if( $row == 1 ) { 
										echo '<div class="carousel-group">'; 
									}								
									$cate_link = get_term_link( $cat ); ?>
									<div class="product-category product product <?php echo esc_attr($category_box_style);?>">
										<div class="product-wrapper">
											<a href="<?php echo esc_url($cate_link);?>">
												<?php $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
												$catalog_img = wp_get_attachment_image_src( $thumbnail_id, 'shop_catalog' );
												if ( ! empty( $catalog_img ) ) {
													$attribute 			= array();
													$attribute['alt'] 	= esc_html( $cat->name );
													 
													echo kapee_get_image_html($thumbnail_id,'shop_catalog','',$attribute); 
												}else{ ?>
													<img src="<?php echo esc_url(wc_placeholder_img_src( 'shop_catalog' ));?>" alt="<?php esc_html($cat->name);?>"/>
												<?php } ?>
												<h3 class="woocommerce-loop-category__title">
													<?php echo esc_html($cat->name);
													if( $show_count ) {
														echo sprintf(
															'<span class="product-count">%1$s</span>',
															sprintf( _n( '%s Product', '%s Products', $cat->count, 'kapee-extensions' ), $cat->count )
														);
													}?>
												</h3>
											</a>
										</div>
									</div>
									<?php if( $row==2 || $cat==$lastElement ){
										$row=0;
										echo '</div>';
									} $row++;
								endforeach; // end of the loop. ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>