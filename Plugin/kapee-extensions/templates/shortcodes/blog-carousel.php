<?php 
/**
 * Blog Carousel Template
 */
?>
<div id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr($class);?>">
	<?php if( ! empty( $title ) ) { ?>
		<div class="section-heading">
			<h2><?php echo esc_html($title); ?></h2>
		</div>
	<?php }
	
	kapee_post_loop_start();	
		while ( $query->have_posts() ) :
			$query->the_post();			
			// Include the loop post content template.
			get_template_part( 'template-parts/post-loop/layout', get_post_format() );

		endwhile;	
		wp_reset_postdata();
	kapee_post_loop_end();
	kapee_reset_loop();
	?>
</div>