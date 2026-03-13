<?php 
/** 
 * Only Products Template
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
				<div class="section-content col-12">
					<?php
					if( $query->have_posts() ){
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
						wp_reset_postdata();						
					woocommerce_product_loop_end();
					kapee_reset_loop();
					} else {
						esc_html_e('No products were found matching your selection','kapee-extensions');
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>