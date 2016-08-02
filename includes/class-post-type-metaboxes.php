<?php
/**
 * SSM Collections
 *
 * @package   SSM_Collections
 * @license   GPL-2.0+
 */

/**
 * Register metaboxes.
 *
 * @package SSM_Collections
 */
class SSM_Collections_Metaboxes {

	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'product_rental_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ),  10, 2 );
	}

	/**
	 * Register the metaboxes to be used for the SSM Collections
	 *
	 * @since 0.1.0
	 */
	public function product_rental_meta_boxes() {
		add_meta_box(
			'profile_fields',
			'Profile Fields',
			array( $this, 'render_meta_boxes' ),
			'Project',
			'normal',
			'high'
		);
	}

   /**
	* The HTML for the fields
	*
	* @since 0.1.0
	*/
	function render_meta_boxes( $post ) {

		$meta = get_post_custom( $post->ID );
		$title = ! isset( $meta['profile_title'][0] ) ? '' : $meta['profile_title'][0];
		$twitter = ! isset( $meta['profile_twitter'][0] ) ? '' : $meta['profile_twitter'][0];
		$linkedin = ! isset( $meta['profile_linkedin'][0] ) ? '' : $meta['profile_linkedin'][0];
		$facebook = ! isset( $meta['profile_facebook'][0] ) ? '' : $meta['profile_facebook'][0];

		wp_nonce_field( basename( __FILE__ ), 'profile_fields' ); ?>

		<table class="form-table">

			<tr>
				<td class="product_rental_meta_box_td" colspan="2">
					<label for="profile_title"><?php _e( 'Title', 'ssm-collections' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="profile_title" class="regular-text" value="<?php echo $title; ?>">
					<p class="description"><?php _e( 'E.g. CEO, Sales Lead, Designer', 'ssm-collections' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="product_rental_meta_box_td" colspan="2">
					<label for="profile_linkedin"><?php _e( 'LinkedIn URL', 'ssm-collections' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="profile_linkedin" class="regular-text" value="<?php echo $linkedin; ?>">
				</td>
			</tr>

			<tr>
				<td class="product_rental_meta_box_td" colspan="2">
					<label for="profile_twitter"><?php _e( 'Twitter URL', 'ssm-collections' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="profile_twitter" class="regular-text" value="<?php echo $twitter; ?>">
				</td>
			</tr>

			<tr>
				<td class="product_rental_meta_box_td" colspan="2">
					<label for="profile_facebook"><?php _e( 'Facebook URL', 'ssm-collections' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="profile_facebook" class="regular-text" value="<?php echo $facebook; ?>">
				</td>
			</tr>

		</table>

	<?php }

   /**
	* Save metaboxes
	*
	* @since 0.1.0
	*/
	function save_meta_boxes( $post_id ) {

		global $post;

		// Verify nonce
		if ( !isset( $_POST['profile_fields'] ) || !wp_verify_nonce( $_POST['profile_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}

		// Check Autosave
		if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) {
			return $post_id;
		}

		// Don't save if only a revision
		if ( isset( $post->post_type ) && $post->post_type == 'revision' ) {
			return $post_id;
		}

		// Check permissions
		if ( !current_user_can( 'edit_post', $post->ID ) ) {
			return $post_id;
		}

		$meta['profile_title'] = ( isset( $_POST['profile_title'] ) ? esc_textarea( $_POST['profile_title'] ) : '' );

		$meta['profile_linkedin'] = ( isset( $_POST['profile_linkedin'] ) ? esc_url( $_POST['profile_linkedin'] ) : '' );

		$meta['profile_twitter'] = ( isset( $_POST['profile_twitter'] ) ? esc_url( $_POST['profile_twitter'] ) : '' );

		$meta['profile_facebook'] = ( isset( $_POST['profile_facebook'] ) ? esc_url( $_POST['profile_facebook'] ) : '' );

		foreach ( $meta as $key => $value ) {
			update_post_meta( $post->ID, $key, $value );
		}
	}

}