<?php
/**
 * Global styles
 *
 * @license For the full license information, please view the Licensing folder
 * that was distributed with this source code.
 *
 * @package Bunchy_Theme
 */

$bunchy_filter_hex = array( 'options' => array( 'regexp' => '/^([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/' ) );

$bunchy_page_layout = bunchy_get_theme_option( 'global', 'layout' );

$bunchy_page_width = absint( bunchy_get_theme_option( 'global', 'width' ) );
$bunchy_page_width = $bunchy_page_width > 1210 ? $bunchy_page_width : 1210;

$bunchy_body_background          = array();
$bunchy_body_background['color'] = new Bunchy_Color( bunchy_get_theme_option( 'global', 'background_color' ) );

$bunchy_cs_1_background = new Bunchy_Color( bunchy_get_theme_option( 'content', 'cs_1_background_color' ) );
$bunchy_cs_1_background_variations = bunchy_get_color_variations( $bunchy_cs_1_background );
$bunchy_cs_1_background_5          = new Bunchy_Color( $bunchy_cs_1_background_variations['tone_5_90_hex'] );
$bunchy_cs_1_background_10         = new Bunchy_Color( $bunchy_cs_1_background_variations['tone_20_20_hex'] );

$bunchy_cs_1_text1                  = new Bunchy_Color( bunchy_get_theme_option( 'content', 'cs_1_text1' ) );
$bunchy_cs_1_text2                  = new Bunchy_Color( bunchy_get_theme_option( 'content', 'cs_1_text2' ) );
$bunchy_cs_1_text3                  = new Bunchy_Color( bunchy_get_theme_option( 'content', 'cs_1_text3' ) );
$bunchy_cs_1_accent1                = new Bunchy_Color( bunchy_get_theme_option( 'content', 'cs_1_accent1' ) );
$bunchy_cs_2_background             = new Bunchy_Color( bunchy_get_theme_option( 'content', 'cs_2_background_color' ) );
$bunchy_cs_2_text1                  = new Bunchy_Color( bunchy_get_theme_option( 'content', 'cs_2_text1' ) );
?>
body.g1-layout-boxed {
background-color: #<?php echo filter_var( $bunchy_body_background['color']->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.g1-layout-boxed .g1-row-layout-page {
max-width: <?php echo intval( $bunchy_page_width ); ?>px;
}

/* Global Color Scheme */
.g1-row-layout-page > .g1-row-background,
.g1-sharebar > .g1-row-background,
.g1-content > .g1-background,
.g1-current-background {
background-color: #<?php echo filter_var( $bunchy_cs_1_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

input,
select,
textarea {
border-color: #<?php echo filter_var( $bunchy_cs_1_background_10->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
border-color: #e6e6e6;
}


h1,
h2,
h3,
h4,
h5,
h6,
.g1-mega,
.g1-alpha,
.g1-beta,
.g1-gamma,
.g1-delta,
.g1-epsilon,
.g1-zeta,
blockquote,
.drag-drop-info,
.g1-link,
.g1-quote-author-name,
.g1-links a,
.entry-share-item,
.entry-print,
.g1-nav-single-prev > a > strong,
.g1-nav-single-next > a > strong,
.widget_recent_entries a,
.widget_archive a,
.widget_categories a,
.widget_meta a,
.widget_pages a,
.widget_recent_comments a,
.widget_nav_menu .menu a,
.snax-voting-score strong {
color: #<?php echo filter_var( $bunchy_cs_1_text1->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

body {
color: #<?php echo filter_var( $bunchy_cs_1_text2->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.entry-meta,
.snax-format-desc,
.snax-list-item-meta,
.snax-time-left,
.snax-voting-score,
#buddypress .activity-time-since,
#buddypress table.notifications td.notification-since,
#buddypress a.bp-secondary-action {
color: #<?php echo filter_var( $bunchy_cs_1_text3->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.entry-meta a {
color: #<?php echo filter_var( $bunchy_cs_1_text1->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}


a,
.entry-title > a:hover,
.entry-meta a:hover,
.g1-link:hover,
.g1-nav-single-prev > a:hover > strong,
.g1-nav-single-prev > a:hover > span,
.g1-nav-single-next > a:hover > strong,
.g1-nav-single-next > a:hover > span,
.g1-primary-nav a:hover,
.g1-primary-nav .mtm-drop-expanded > a,
.snax-item-title > a:hover,
.snax-cta-body:before,
.mashsb-main .mashsb-count {
	color: #<?php echo filter_var( $bunchy_cs_1_accent1->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}


input[type="submit"],
input[type="reset"],
button {
	border-color: #<?php echo filter_var( $bunchy_cs_2_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
	background-color: #<?php echo filter_var( $bunchy_cs_2_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
	color: #<?php echo filter_var( $bunchy_cs_2_text1->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

input[type="button"],
.button,
input.button {
	border-color: #<?php echo filter_var( $bunchy_cs_1_accent1->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?> !important;
	background-color: transparent;
	color: #<?php echo filter_var( $bunchy_cs_1_accent1->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?> !important;
}

.g1-button,
.g1-button:hover,
a.g1-arrow,
a.g1-arrow:hover,
.entry-categories ul a,
.entry-counter:before,
.entry-badge,
.author-link,
.author-info .author-link,
.g1-box-icon,
.snax .snax-formats .snax-format:hover {
border-color: #<?php echo filter_var( $bunchy_cs_2_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
background-color: #<?php echo filter_var( $bunchy_cs_2_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
color: #<?php echo filter_var( $bunchy_cs_2_text1->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.g1-button-simple,
.g1-button-simple:hover {
	border-color: #<?php echo filter_var( $bunchy_cs_1_accent1->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?> !important;
	background-color: transparent !important;
	color: #<?php echo filter_var( $bunchy_cs_1_accent1->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?> !important;
}

/* Edge fix */
.entry-badge:after {
border-color: #<?php echo filter_var( $bunchy_cs_2_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}

.g1-drop-toggle-arrow {
color: #<?php echo filter_var( $bunchy_cs_1_background->get_hex(), FILTER_VALIDATE_REGEXP, $bunchy_filter_hex ); ?>;
}



