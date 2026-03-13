<?php 
/**
 * Banner With Products Template
 */
 
if ( ! defined( 'ABSPATH' ) ):
	exit; // Exit if accessed directly
endif; ?>

<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr($class);?>">
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
										<a href="<?php echo  !empty($cat_title_link) ? esc_url( $cat_title_link ) : 'javascript:void();'; ?>">
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
									<img src="<?php echo esc_url(wc_placeholder_img_src());?>"/>
								<?php endif;?>
							</a>
						<?php endif;?>
					</div>
				</div>
				<div class="section-content col-12 col-xl-7">
					<?php 
					$count = 0;
					woocommerce_product_loop_start();		
						while ( $query->have_posts() ) :			
							$query->the_post();							
							if( $rows > 1 && $count % $rows == 0 ){
								echo '<div class="carousel-group">';
							}
							wc_get_template_part( 'content', 'product' );
							if( $rows > 1 && ($count % $rows == $rows - 1 || $count == $query->post_count - 1) ){
								echo '</div>';
							}
							$count++;
						endwhile;
						wp_reset_postdata();
						
					woocommerce_product_loop_end();
					kapee_reset_loop();
					?>
				</div>
			</div>
		</div>
	</div>
</div>