<?php
/**
 * Theme options base class
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
 * Our Theme
 */
class Bunchy_Theme_Options {

	/**
	 * Instance of the class
	 *
	 * @var Bunchy_Theme_Options $instance .
	 */
	private static $instance;

	/**
	 * Form validation errors
	 *
	 * @var array form_errors
	 */
	private $form_errors;

	/**
	 * Init
	 */
	private function __construct() {
		add_action( 'after_setup_theme', array( $this, 'setup_hooks' ) );

		// Import.
		add_filter( 'pre_update_option_' . bunchy_get_theme_options_id(), array(
			$this,
			'modify_options_array',
		), 10, 3 );
		add_action( 'updated_option', array( $this, 'override_theme_options' ), 10, 3 );

		// Export.
		$this->handle_export_theme_options();
		$this->handle_tasks();
	}

	/**
	 * If we want to import options from file (on the same save action as Settings API),
	 * we need to modify options array to pass test comparing new value with old value (pass only if different)
	 * that triggers hook "updated_option".
	 *
	 * @param array $value Theme options.
	 *
	 * @return mixed
	 */
	public function modify_options_array( $value ) {
		if ( isset( $_FILES['g1_theme_options_file'] ) ) { // Input var okay.
			$bunchy_file_uploaded_ok = UPLOAD_ERR_OK === $_FILES['g1_theme_options_file']['error']; // Input var okay.

			if ( $bunchy_file_uploaded_ok ) {
				$value['g1_time'] = time();
			}
		}

		return $value;
	}

	/**
	 * Overide theme options
	 *
	 * @param string $option Option name.
	 */
	public function override_theme_options( $option ) {
		if ( bunchy_get_theme_options_id() === $option ) {
			$this->handle_import_theme_options();
		}
	}

	/**
	 * Return instance of the class
	 *
	 * @return Bunchy_Theme_Options
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new Bunchy_Theme_Options();
		}

		return self::$instance;
	}

	/**
	 * Setup hooks
	 */
	public function setup_hooks() {
		add_action( 'admin_menu', array( $this, 'add_theme_page' ) );
		add_action( 'admin_init', array( $this, 'register_options' ) );

		// Enqueue styles/scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue assets
	 *
	 * @param string $hook Current page.
	 */
	public function enqueue_scripts( $hook ) {
		if ( 'appearance_page_' . $this->get_page() === $hook ) {
			wp_enqueue_script( 'bunchy-theme-options', BUNCHY_ADMIN_DIR_URI . 'js/theme-options.js', array( 'jquery' ), bunchy_get_theme_version(), true );
		}
	}

	/**
	 * Return name of the theme options admin page
	 *
	 * @return string   Registered page for options
	 */
	public function get_page() {
		return 'theme-options';
	}

	/**
	 * Return db option name
	 *
	 * @return string
	 */
	public function get_option_name() {
		return bunchy_get_theme_options_id();
	}

	/**
	 * Return base directory
	 *
	 * @return string
	 */
	public function get_base_dir() {
		return BUNCHY_ADMIN_DIR . 'theme-options';
	}

	/**
	 * Register admin page
	 */
	public function add_theme_page() {
		add_theme_page(
			esc_html__( 'Theme Options', 'bunchy' ),  // Page title.
			esc_html__( 'Theme Options', 'bunchy' ),  // Menu title.
			'manage_options',                   // Capability.
			$this->get_page(),                  // Menu slug.
			array(                              // Callback, to output the content for this page.
				$this,
				'render_admin_page',
			)
		);
	}

	/**
	 * Render navigation
	 *
	 * @param string $current_group Theme options group.
	 */
	public function render_settings_nav( $current_group ) {
		$base_url = admin_url( 'themes.php?page=' . $this->get_page() );
		?>

		<h2 class="nav-tab-wrapper">
			<a href="<?php echo esc_url( $base_url . '&group=dashboard' ); ?>"
			   id="nav-tab-dashboard"
			   class="nav-tab <?php if ( 'dashboard' === $current_group ) { echo sanitize_html_class( 'nav-tab-active' ); } ?>">
				<?php esc_html_e( 'Dashboard', 'bunchy' ); ?>
			</a>
			<a href="<?php echo esc_url( $base_url . '&group=import-export' ); ?>"
			   id="nav-tab-import-export"
			   class="nav-tab <?php if ( 'import-export' === $current_group ) { echo sanitize_html_class( 'nav-tab-active' ); } ?>">
				<?php esc_html_e( 'Import/Export', 'bunchy' ); ?>
			</a>
			<a href="<?php echo esc_url( $base_url . '&group=dynamic-styles' ); ?>"
			   id="nav-tab-dynamic-styles"
			   class="nav-tab g1-form <?php if ( 'dynamic-styles' === $current_group ) { echo sanitize_html_class( 'nav-tab-active' ); } ?>">
				<?php esc_html_e( 'Dynamic CSS', 'bunchy' ); ?>
			</a>
			<a href="<?php echo esc_url( $base_url . '&group=tasks' ); ?>"
			   id="nav-tab-tasks"
			   class="nav-tab <?php if ( 'tasks' === $current_group ) { echo sanitize_html_class( 'nav-tab-active' ); } ?>">
				<?php esc_html_e( 'Tasks', 'bunchy' ); ?>
			</a>
		</h2>

	<?php
	}

	/**
	 * Return current group
	 *
	 * @return string
	 */
	public function get_current_group() {
		// Default.
		$group = 'dashboard';

		if ( isset( $_GET['group'] ) ) {                                    // Input var okey.
			$group = sanitize_text_field( wp_unslash( $_GET['group'] ) );   // Input var okey.
		}

		return $group;
	}

	/**
	 * Retunr current section of options panel
	 *
	 * @return string
	 */
	public function get_current_section() {
		// Default.
		$section = '';

		if ( isset( $_GET['section'] ) ) {                                          // Input var okey.
			$section = sanitize_text_field( wp_unslash( $_GET['section'] ) );       // Input var okey.
		}

		if ( empty( $section ) ) {
			switch ( $this->get_current_group() ) {
				case 'theme':
					$section = 'dashboard';
					break;
			}
		}

		return $section;
	}

	/**
	 * Render admin page
	 */
	public function render_admin_page() {
		$current_group = $this->get_current_group();

		$final_class = array(
			'wrap',
		);

		if ( ! bunchy_is_normal_mode_enabled() ) {
			$final_class[] = 'g1ui-wrap-simplified';
		}

		?>
		<div class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $final_class ) ); ?>">
			<div class="g1ui-settings">
				<?php $this->render_settings_nav( $current_group ); ?>

				<form id="theme-options-form" action="options.php" method="post" enctype="multipart/form-data">
					<?php settings_fields( $this->get_option_name() ); ?>
					<?php $this->render_settings_sections( $this->get_page() ); ?>

					<div class="g1ui-settings-toolbar">
						<input class="button button-primary" name="Submit" type="submit"
						       value="<?php esc_attr_e( 'Save Changes', 'bunchy' ); ?>"/>
					</div>
				</form>
			</div>
		</div>
	<?php
	}

	/**
	 * Render settings
	 *
	 * @param string $page Settings page.
	 */
	public function render_settings_sections( $page ) {
		global $wp_settings_sections, $wp_settings_fields;

		if ( ! isset( $wp_settings_sections[ $page ] ) ) {
			return;
		}

		foreach ( (array) $wp_settings_sections[ $page ] as $section ) {
			// Skip if there are no fields.
			if ( ! isset( $wp_settings_fields ) || ! isset( $wp_settings_fields[ $page ] ) || ! isset( $wp_settings_fields[ $page ][ $section['id'] ] ) ) {
				continue;
			}

			$current_section_id = 'g1ui-settings-section-' . $this->get_current_group();
			$current_section_id .= $this->get_current_section() ? '-' . $this->get_current_section() : '';

			$display_type = ( $section['id'] === $current_section_id ) ? 'block' : 'none';

			echo '<div id="' . esc_attr( $section['id'] ) . '" class="g1ui-settings-section" style="display: ' . esc_attr( $display_type ) . ';">';

			if ( $section['title'] ) {
				echo '<h3>' . esc_html( $section['title'] ) . '</h3>' . "\n";
			}

			if ( $section['callback'] ) {
				call_user_func( $section['callback'], $section );
			}

			echo '<table class="form-table">';
			do_settings_fields( $page, $section['id'] );
			echo '</table>';

			echo '</div>';
		}
	}

	/**
	 * Check whether dashboard section should be accessible
	 *
	 * @return bool
	 */
	public function is_dashboard_enabled() {
		return ! defined( 'BUNCHY_WHITE_LABEL' ) || BUNCHY_WHITE_LABEL === false;
	}

	/**
	 * Register options
	 */
	public function register_options() {
		register_setting(
			$this->get_option_name(),           // A settings group name.
			$this->get_option_name(),           // The name of an option to sanitize and save.
			''
		);

		require( BUNCHY_ADMIN_DIR . 'theme-options/theme-defaults.php' );

		if ( $this->is_dashboard_enabled() ) {
			require_once( BUNCHY_ADMIN_DIR . 'theme-options/theme-options-dashboard.php' );
		}

		require_once( BUNCHY_ADMIN_DIR . 'theme-options/theme-options-import-export.php' );
		require_once( BUNCHY_ADMIN_DIR . 'theme-options/theme-options-dynamic-styles.php' );
		require_once( BUNCHY_ADMIN_DIR . 'theme-options/theme-options-tasks.php' );
	}

	/**
	 * Render empty field
	 */
	public function render_empty_field() {
	}

	/**
	 * Render input HTML control
	 *
	 * @param array $args   Options.
	 */
	public function render_input( $args ) {
		$placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
		$size        = isset( $args['size'] ) ? $args['size'] : 40;

		$vars = $this->get_field_vars( $args );

		$value              = $vars['value'];
		$html_field_name    = $vars['html_field_name'];

		$this->render_field_errors( $args );

		?>
		<input type="text" name="<?php echo esc_attr( $html_field_name ); ?>" size="<?php echo esc_attr( $size ); ?>"
		       value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>"/>
		<?php
		$this->render_field_hint( $args );
	}

	/**
	 * Render file upload HTML control
	 *
	 * @param array $args Options.
	 */
	public function render_upload_input( $args ) {
		$vars = $this->get_field_vars( $args );

		$value              = $vars['value'];
		$html_field_name    = $vars['html_field_name'];

		$this->render_field_errors( $args );

		if ( ! is_array( $value ) ) {
			$value = array(
				'id'   => '',
				'path' => '',
			);
		}

		?>
		<div class="g1-media-upload-field">
			<div class="g1-media-upload-preview"><?php if ( ! empty( $value['path'] ) ) : ?><img
					src="<?php echo esc_url( $value['path'] ) ?>" /><?php endif; ?></div>
			<a href="#" class="button g1-media-upload-button"
			   title="<?php esc_html_e( 'Select an image', 'bunchy' ); ?>">
				<span class="wp-media-buttons-icon"></span><?php esc_html_e( 'Select an image', 'bunchy' ); ?>
			</a>
			<input class="g1-media-upload-input" name="<?php echo esc_attr( $html_field_name . '[id]' ); ?>"
			       type="hidden" value="<?php echo esc_attr( $value['id'] ); ?>"/>
			<input class="g1-media-upload-image-path" name="<?php echo esc_attr( $html_field_name . '[path]' ); ?>"
			       type="hidden" value="<?php echo esc_attr( $value['path'] ); ?>"/>
			<a href="#" class="button g1-clear-button"><?php esc_html_e( 'Clear', 'bunchy' ); ?></a>
		</div>

		<?php $this->render_field_hint( $args ); ?>
	<?php
	}

	/**
	 * Render select HTML control
	 *
	 * @param array $args Options.
	 */
	public function render_select( $args ) {
		$vars = $this->get_field_vars( $args );

		$value              = $vars['value'];
		$html_field_name    = $vars['html_field_name'];
		$html_class         = $vars['html_class'];
		$options            = $vars['options'];

		$this->render_field_errors( $args );

		if ( isset( $with_empty_option ) ) {
			$options = array( '' => $with_empty_option ) + $options;
		}

		$html_class_size = isset( $html_class_size ) ? $html_class_size : 'g1ui-select-m';
		$html_id_attr    = '';

		if ( isset( $html_id ) ) {
			$html_id_attr = 'id="' . esc_attr( $html_id ) . '"';
		}

		?>
		<select
			<?php echo esc_attr( $html_id_attr ); ?>class="<?php echo sanitize_html_class( $html_class_size ); ?> <?php echo implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $html_class ) ) ); ?>"
			name="<?php echo esc_attr( $html_field_name ); ?>">
			<?php foreach ( $options as $option_value => $option_label ) : ?>
				<?php if ( is_array( $option_label ) ) : ?>
					<optgroup label="<?php echo esc_attr( $option_value ); ?>">
						<?php foreach ( $option_label as $sub_option_value => $sub_option_label ) : ?>
							<option
								value="<?php echo esc_attr( $sub_option_value ); ?>"<?php selected( $sub_option_value, $value ); ?>><?php echo esc_html( $sub_option_label ); ?></option>
						<?php endforeach; ?>
					</optgroup>
				<?php else : ?>
					<option
						value="<?php echo esc_attr( $option_value ); ?>"<?php selected( $option_value, $value ); ?>><?php echo esc_html( $option_label ); ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
		<?php
		$this->render_field_hint( $args );
	}

	/**
	 * Render textarea HTML control
	 *
	 * @param array $args Options.
	 */
	public function render_textarea( $args ) {
		$vars = $this->get_field_vars( $args );

		$value              = $vars['value'];
		$html_field_name    = $vars['html_field_name'];
		$this->render_field_errors( $args );

		$rows = isset( $rows ) ? $rows : 10;
		$cols = isset( $cols ) ? $cols : 40;

		?>
		<textarea name="<?php echo esc_attr( $html_field_name ); ?>" rows="<?php echo esc_attr( $rows ); ?>"
		          cols="<?php echo esc_attr( $cols ); ?>"><?php echo esc_html( $value ); ?></textarea>
		<?php
		$this->render_field_hint( $args );
	}

	/**
	 * Wrap table row into full width row
	 *
	 * @param string $html      Input HTML.
	 *
	 * @return string           Output HTML.
	 */
	public function wrap_into_full_width_row( $html ) {
		return
			'</th><td></td></tr>
			<tr class="g1ui-form-table-row-full"><th scope="row" colspan="2">' .
			$html .
			'</th></tr>
			<tr><th scope="row">';
	}

	/**
	 * Export option to file
	 *
	 * @param array $options    Options to save.
	 */
	public function export_options_to_file( $options ) {
		require_once BUNCHY_ADMIN_DIR . 'lib/class-bunchy-import-export.php';

		$data = Bunchy_Import_Export::export_options( $options );

		header( 'Content-Description: File Transfer' );
		header( 'Content-type: application/txt' );
		header( 'Content-Disposition: attachment; filename="theme-options-' . date( 'YmdHis' ) . '.txt"' );
		header( 'Content-Transfer-Encoding: binary' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate' );
		header( 'Pragma: public' );
		echo wp_json_encode( $data );
		exit;
	}

	/**
	 * Import options from file
	 *
	 * @param string $filename  File path.
	 */
	public function import_options_from_file( $filename ) {
		require_once BUNCHY_ADMIN_DIR . 'lib/class-bunchy-import-export.php';

		if ( Bunchy_Import_Export::import_options_from_file( $filename ) ) {
			set_transient( 'bunchy_import_theme_options_status_ok', esc_html__( 'All options imported successfuly.', 'bunchy' ) );
		}
	}

	/**
	 * Handle post request
	 */
	protected function handle_import_theme_options() {
		if ( isset( $_FILES['g1_theme_options_file'] ) ) {  // Input var okey.
			$bunchy_file_uploaded_ok = UPLOAD_ERR_OK === $_FILES['g1_theme_options_file']['error']; // Input var okey.

			if ( $bunchy_file_uploaded_ok ) {
				$this->import_options_from_file( sanitize_text_field( wp_unslash( $_FILES['g1_theme_options_file']['tmp_name'] ) ) );    // Input var okey.
			}
		}
	}

	/**
	 * Handle export options to file
	 */
	protected function handle_export_theme_options() {
		if ( isset( $_GET['export'] ) && 'theme-options' === $_GET['export'] ) { // Input var okey.
			$bunchy_options_to_export = array();

			// Customizer options.
			$bunchy_options_to_export[] = bunchy_get_theme_id();

			// Theme options.
			$bunchy_options_to_export[] = bunchy_get_theme_options_id();

			$this->export_options_to_file( $bunchy_options_to_export );
		}
	}

	/**
	 * Handle tasks
	 */
	protected function handle_tasks() {
		$action = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );

		if ( $action && 'run-task' === $action ) { // Input var okey.
			check_admin_referer( 'bunchy-task' );

			$task_id = filter_input( INPUT_GET, 'task', FILTER_SANITIZE_STRING );

			switch ( $task_id ) {
				case 'bunchy_update_popular_posts':
					bunchy_calculate_popular_posts();
					set_transient( 'bunchy_task_executed', esc_html__( 'Popular posts generated successfully.', 'bunchy' ) );
					break;

				case 'bunchy_update_hot_posts':
					bunchy_calculate_hot_posts();
					set_transient( 'bunchy_task_executed', esc_html__( 'Hot posts generated successfully.', 'bunchy' ) );
					break;

				case 'bunchy_update_trending_posts':
					bunchy_calculate_trending_posts();
					set_transient( 'bunchy_task_executed', esc_html__( 'Trending posts generated successfully.', 'bunchy' ) );
					break;
			}
		}
	}

	/**
	 * Return field variables (value, html_id etc)
	 *
	 * @param array $args   Arguments.
	 *
	 * @return array
	 */
	protected function get_field_vars( $args ) {
		$options       = get_option( $this->get_option_name() );
		$is_component  = ! empty( $args['component_name'] );
		$default_value = isset( $args['default_value'] ) ? $args['default_value'] : '';
		$html_class    = isset( $args['html_class'] ) ? $args['html_class'] : '';
		$html_id       = isset( $args['html_id'] ) ? $args['html_id'] : '';

		if ( $is_component ) {
			$component_name = $args['component_name'];
			$field_name     = $args['field_name'];

			$option_exists = isset( $options[ $component_name ] ) && isset( $options[ $component_name ][ $field_name ] );

			$value = $option_exists ? $options[ $component_name ][ $field_name ] : $default_value;

			$html_field_name = sprintf( '%s[%s][%s]', $this->get_option_name(), $component_name, $field_name );

			if ( empty( $html_id ) ) {
				$html_id = $component_name . '-' . $field_name;
			}
		} else {
			$field_name      = $args['field_name'];
			$value           = isset( $options[ $field_name ] ) ? $options[ $field_name ] : $default_value;
			$html_field_name = sprintf( '%s[%s]', $this->get_option_name(), $field_name );

			if ( empty( $html_id ) ) {
				$html_id = $field_name;
			}
		}

		$vars = array(
			'value'           => $value,
			'is_component'    => $is_component,
			'html_field_name' => $html_field_name,
			'html_class'      => $html_class,
			'html_id'         => $html_id,
		);

		return array_merge( $args, $vars );
	}

	/**
	 * Return form errors
	 *
	 * @return array
	 */
	protected function get_form_errors() {
		// Load only once.
		if ( ! isset( $this->form_errors ) ) {
			$errors = get_settings_errors();

			$this->form_errors = array();

			foreach ( $errors as $error ) {
				if ( 'error' === $error['type'] ) {
					if ( ! isset( $this->form_errors[ $error['setting'] ] ) ) {
						$this->form_errors[ $error['setting'] ] = array();
					}

					$this->form_errors[ $error['setting'] ][] = $error;
				}
			}
		}

		return $this->form_errors;
	}

	/**
	 * Return filed assigned errors
	 *
	 * @param array $args   Options.
	 *
	 * @return array
	 */
	protected function get_field_errors( $args ) {
		$errors = $this->get_form_errors();

		if ( ! empty( $args['component_name'] ) ) {
			$field_name = $args['component_name'];
		} else {
			$field_name = $args['field_name'];
		}

		if ( isset( $errors[ $field_name ] ) ) {
			return $errors[ $field_name ];
		}

		return array();
	}

	/**
	 * Capture field assigned errors
	 *
	 * @param array $args       Options.
	 *
	 * @return string
	 */
	protected function capture_field_errors( $args ) {
		$errors = $this->get_field_errors( $args );

		$out = '';

		if ( ! empty( $errors ) ) {
			$out .= '<ul>';

			foreach ( $errors as $error ) {
				$out .= '<li>';
				$out .= $error['message'];
				$out .= '</li>';
			}

			$out .= '</ul>';
		}

		return $out;
	}

	/**
	 * Render field assigned errors
	 *
	 * @param array $args       Options.
	 */
	protected function render_field_errors( $args ) {
		echo wp_kses_post( $this->capture_field_errors( $args ) );
	}

	/**
	 * Render field hint
	 *
	 * @param array $args   Options.
	 */
	protected function render_field_hint( $args ) {
		if ( ! isset( $args['hint'] ) ) {
			return;
		}
		?>
		<p class="description"><?php echo wp_kses_post( $args['hint'] ); ?></p>
	<?php
	}
}

/**
 * Get instance of the class
 *
 * @return Bunchy_Theme_Options
 */
function bunchy_theme_options() {
	return Bunchy_Theme_Options::get_instance();
}

bunchy_theme_options();
