<?php
/**
 * Class for importing/exporting theme data (options, widgets)
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

if ( ! class_exists( 'Bunchy_Import_Export' ) ) {
	/**
	 * Class Bunchy_Import_Export
	 */
	class Bunchy_Import_Export {

		/**
		 * Import theme content (posts, pages, images etc). Compatible with data exported from WP Exporter
		 *
		 * @param string $path      Path to content file.
		 *
		 * @return null|string      Importer output if successed, null if failed
		 */
		public static function import_content_from_file( $path ) {
			$out = null;

			// Is importer class loaded?
			if ( class_exists( 'WP_Import' ) ) {
				add_filter( 'wp_import_posts', array( 'Bunchy_Import_Export', 'change_attachment_path' ), 10, 2 );

				// Import.
				$importer = new WP_Import();

				$importer->fetch_attachments = true;

				ob_start();
				$importer->import( $path );
				$out = ob_get_clean();
			}

			return $out;
		}

		/**
		 * Replace absolute path without url address, with absolute url to local installation
		 *
		 * @param array $posts      Post to import.
		 *
		 * @return array            Modified posts.
		 */
		public static function change_attachment_path( $posts ) {
			foreach ( $posts as $index => $post ) {
				if ( 'attachment' === $post['post_type'] ) {
					$remote_url = ! empty( $post['attachment_url'] ) ? $post['attachment_url'] : $post['guid'];

					// If the URL is absolute, but does not contain address, then upload it assuming base_site_url.
					if ( preg_match( '|^/[\w\W]+$|', $remote_url ) ) {
						$remote_url = rtrim( get_home_url(), '/' ) . $remote_url;

						$posts[ $index ]['attachment_url'] = $remote_url;
					}
				}
			}

			return $posts;
		}

		/**
		 * Import options into database
		 *
		 * @param string $content       JSON encoded string.
		 *
		 * @return bool
		 */
		public static function import_options( $content ) {
			$options = json_decode( $content, true );

			if ( $options && is_array( $options ) ) {
				foreach ( $options as $option_name => $option_value ) {
					update_option( $option_name, $option_value );
				}

				return true;
			}

			return false;
		}

		/**
		 * Import options from file
		 *
		 * @param string $path      Path to file.
		 *
		 * @return bool
		 */
		public static function import_options_from_file( $path ) {
			WP_Filesystem();

			/**
			 * Safe way to access filesystem
			 *
			 * @var WP_Filesystem_Base $wp_filesystem
			 */
			global $wp_filesystem;

			$content = $wp_filesystem->get_contents( $path );

			if ( false === $content ) {
				return false;
			}

			return self::import_options( $content );
		}

		/**
		 * Export options
		 *
		 * @param array $options        List of option names to export.
		 *
		 * @return array                Options
		 */
		public static function export_options( $options ) {
			$data = array();

			foreach ( $options as $option ) {
				$option_value = get_option( $option );

				if ( false !== $option_value ) {
					$data[ $option ] = $option_value;
				}
			}

			return $data;
		}

		/**
		 * Import widgets
		 *
		 * @param string $content       JSON encoded widgets data.
		 *
		 * @return bool
		 */
		public static function import_widgets( $content ) {
			$widgets = json_decode( $content, true );

			if ( $widgets && is_array( $widgets ) ) {
				$sidebars_array      = get_option( 'sidebars_widgets' );
				$predefined_sidebars = bunchy_get_predefined_sidebars();
				$custom_sidebars     = get_option( 'bunchy_custom_sidebars', array() );

				foreach ( $widgets as $sidebar_id => $sidebar_widgets ) {
					foreach ( $sidebar_widgets as $widget_id => $widget_data ) {
						$is_not_predefined_sidebar = ! isset( $predefined_sidebars[ $sidebar_id ] );
						$custom_sidebar_not_exists = ! isset( $custom_sidebars[ $sidebar_id ] );

						// Register new custom sidebar.
						if ( $is_not_predefined_sidebar && $custom_sidebar_not_exists ) {
							$custom_sidebars[ $sidebar_id ] = bunchy_get_nice_sidebar_name( $sidebar_id );
						}

						// $widget_id eg. "recent-comments-4".
						$name_parts   = explode( '-', $widget_id );     // $name_parts is an array with keys: recent, comments, 4
						$widget_index = array_pop( $name_parts );       // pop the '4' element off the end of array
						$widget_group = implode( '-', $name_parts );    // merge back existing elements

						$widget_group_data = get_option( 'widget_' . $widget_group );

						// If widget with the same index exists, use next free index.
						if ( isset( $widget_group_data[ $widget_index ] ) ) {
							$offset = max( array_keys( $widget_group_data ) ) + 1;

							$widget_index += $offset;
						}

						$widget_group_data[ $widget_index ] = $widget_data;

						// Save widget data.
						update_option( 'widget_' . $widget_group, $widget_group_data );

						// Assign widget to sidebar.
						if ( ! isset( $sidebars_array[ $sidebar_id ] ) ) {
							$sidebars_array[ $sidebar_id ] = array();
						}

						$sidebars_array[ $sidebar_id ][] = $widget_id;
					}
				}

				// Save widget to sidebar relation.
				update_option( 'sidebars_widgets', $sidebars_array );

				// Save custom sidebars.
				update_option( 'bunchy_custom_sidebars', $custom_sidebars );

				return true;
			}

			return false;
		}

		/**
		 * Import widgets from file
		 *
		 * @param string $path      File path.
		 *
		 * @return bool
		 */
		public static function import_widgets_from_file( $path ) {
			WP_Filesystem();

			/**
			 * Dafe way to access filesystem
			 *
			 * @var WP_Filesystem_Base $wp_filesystem
			 */
			global $wp_filesystem;

			$content = $wp_filesystem->get_contents( $path );

			if ( false === $content ) {
				return false;
			}

			return self::import_widgets( $content );
		}

		/**
		 * Export widgets
		 *
		 * @return array
		 */
		public static function export_widgets() {
			$sidebars_array = get_option( 'sidebars_widgets' );
			$exported       = array();

			foreach ( $sidebars_array as $sidebar => $widgets ) {
				if ( 'wp_inactive_widgets' === $sidebar ) {
					continue;
				}

				if ( ! empty( $widgets ) && is_array( $widgets ) ) {
					$exported[ $sidebar ] = array();

					foreach ( $widgets as $sidebar_widget ) {
						// $sidebar_widget eg. "recent-comments-4".
						$name_parts   = explode( '-', $sidebar_widget );    // $name_parts is an array with keys: recent, comments, 4
						$widget_index = array_pop( $name_parts );           // Pop the '4' element off the end of array.
						$widget_group = implode( '-', $name_parts );        // Merge back existing elements.

						$widget_group_data = get_option( 'widget_' . $widget_group );

						$widget_data = $widget_group_data[ $widget_index ];

						$exported[ $sidebar ][ $sidebar_widget ] = $widget_data;
					}
				}
			}

			return $exported;
		}
	}
}
