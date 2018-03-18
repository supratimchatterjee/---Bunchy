<?php
/**
 * Wordpress Popular Posts plugin functions
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
 * Display notices if Loco configuration is not enough
 */
function bunchy_loco_notices() {
	$page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );

	$is_loco_page = 'loco-translate' === $page;

	// Skip if not on Loco admin page.
	if ( ! $is_loco_page ) {
		return;
	}

	$loco_name = filter_input( INPUT_GET, 'name', FILTER_SANITIZE_STRING );
	$loco_type = filter_input( INPUT_GET, 'type', FILTER_SANITIZE_STRING );

	// Skip not on Bunchy theme translation init page.
	if ( bunchy_get_theme_name() !== $loco_name || 'theme' !== $loco_type ) {
		return;
	}

	loco_require( 'loco-locales', 'loco-packages' );

	// Skip if Loco class missing.
	if ( ! class_exists( 'LocoPackage' ) ) {
		return;
	}

	$package = LocoPackage::get( $loco_name, $loco_type );

	if ( empty( $package ) ) {
		return;
	}

	$global_dir = $package->global_lang_dir();

	if ( ! is_writeable( $global_dir ) ) :
	?>
		<div class="updated is-dismissible error bunchy-translation-not-allowed">
			<p>
				<strong><?php echo esc_url( $global_dir ); ?> <?php esc_html_e( 'IS NOT WRITABLE. TRANSLATION NOT ALLOWED!', 'bunchy' ); ?></strong><br/>
			</p>
			<p>
				<?php printf( wp_kses_post( __( 'Please read how to fix this problem in the <a href="%s" target="_blank">documentation</a>.', 'bunchy' ) ), esc_url( 'http://docs.bunchy.bringthepixel.com/#g1docs-translation-forbidden' ) ); ?>
			</p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'bunchy' ); ?></span></button>
		</div>
	<?php
	endif;
}

/**
 * Enqueue Loco plugin related scripts
 *
 * @param string $hook      Current screen.
 */
function bunchy_logo_admin_enqueue_scripts( $hook ) {
	if ( false !== strpos( $hook, 'loco-translate' ) ) {
		wp_enqueue_script( 'bunchy-loco-translate', BUNCHY_PLUGINS_DIR_URI . 'js/loco-translate.js', array( 'jquery' ), bunchy_get_theme_version(), true );

		// Prepare js config.
		$config = array(
			'locale' => get_locale(),
			'locale_warning' => sprintf( esc_html( 'Warning. This language code differs from the WP Admin > Settings > General > Site Language code (%s). If you want to load this translation both codes needs to be the same.', 'bunchy' ), get_locale() ),
		);

		wp_localize_script( 'bunchy-loco-translate', 'bunchy_loco_translate_config', wp_json_encode( $config ) );
	}
}
