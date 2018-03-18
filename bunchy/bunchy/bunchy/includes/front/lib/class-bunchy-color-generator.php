<?php
/**
 * Class for generating color based on other color
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


if ( ! class_exists( 'Bunchy_Color_Generator' ) ) :

	// Load necessary dependencies.
	require_once( BUNCHY_FRONT_DIR . 'lib/class-bunchy-color.php' );

	/**
	 * Class Bunchy_Color_Generator
	 */
	class Bunchy_Color_Generator {

		/**
		 * Get lighter color
		 *
		 * @param Bunchy_Color $color Color object.
		 */
		public static function get_light_color( Bunchy_Color $color ) {

		}

		/**
		 * Get darker color
		 *
		 * @param Bunchy_Color $color Color object.
		 */
		public static function get_dark_color( Bunchy_Color $color ) {

		}

		/**
		 * Get warmer color
		 *
		 * @param Bunchy_Color $color Color object.
		 */
		public static function get_warm_color( Bunchy_Color $color ) {

		}

		/**
		 * Get light gradient
		 *
		 * @param Bunchy_Color $color Color object.
		 */
		public static function get_light_gradient( Bunchy_Color $color ) {

		}

		/**
		 * Get dark gradient
		 *
		 * @param Bunchy_Color $color Color object.
		 */
		public static function get_dark_gradient( Bunchy_Color $color ) {

		}


		/**
		 * Get warm gradient
		 *
		 * @param Bunchy_Color $color Color object.
		 *
		 * @return array An array of 2 colors
		 */
		public static function get_warm_gradient( Bunchy_Color $color ) {
			$from = clone $color;
			if ( $from->get_lightness() > 80 ) {
				$from->set_lightness( $from->get_lightness() - 15 );
			}

			$to = clone $from;

			$h1 = $to->get_hue();
			$s1 = $to->get_saturation();
			$l1 = $to->get_lightness();

			$h2 = $h1;
			$s2 = $s1;
			$l2 = $l1;

			if ( $s2 ) {
				$s2 += 15;
				if ( $s2 > 100 ) {
					$s2 = 100;
				}
			}

			$l2 += 15;
			if ( $l2 > 100 ) {
				$l2 = 100;
			}

			$from->set_hsl( array( $h2, $s2, $l2 ) );

			return array( $from, $to );
		}


		/**
		 * Get tone color
		 *
		 * @param Bunchy_Color $color Color object.
		 * @param int          $delta Maximum lightness change.
		 * @param int          $breakpoint Lightness breakpoint.
		 *
		 * @return Bunchy_Color
		 */
		public static function get_tone_color( Bunchy_Color $color, $delta = 10, $breakpoint = 50 ) {
			$out       = clone $color;
			$lightness = $color->get_lightness();

			if ( $lightness <= $breakpoint ) {
				$lightness += ( $lightness + $delta ) > 100 ? - $delta : $delta;
			} else {
				$lightness -= ( $lightness + $delta ) < 0 ? - $delta : $delta;
			}

			$out->set_lightness( $lightness );

			return $out;
		}
	}
endif;
