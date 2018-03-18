<?php
/**
 * Header styles
 *
 * @license For the full license information, please view the Licensing folder
 * that was distributed with this source code.
 *
 * @package Bunchy_Theme
 */

$bunchy_filter_hex = array( 'options' => array( 'regexp' => '/^([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/' ) );

$bunchy_logo_margin_top    = (int) bunchy_get_theme_option( 'header', 'logo_margin_top' );
$bunchy_logo_margin_bottom = (int) bunchy_get_theme_option( 'header', 'logo_margin_bottom' );
?>
@media only screen and ( min-width: 801px ) {
.g1-header .g1-id {
margin-top: <?php echo intval( $bunchy_logo_margin_top ); ?>px;
margin-bottom: <?php echo intval( $bunchy_logo_margin_bottom ); ?>px;
}
}


<?php
$bunchy_header_text                 = new Bunchy_Color( bunchy_get_theme_option( 'header', 'text_color' ) );
$bunchy_header_accent               = new Bunchy_Color( bunchy_get_theme_option( 'header', 'accent_color' ) );
$bunchy_header_background           = new Bunchy_Color( bunchy_get_theme_option( 'header', 'background_color' ) );

$bunchy_header_secondary_text       = new Bunchy_Color( bunchy_get_theme_option( 'header', 'secondary_text_color' ) );
$bunchy_header_secondary_background = new Bunchy_Color( bunchy_get_theme_option( 'header', 'secondary_background_color' ) );

$bunchy_navbar_background           = new Bunchy_Color( bunchy_get_theme_option( 'header', 'navbar_background_color' ) );
$bunchy_navbar_text                 = new Bunchy_Color( bunchy_get_theme_option( 'header', 'navbar_text_color' ) );
$bunchy_navbar_accent               = new Bunchy_Color( bunchy_get_theme_option( 'header', 'navbar_accent_color' ) );

$bunchy_submenu_background          = new Bunchy_Color( bunchy_get_theme_option( 'header', 'submenu_background_color' ) );
$bunchy_submenu_text                = new Bunchy_Color( bunchy_get_theme_option( 'header', 'submenu_text_color' ) );
$bunchy_submenu_accent              = new Bunchy_Color( bunchy_get_theme_option( 'header', 'submenu_accent_color' ) );
?>

.g1-header a {
color: #<?php echo filter_var( $bunchy_header_text->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.g1-header a:hover,
.g1-header .menu-item:hover > a,
.g1-header .current-menu-item > a {
color: #<?php echo filter_var( $bunchy_header_accent->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.g1-header > .g1-row-background {
border-color: #<?php echo filter_var( $bunchy_header_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
background-color: #<?php echo filter_var( $bunchy_header_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.g1-header .g1-button,
.g1-header .g1-button:hover {
border-color: #<?php echo filter_var( $bunchy_header_secondary_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
background-color: #<?php echo filter_var( $bunchy_header_secondary_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
color: #<?php echo filter_var( $bunchy_header_secondary_text->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.g1-navbar {
border-color: #<?php echo filter_var( $bunchy_navbar_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
background-color: #<?php echo filter_var( $bunchy_navbar_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
color: #<?php echo filter_var( $bunchy_navbar_text->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.g1-navbar a {
color: #<?php echo filter_var( $bunchy_navbar_text->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.g1-navbar a:hover,
.g1-navbar .menu-item:hover > a,
.g1-navbar .current-menu-item > a,
.g1-navbar .current-menu-ancestor > a {
color: #<?php echo filter_var( $bunchy_navbar_accent->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.g1-navbar .sub-menu,
.g1-header .sub-menu {
border-color: #<?php echo filter_var( $bunchy_submenu_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
background-color: #<?php echo filter_var( $bunchy_submenu_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.g1-navbar .sub-menu a,
.g1-header .sub-menu a {
color: #<?php echo filter_var( $bunchy_submenu_text->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.g1-navbar .g1-link-toggle,
.g1-navbar .g1-drop-toggle-arrow,
.g1-header .g1-link-toggle,
.g1-header .g1-drop-toggle-arrow {
color: #<?php echo filter_var( $bunchy_submenu_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.g1-navbar .g1-drop-content,
.g1-header .g1-drop-content {
border-color: #<?php echo filter_var( $bunchy_submenu_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.g1-navbar .sub-menu a:hover,
.g1-header .sub-menu a:hover,
.g1-navbar .sub-menu .menu-item:hover > a,
.g1-header .sub-menu .menu-item:hover > a,
.g1-navbar .sub-menu .current-menu-item > a,
.g1-header .sub-menu .current-menu-item > a,
.g1-navbar .sub-menu .current-menu-ancestor > a,
.g1-header .sub-menu .current-menu-ancestor > a {
color: #<?php echo filter_var( $bunchy_submenu_accent->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

