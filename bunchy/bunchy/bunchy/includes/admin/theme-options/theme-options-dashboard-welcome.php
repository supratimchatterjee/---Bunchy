<?php
/**
 * Theme options "Welcome" section (demo data installation step)
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


add_settings_section(
	$section_id,                        // ID used to identify this section and with which to register options.
	'',        // Title to be displayed on the administration page.
	null,
	$this->get_page()                   // Page on which to add this section of options.
);

add_settings_field(
	'theme_dashboard_welcome',
	'',
	'bunchy_render_theme_dashborad_welcome_section',
	$this->get_page(),
	$section_id
);

/**
 * Render dashboard welcome section
 */
function bunchy_render_theme_dashborad_welcome_section() {
	$plugins = bunchy_get_theme_plugins_config();
	$nonce                    = wp_create_nonce( 'bunchy-change-mode-ajax-nonce' );
	$installation_in_progress = bunchy_is_in_progress_mode_enabled();

	/**
	 * Automatic plugin installation and activation library
	 *
	 * @var TGM_Plugin_Activation $tgmpa
	 */
	global $tgmpa;

	// Set flag to remove importer after finishing (if it was not installed before).
	if ( ! $tgmpa->is_plugin_installed( 'wordpress-importer' ) ) {
		// Set only once.
		if ( false === get_transient( 'bunchy_wp_importer_not_installed' ) ) {
			set_transient( 'bunchy_wp_importer_not_installed', true );
		}
	}
	?>
	</td></tr>
	<tr>
	<td colspan="2" style="padding-left: 0;">

	<div style="margin-top: -3em;"></div>

	<div class="about-wrap">
		<h1><?php esc_html_e( 'Welcome to Bunchy - Viral WordPress Theme with Open Lists', 'bunchy' ); ?></h1>
		<div
			class="about-text"><?php esc_html_e( 'You are almost there. Just two easy steps before publishing.', 'bunchy' ); ?></div>

		<?php
		$plugins_to_install = array();

		foreach ( $plugins as $plugin ) {
			// Skip if plugin already intalled and activated.
			if ( $tgmpa->is_plugin_active( $plugin['slug'] ) ) {
				continue;
			}

			$action = 'install';

			// If not installed.
			if ( ! $tgmpa->is_plugin_installed( $plugin['slug'] ) ) {
				$action = 'install';
				// If installed but not activated.
			} elseif ( $tgmpa->can_plugin_activate( $plugin['slug'] ) ) {
				$action = 'activate';
			}

			$plugins_to_install[] = array(
				'slug'        => $plugin['slug'],
				'name'        => str_replace( 'G1 ', '', $plugin['name'] ),
				'description' => isset( $plugin['description'] ) ? $plugin['description'] : '',
				'install_url' => esc_url(
					wp_nonce_url(
						add_query_arg(
							array(
								'plugin'           => urlencode( $plugin['slug'] ),
								'tgmpa-' . $action => $action . '-plugin',
							),
							$tgmpa->get_tgmpa_url()
						),
						'tgmpa-' . $action,
						'tgmpa-nonce'
					)
				),
			);
		}
		?>

		<?php if ( ! empty( $plugins_to_install ) ) : ?>
			<h4><?php esc_html_e( 'Select plugins to install', 'bunchy' ); ?></h4>
			<div class="g1ui-plugicons">
				<?php foreach ( $plugins_to_install as $plugin ) : ?>
					<div
						class="g1ui-plugicon g1ui-plugicon-<?php echo sanitize_html_class( $plugin['slug'] ); ?> g1ui-plugicon-checked">
						<span class="g1ui-plugicon-icon"></span>
						<span class="g1ui-plugicon-title"><?php echo esc_html( $plugin['name'] ); ?></span>
						<span class="g1ui-plugicon-desc"><?php echo esc_html( $plugin['description'] ); ?></span>

						<div class="g1ui-plugicon-bar">
							<input type="checkbox" class="g1-plugin-to-install g1ui-plugicon-checkbox"
							       name="<?php echo esc_attr( $plugin['slug'] ); ?>"
							       data-g1-install-url="<?php echo esc_url( $plugin['install_url'] ); ?>"
							       checked="checked"/>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<h4><?php esc_html_e( 'Select dummy data to import', 'bunchy' ); ?></h4>

		<div class="g1ui-demicons">
			<div class="g1ui-plugicon g1ui-plugicon-daily g1ui-plugicon-checked">
				<span class="g1ui-plugicon-icon"></span>
				<span class="g1ui-plugicon-title"><?php esc_html_e( 'All data', 'bunchy' ); ?></span>
				<span class="g1ui-plugicon-desc"><?php esc_html_e( 'Content and Theme Options', 'bunchy' ); ?></span>

				<div class="g1ui-plugicon-bar">
					<input type="checkbox" class="g1-demo-to-install g1ui-plugicon-checkbox" name="demo" value="main"
					       data-g1-install-url="<?php echo esc_url( bunchy_get_import_demo_all_url() ); ?>"
					       checked="checked"/>
				</div>
			</div>
		</div>

		<button id="g1-install-demo-data"
		        class="button button-primary button-hero"><?php $installation_in_progress ? esc_html_e( 'Continue', 'bunchy' ) : esc_html_e( 'Proceed', 'bunchy' ); ?></button>
		<button id="g1-skip-demo-data" class="button button-hero"><?php esc_html_e( 'Skip', 'bunchy' ); ?></button>
		<input type="hidden" id="g1-change-mode-ajax-nonce" value="<?php echo esc_attr( $nonce ); ?>"/>
	</div>
	<?php
}
