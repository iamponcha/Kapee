<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'KAPEE_EXTENSIONS_ADMIN' ) )
{
	class KAPEE_EXTENSIONS_ADMIN {
		function __construct() {
			// Action to add metabox
			add_action( 'add_meta_boxes', array($this, 'kapee_size_chart_metabox') );
			add_action( 'save_post', array($this, 'size_chart_content_meta_save') );
		}
		
		/**
		 * Size Chart Metabox
		 * @since 1.0.0
		 */
		 
		public function kapee_size_chart_metabox(){
			add_meta_box( 'kapee-size-chart', __( 'Size Chart Table', 'kapee-extensions' ), array($this, 'kapee_size_chart_content'), KAPEE_EXTENSIONS_SIZE_CHART_POST_TYPE, 'normal', 'high' );
		}
		
		/**
		 * Size Chart Metabox HTML
		 * 
		 * @since 1.0.0

		 */
		public function kapee_size_chart_content(){
			include_once( KAPEE_EXTENSIONS_DIR .'/inc/admin/size-chart-metabox.php');
		}
		
		/**
		 * Save the meta when the chart post is saved.
		 *
		 * @param int $post_id The ID of the post being saved.
		 */
		public function size_chart_content_meta_save($post_id) {
			// Check if our nonce is set.
			if (!isset($_POST['kapee_size_chart']))
				return $post_id;

			$nonce = $_POST['kapee_size_chart'];

			// Verify that the nonce is valid.
			if (!wp_verify_nonce($nonce, 'kapee_size_chart'))
				return $post_id;

			// If this is an autosave, our form has not been submitted,
			// so we don't want to do anything.
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return $post_id;

			// Check the user's permissions.
			if (KAPEE_EXTENSIONS_SIZE_CHART_POST_TYPE == $_POST['post_type']) {

				if (!current_user_can('edit_page', $post_id))
					return $post_id;
			} else {

				if (!current_user_can('edit_post', $post_id))
					return $post_id;
			}
			
			$prefix = KAPEE_EXTENSIONS_META_PREFIX; // Metabox prefix
			
			// Sanitize the user input.
			$chart_table = isset($_POST[$prefix.'size_chart_data']) ? sanitize_text_field($_POST[$prefix.'size_chart_data']) : '';
			/* save the data  */
			update_post_meta($post_id, $prefix.'size_chart_data', $chart_table);
		}
	
	}
	$obj_pl_admin = new KAPEE_EXTENSIONS_ADMIN();
	
}
