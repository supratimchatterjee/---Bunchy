<?php
/**
 * Theme options "Dashboard" section (after passing demo data step)
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
	'theme_dashboard_normal',
	'',
	'bunchy_render_theme_dashborad_normal_section',
	$this->get_page(),
	$section_id
);

/**
 * Render dashborad section (after passing demo data step)
 */
function bunchy_render_theme_dashborad_normal_section() {
	?>
	</td></tr>
	<tr>
	<td colspan="2" style="padding-left: 0;">

	<div style="margin-top: -3em;"></div>


	<?php
	if ( get_transient( 'bunchy_demo_data_imported' ) ) {
		delete_transient( 'bunchy_demo_data_imported' );
		delete_transient( 'bunchy_import_demo_response' ); // Transient set by import demo action, we don't want to show it now.
		?>
		<h1 class="g1-demo-imported-congrats"><?php esc_html_e( 'Congratulations!', 'bunchy' ); ?></h1>
		<div class="about-text">
			<?php esc_html_e( 'Demo site was set up and it\'s ready to customize. We hope you will enjoy it. Have fun.', 'bunchy' ); ?>
		</div>
		<?php
	}
	?>

	<h3><?php esc_html_e( 'Join our community', 'bunchy' ); ?></h3>

	<div class="g1ui-cols">
		<div class="g1ui-col">
			<h4><?php esc_html_e( 'Never miss a news', 'bunchy' ); ?></h4>
			<p><?php printf( wp_kses_post( __( 'Stay up to date with all upcoming updates, important notes and announcements. Follow us on <a href="%s" target="_blank">Facebook</a> or <a href="%s" target="_blank">Twitter</a>.', 'bunchy' ) ), esc_url( 'http://on.fb.me/1KmhAov' ), esc_url( 'http://bit.ly/1eiKcmX' ) ); ?></p>
		</div>

		<div class="g1ui-col">
			<h4><?php esc_html_e( 'Help us improve the theme', 'bunchy' ); ?></h4>
			<p><?php printf( wp_kses_post( __( 'Have a feature request, some improvement idea or want to just share with your thoughts. Don\'t hesitate to <a href="mailto:%s" target="_blank">contact with us</a>.', 'bunchy' ) ), esc_attr( 'we@bringthepixel.com' ) ); ?></p>
		</div>

		<div class="g1ui-col">
			<h4><?php esc_html_e( 'Rate the theme', 'bunchy' ); ?></h4>
			<p><?php printf( wp_kses_post( __( 'If you are happy with our theme and support, please don\'t forget to rate the theme on <a href="%s" target="_blank">ThemeForest</a>. Thanks in advance.', 'bunchy' ) ), esc_url( 'http://themeforest.net/downloads' ) ) ?></p>
		</div>
	</div>

	<h3><?php esc_html_e( 'What\'s next?', 'bunchy' ); ?></h3>

	<div class="g1ui-cols">
		<div class="g1ui-col">
			<h4><?php esc_html_e( 'Showcase your work', 'bunchy' ); ?></h4>
			<p><?php printf( wp_kses_post( __( 'When you finish your site, we will be really glad to see the result. Send its live url to our <a href="mailto:%s" target="_blank">mailbox</a>.', 'bunchy' ) ), esc_attr( 'we@bringthepixel.com' ) ); ?></p>
		</div>

		<div class="g1ui-col">
			<h4><?php esc_html_e( 'Buy another license', 'bunchy' ); ?></h4>
			<p><?php printf( wp_kses_post( __( 'Happy with the theme so far? Buy another license and set up a new site.', 'bunchy' ) ), esc_url( 'http://themeforest.net/user/bringthepixel/portfolio' ) ); ?></p>
		</div>
	</div>

	<h3><?php esc_html_e( 'Need some help?', 'bunchy' ); ?></h3>

	<div class="g1ui-cols">
		<div class="g1ui-col">
			<h4><?php esc_html_e( 'Check online documentation', 'bunchy' ); ?></h4>
			<p><?php printf( wp_kses_post( __( 'All information about theme installation, configuration and customization can be found in our <a href="%s" target="_blank">online documentation</a>.', 'bunchy' ) ), esc_url( 'http://docs.'. bunchy_get_theme_name() .'.bringthepixel.com' ) ); ?></p>
		</div>

		<div class="g1ui-col">
			<h4><?php esc_html_e( 'Use support forum', 'bunchy' ); ?></h4>
			<p><?php printf( wp_kses_post( __( 'Support is conducted through our <a href="%s" target="_blank">support forum</a>, where you can submit your questions, bug-findings, etc.', 'bunchy' ) ), esc_url( 'http://bit.ly/216mwJq' ) ); ?></p>
		</div>
	</div>

	<?php
}
