<?php
/**
 * Single Post Options Metabox
 *
 * @license For the full license information, please view the Licensing folder
 * that was distributed with this source code.
 *
 * @package Bunchy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

/**
 * Class Bunchy_Post_Single_Options_Meta_Box
 */
class Bunchy_Post_Single_Options_Meta_Box {

	/**
	 * Init.
	 */
	public function __construct() {
		$this->setup_hooks();
	}

	/**
	 * Define metabox actions/filters.
	 */
	protected function setup_hooks() {
		add_action( 'add_meta_boxes',   array( $this, 'add_meta_boxes' ), 1 );
		add_action( 'save_post',        array( $this, 'save' ) );
	}

	/**
	 * Return supported post type for the meta box
	 *
	 * @return array
	 */
	public function get_allowed_post_types() {
		return apply_filters( 'bunchy_post_single_options_meta_box_post_type_list', array( 'post' ) );
	}

	/**
	 * Register meta box
	 *
	 * @param string $post_type             Processed post type.
	 */
	public function add_meta_boxes( $post_type ) {
		if ( ! in_array( $post_type, $this->get_allowed_post_types(), true ) ) {
			return;
		}

		add_meta_box(
			'bunchy_post_single_options_meta_box',
			__( 'Single Page', 'bunchy' ),
			array( $this, 'render_meta_box' ),
			$post_type,
			'normal',
			'high'
		);
	}

	/**
	 * Return meta box defuault options
	 *
	 * @return array
	 */
	public function get_defaults() {
		$defaults = array(
			'featured_media' => '',
		);

		return $defaults;
	}

	/**
	 * Render meta box
	 *
	 * @param WP_Post $post         Current post.
	 */
	public function render_meta_box( $post ) {
		$value = get_post_meta( $post->ID, '_bunchy_single_options', true );
		$value = wp_parse_args( $value, $this->get_defaults() );

		?>

		<?php wp_nonce_field( 'bunchy_single_post_options', 'bunchy_single_post_options_nonce' ); ?>
		<p class="howto"><?php esc_html_e( 'Use the &quot;inherit&quot; option to apply settings from the Appearance &rsaquo; Customize &rsaquo; Posts &rsaquo; Single section.', 'bunchy' ); ?></p>

		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="_bunchy_single_options[featured_media]">
						<?php esc_html_e( 'Featured Image', 'bunchy' ); ?>
					</label>
				</th>
				<td>
					<select name="_bunchy_single_options[featured_media]">
						<option
							value=""<?php selected( $value['featured_media'], '' ); ?>><?php esc_html_e( 'inherit', 'bunchy' ); ?></option>
						<option
							value="standard"<?php selected( $value['featured_media'], 'standard' ); ?>><?php esc_html_e( 'show', 'bunchy' ); ?></option>
						<option
							value="none"<?php selected( $value['featured_media'], 'none' ); ?>><?php esc_html_e( 'hide', 'bunchy' ); ?></option>
					</select>
				</td>
			</tr>
		</table>

		<?php
	}

	/**
	 * Save meta box options
	 *
	 * @param int $post_id      Current post id.
	 *
	 * @return mixed
	 */
	public function save( $post_id ) {
		// Don't save data automatically via autosave feature.
		if ( $this->is_doing_autosave() ) {
			return $post_id;
		}

		// Don't save data when doing preview.
		if ( $this->is_doing_preview() ) {
			return $post_id;
		}

		// Don't save data when using Quick Edit.
		if ( $this->is_inline_edit() ) {
			return $post_id;
		}

		$post_type = filter_input( INPUT_POST, 'post_type', FILTER_SANITIZE_STRING );

		// Update options only if they are appliable.
		if ( ! in_array( $post_type, $this->get_allowed_post_types(), true ) ) {
			return $post_id;
		}

		// Check permissions.
		$post_type_obj = get_post_type_object( $post_type );
		if ( ! current_user_can( $post_type_obj->cap->edit_post, $post_id ) ) {
			return $post_id;
		}

		// Verify nonce.
		if ( ! check_admin_referer( 'bunchy_single_post_options', 'bunchy_single_post_options_nonce' ) ) {
			wp_die( esc_html__( 'Nonce incorrect!', 'bunchy' ) );
		}

		if ( isset( $_POST['_bunchy_single_options'] ) ) { // Input var okey.

			/*
			 * WP ignores the built in php magic quotes setting
			 * WP ignores the value of get_magic_quotes_gpc()
			 * It will always add magic quotes
			 * That's why we need to strip slashes
			 */
			$post_value = filter_input_array( INPUT_POST, array(
				'_bunchy_single_options' => array(
					'filter' => FILTER_SANITIZE_STRING,
					'flags'  => FILTER_REQUIRE_ARRAY,
				),
			) );

			$options = $post_value['_bunchy_single_options'];

			// Save only defined fileds.
			$valid_fields = $this->get_defaults();

			foreach ( $options as $field_name => $field_value ) {
				if ( ! isset( $valid_fields[ $field_name ] ) ) {
					unset( $options[ $field_name ] );
				}
			}

			update_post_meta( $post_id, '_bunchy_single_options', $options );
		}
	}

	/**
	 * Check whether request is processed during autosave
	 *
	 * @return bool
	 */
	protected function is_doing_autosave() {
		return defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE;
	}

	/**
	 * Check whether request is an inline edit
	 *
	 * @return bool
	 */
	protected function is_inline_edit() {
		$inline_edit_var = filter_input( INPUT_POST, '_inline_edit' );

		return null !== $inline_edit_var;
	}

	/**
	 * Check whether request is processed during preview
	 *
	 * @return bool
	 */
	protected function is_doing_preview() {
		$wp_preview_var = filter_input( INPUT_POST, 'wp-preview' );

		return ! empty( $wp_preview_var );
	}
}


/**
 * Quasi-singleton
 */
function bunchy_post_single_options_meta_box() {
	static $instance;

	if ( ! isset( $instance ) ) {
		$instance = new Bunchy_Post_Single_Options_Meta_Box();
	}

	return $instance;
}

bunchy_post_single_options_meta_box();
