<?php
/**
 * Theme options "Import/Export" section
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


$section_id = 'g1ui-settings-section-import-export';

add_settings_section(
	$section_id,                        // ID used to identify this section and with which to register options.
	esc_html__( 'Import demo data', 'bunchy' ),        // Title to be displayed on the administration page.
	'bunchy_render_import_demo_response',
	$this->get_page()                   // Page on which to add this section of options.
);

// Section fields.
add_settings_field(
	'import_demo_content',
	esc_html__( 'Content (posts, pages, images)', 'bunchy' ),
	'bunchy_render_import_demo_content_button',
	$this->get_page(),
	$section_id
);

add_settings_field(
	'import_demo_theme_options',
	esc_html__( 'Theme options', 'bunchy' ),
	'bunchy_render_import_demo_theme_options_button',
	$this->get_page(),
	$section_id
);

add_settings_field(
	'import_demo_all',
	esc_html__( 'All (content and theme options)', 'bunchy' ),
	'bunchy_render_import_demo_all_button',
	$this->get_page(),
	$section_id
);

add_settings_field(
	'import_theme_options_label',
	'<h3>' . esc_html__( 'Import theme options', 'bunchy' ) . '</h3>',
	array( $this, 'render_empty_field' ),
	$this->get_page(),
	$section_id
);

add_settings_field(
	'import_theme_options',
	esc_html__( 'Load from file', 'bunchy' ),
	'bunchy_render_import_theme_options_form',
	$this->get_page(),
	$section_id
);

add_settings_field(
	'export_theme_options_label',
	'<h3>' . esc_html__( 'Export theme options', 'bunchy' ) . '</h3>',
	array( $this, 'render_empty_field' ),
	$this->get_page(),
	$section_id
);

add_settings_field(
	'export_theme_options',
	esc_html__( 'Export to file', 'bunchy' ),
	'bunchy_render_export_theme_options_button',
	$this->get_page(),
	$section_id
);

/**
 * Render response after import demo data
 */
function bunchy_render_import_demo_response() {
	$import_response = get_transient( 'bunchy_import_demo_response' );

	if ( false !== $import_response ) {
		delete_transient( 'bunchy_import_demo_response' );

		$response_status_class = 'success' === $import_response['status'] ? 'notice' : 'error';
		?>
		<div class="updated is-dismissible <?php echo sanitize_html_class( $response_status_class ); ?>">
			<p>
				<strong><?php echo wp_kses_post( $import_response['message'] ); ?></strong><br/>
			</p>
			<button type="button" class="notice-dismiss"><span
					class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'bunchy' ); ?></span></button>
		</div>
		<?php
	}
}

/**
 * Render button to import demo content
 */
function bunchy_render_import_demo_content_button() {
	?>
	<a class="button"
	   href="<?php echo esc_url( bunchy_get_import_demo_content_url() ); ?>"><?php esc_html_e( 'Import', 'bunchy' ); ?></a>
	<?php
}

/**
 * Render button to import theme options
 */
function bunchy_render_import_demo_theme_options_button() {
	?>
	<a class="button"
	   href="<?php echo esc_url( bunchy_get_import_demo_theme_options_url() ); ?>"><?php esc_html_e( 'Import', 'bunchy' ); ?></a>
	<p><?php esc_html_e( 'Will override also options from the Customize panel', 'bunchy' ); ?></p>
	<?php
}

/**
 * Render button to import demo content and theme options
 */
function bunchy_render_import_demo_all_button() {
	?>
	<a class="button"
	   href="<?php echo esc_url( bunchy_get_import_demo_all_url() ); ?>"><?php esc_html_e( 'Import', 'bunchy' ); ?></a>
	<?php
}

/**
 * Render form to import theme options
 */
function bunchy_render_import_theme_options_form() {
	?>
	<input type="file" name="g1_theme_options_file"/>
	<input type="submit" class="button button-secondary" id="g1-import-theme-options" name="g1_import_theme_options"
	       value="<?php esc_html_e( 'Import', 'bunchy' ); ?>"/>
	<?php
	$status_ok = get_transient( 'bunchy_import_theme_options_status_ok' );

	if ( false !== $status_ok ) {
		delete_transient( 'bunchy_import_theme_options_status_ok' );

		echo '<span class="g1-import-status g1-import-status-ok">' . wp_kses_post( $status_ok ) . '</span>';
	}
}

/**
 * Render button to export theme options
 */
function bunchy_render_export_theme_options_button() {
	?>
	<a class="button"
	   href="<?php echo esc_url( admin_url( 'themes.php?page=theme-options&export=theme-options' ) ); ?>"><?php esc_html_e( 'Export', 'bunchy' ); ?></a>
	<?php
}

