<?php
/**
 * Theme options "Dashboard" section
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


$section_id = 'g1ui-settings-section-dashboard';

if ( bunchy_is_normal_mode_enabled() ) {
	include 'theme-options-dashboard-normal.php';
} else {
	include 'theme-options-dashboard-welcome.php';
}
