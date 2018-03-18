<?php
/**
 * Class for setting up demo data
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

if ( ! class_exists( 'Bunchy_Demo_Data' ) ) {
	/**
	 * Class Bunchy_Demo_Data
	 */
	class Bunchy_Demo_Data {

		/**
		 * Import theme content, widgets and assigns menus
		 *
		 * @return array        Response: status, message
		 */
		public function import_content() {

			require_once( BUNCHY_ADMIN_DIR . 'lib/class-bunchy-import-export.php' );

			$content_path = trailingslashit( get_template_directory() ) . 'dummy-data/dummy-data.xml.gz';

			$importer_out = Bunchy_Import_Export::import_content_from_file( $content_path );

			// Demo content imported successfully?
			if ( null !== $importer_out ) {
				$response = array(
					'status'  => 'success',
					'message' => $importer_out,
				);

				// Set up menus.
				$this->assign_menus();

				// Import widgets.
				$widgets_path = trailingslashit( get_template_directory() ) . 'dummy-data/widgets.txt';

				Bunchy_Import_Export::import_widgets_from_file( $widgets_path );

				do_action( 'bunchy_after_import_content' );
			} else {
				$response = array(
					'status'  => 'error',
					'message' => esc_html__( 'Failed to import content', 'bunchy' ),
				);
			}

			return $response;
		}

		/**
		 * Import theme options
		 *
		 * @return array            Response status and message
		 */
		public function import_theme_options() {

			require_once( BUNCHY_ADMIN_DIR . 'lib/class-bunchy-import-export.php' );

			$demo_options_path = trailingslashit( get_template_directory() ) . 'dummy-data/theme-options.txt';

			if ( Bunchy_Import_Export::import_options_from_file( $demo_options_path ) ) {
				$this->set_theme_options_images_paths();

				$response = array(
					'status'  => 'success',
					'message' => esc_html__( 'Theme options imported successfully.', 'bunchy' ),
				);
			} else {
				$response = array(
					'status'  => 'error',
					'message' => esc_html__( 'Failed to import theme options', 'bunchy' ),
				);
			}

			return $response;
		}

		/**
		 * Import theme options and content
		 *
		 * @return array        Response status and message
		 */
		public function import_all() {
			$content_response = $this->import_content();

			if ( 'error' === $content_response['status'] ) {
				return $content_response;
			}

			$theme_options_response = $this->import_theme_options();

			if ( 'error' === $theme_options_response['status'] ) {
				return $theme_options_response;
			}

			// If all goes well.
			$response = array(
				'status'  => 'success',
				'message' => esc_html__( 'Import completed successfully.', 'bunchy' ),
			);

			return $response;
		}

		/**
		 * Assign menus to locations
		 */
		protected function assign_menus() {
			$menu_location = array(
				'PrimaryMenu' => 'bunchy_primary_nav',
				'UserNavigation' => 'bunchy_user_nav',
				'FooterMenu'  => 'bunchy_footer_nav',
			);

			$registered_locations = get_registered_nav_menus();
			$locations            = get_nav_menu_locations();

			foreach ( $menu_location as $menu => $location ) {
				if ( empty( $menu ) && isset( $locations[ $location ] ) ) {
					unset( $locations[ $location ] );
					continue;
				}

				$menu_obj = wp_get_nav_menu_object( $menu );

				if ( ! $menu_obj || is_wp_error( $menu_obj ) ) {
					printf( esc_html__( 'Invalid menu "%s".', 'bunchy' ), esc_html( $menu ) );
					continue;
				}

				if ( ! array_key_exists( $location, $registered_locations ) ) {
					printf( esc_html__( 'Invalid location "%s".', 'bunchy' ), esc_html( $location ) );
					continue;
				}

				$locations[ $location ] = $menu_obj->term_id;
			}

			set_theme_mod( 'nav_menu_locations', $locations );
		}

		/**
		 * Change images paths.
		 */
		protected function set_theme_options_images_paths() {
			$theme_id = bunchy_get_theme_id();
			$options = get_option( $theme_id );

			$title_option_map = array(
				'theme_logo'        => 'branding_logo',
				'theme_logo-2x'     => 'branding_logo_hdpi',
				'_footer_stamp'     => 'footer_stamp',
				'_footer_stamp-2x'  => 'footer_stamp_hdpi',
			);

			foreach ( $title_option_map as $title => $option_name ) {
				$attachment = get_page_by_title( $title, OBJECT, 'attachment' );

				if ( $attachment ) {
					$options[ $option_name ] = wp_get_attachment_url( $attachment->ID );
				}
			}

			update_option( $theme_id, $options );
		}
	}
}
