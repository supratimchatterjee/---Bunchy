<?php
/**
 * TGM Configuration
 *
 * @package       TGM-Plugin-Activation
 * @subpackage Example
 * @version       2.3.6
 * @author       Thomas Griffin <thomas@thomasgriffinmedia.com>, Gary Jones <gamajo@gamajo.com>
 * @copyright  Copyright (c) 2012, Thomas Griffin
 * @license       http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

define( 'TGM_THEME_DOMAIN', 'bunchy' );

require_once( BUNCHY_ADMIN_DIR . 'lib/class-tgm-plugin-activation.php' );

/**
 * Return theme plugins configuration
 *
 * @return array
 */
function bunchy_get_theme_plugins_config() {
	$theme_dir = trailingslashit( get_template_directory() );

	$config = array(
		array(
			'name'               => esc_html__( 'Snax', 'bunchy' ),
			// The plugin name.
			'slug'               => 'snax',
			// The plugin slug (typically the folder name).
			'description'        => esc_html__( 'Viral front-end uploader', 'bunchy' ),
			'source'             => $theme_dir . 'includes/plugins/zip/snax.zip',
			// The plugin source.
			'required'           => false,
			// If false, the plugin is only 'recommended' instead of required.
			'version'            => '1.4.1',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented.
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '',
			// If set, overrides default API URL and points to an external URL.
		),
		array(
			'name'     => esc_html__( 'BuddyPress', 'bunchy' ),
			// The plugin name.
			'slug'     => 'buddypress',
			// The plugin slug (typically the folder name).
			'description' => esc_html__( '', 'bunchy' ),
			'required' => false,
			// If false, the plugin is only 'recommended' instead of required.
			'version'  => '',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented.
		),
		array(
			'name'     => esc_html__( 'WordPress Social Login', 'bunchy' ),
			// The plugin name.
			'slug'     => 'wordpress-social-login',
			// The plugin slug (typically the folder name).
			'description' => esc_html__( '', 'bunchy' ),
			'required' => false,
			// If false, the plugin is only 'recommended' instead of required.
			'version'  => '',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented.
		),
		array(
			'name'     => esc_html__( 'MailChimp for WordPress', 'bunchy' ),
			// The plugin name.
			'slug'     => 'mailchimp-for-wp',
			// The plugin slug (typically the folder name).
			'required' => false,
			// If false, the plugin is only 'recommended' instead of required.
			'version'  => '',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented.
		),
		array(
			'name'     => esc_html__( 'Mashshare Share Buttons', 'bunchy' ),
			// The plugin name.
			'slug'     => 'mashsharer',
			// The plugin slug (typically the folder name).
			'required' => false,
			// If false, the plugin is only 'recommended' instead of required.
			'version'  => '',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented.
		),
		array(
			'name'          => esc_html__( 'WP QUADS', 'bunchy' ),
			// The plugin name.
			'slug'          => 'quick-adsense-reloaded',
			'description'   => esc_html__( 'Ad manager', 'bunchy' ),
			// The plugin slug (typically the folder name).
			'required'      => false,
			// If false, the plugin is only 'recommended' instead of required.
			'version'       => '',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented.
		),
		array(
			'name'     => esc_html__( 'Wordpress Popular Posts', 'bunchy' ),
			// The plugin name.
			'slug'     => 'wordpress-popular-posts',
			// The plugin slug (typically the folder name).
			'required' => false,
			// If false, the plugin is only 'recommended' instead of required.
			'version'  => '',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented.
		),
		array(
			'name'     => esc_html__( 'WP Subtitle', 'bunchy' ),
			// The plugin name.
			'slug'     => 'wp-subtitle',
			// The plugin slug (typically the folder name).
			'required' => false,
			// If false, the plugin is only 'recommended' instead of required.
			'version'  => '',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented.
		),
		array(
			'name'               => esc_html__( 'G1 Socials', 'bunchy' ),
			// The plugin name.
			'slug'               => 'g1-socials',
			// The plugin slug (typically the folder name).
			'description'        => esc_html__( 'Social media profile icons', 'bunchy' ),
			'source'             => $theme_dir . 'includes/plugins/zip/g1-socials.zip',
			// The plugin source.
			'required'           => false,
			// If false, the plugin is only 'recommended' instead of required.
			'version'            => '1.1.1',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented.
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '',
			// If set, overrides default API URL and points to an external URL.
		),
		array(
			'name'               => esc_html__( 'Envato Market', 'bunchy' ),
			// The plugin name.
			'slug'               => 'envato-market',
			// The plugin slug (typically the folder name).
			'description'        => esc_html__( 'Automatic theme updates', 'bunchy' ),
			'source'             => $theme_dir . 'includes/plugins/zip/envato-market.zip',
			// The plugin source.
			'required'           => false,
			// If false, the plugin is only 'recommended' instead of required.
			'version'            => '',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented.
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '',
			// If set, overrides default API URL and points to an external URL.
		),
	);

	return apply_filters( 'bunchy_tgm_plugins_config', $config );
}

/**
 * Register TGM plugins
 */
function bunchy_register_required_plugins() {
	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = bunchy_get_theme_plugins_config();

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'           => 'bunchy',                    // Text domain - likely want to be the same as your theme.
		'default_path'     => '',                            // Default absolute path to pre-packaged plugins
		'parent_slug'      => 'themes.php',                // Default parent menu slug
		'menu'             => 'install-required-plugins',    // Menu slug
		'has_notices'      => true,                        // Show admin notices or not
		'is_automatic'     => true,                        // Automatically activate plugins after installation or not
		'message'          => '',                            // Message to output right before the plugins table.
		'strings'          => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'bunchy' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'bunchy' ),
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'bunchy' ),
			// %1$s = plugin name
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'bunchy' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'bunchy' ),
			// %1$s = plugin name(s)
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'bunchy' ),
			// %1$s = plugin name(s)
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'bunchy' ),
			// %1$s = plugin name(s)
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'bunchy' ),
			// %1$s = plugin name(s)
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'bunchy' ),
			// %1$s = plugin name(s)
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'bunchy' ),
			// %1$s = plugin name(s)
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'bunchy' ),
			// %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'bunchy' ),
			// %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'bunchy' ),
			'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'bunchy' ),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'bunchy' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'bunchy' ),
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'bunchy' ),
			// %1$s = dashboard link .
			'nag_type'                        => esc_html__( 'updated', 'bunchy' ),
			// Determines admin notice type - can only be 'updated' or 'error'.
		),
	);

	tgmpa( $plugins, $config );
}

/**
 * Register WordPress Importer plugin to install demo data
 *
 * @param array $config     TGP plugins config.
 *
 * @return array
 */
function bunchy_register_wordpress_importer( $config ) {
	if ( ! bunchy_is_normal_mode_enabled() ) {
		$theme_dir = trailingslashit( get_template_directory() );

		$config[] = array(
			'name'               => esc_html__( 'WordPress Importer', 'bunchy' ),
			// The plugin name.
			'slug'               => 'wordpress-importer',
			// The plugin slug (typically the folder name).
			'source'             => $theme_dir . 'includes/plugins/zip/wordpress-importer.zip',
			// The plugin source.
			'required'           => false,
			// If false, the plugin is only 'recommended' instead of required.
			'version'            => '',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented.
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '',
			// If set, overrides default API URL and points to an external URL.
		);
	}

	return $config;
}
