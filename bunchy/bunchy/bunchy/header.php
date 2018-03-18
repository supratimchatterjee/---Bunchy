<?php
/**
 * The Header for our theme.
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
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="no-js lt-ie10 lt-ie9 lt-ie8" id="ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie10 lt-ie9" id="ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]>
<html class="no-js lt-ie10" id="ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if !IE]><!-->
<html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<link rel="profile" href="http://gmpg.org/xfn/11"/>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
<?php do_action( 'bunchy_body_start' ); ?>

<div class="g1-body-inner">

	<div id="page">
		<?php get_template_part( 'template-parts/sharebar' ); ?>

		<?php
		if ( apply_filters( 'bunchy_show_ad_before_header_theme_area', true ) ) :
			get_template_part( 'template-parts/ad-before-header-theme-area' );
		endif;
		?>

		<?php if ( bunchy_show_global_navbar() ) : ?>
			<div class="g1-row g1-row-layout-full g1-navbar">
				<div class="g1-row-inner">
					<div class="g1-column g1-dropable">

						<?php if ( bunchy_show_quick_nav_menu() ) : ?>
							<nav class="g1-quick-nav">
								<ul class="g1-quick-nav-menu">
									<?php if ( strlen( bunchy_get_latest_page_url() ) ) : ?>
										<li class="menu-item menu-item-type-g1-latest <?php if ( bunchy_is_latest_page() ) { echo sanitize_html_class( 'current-menu-item' );} ?>">
											<a href="<?php echo esc_url( bunchy_get_latest_page_url() ); ?>"><?php echo esc_html( bunchy_get_latest_page_label() ); ?></a>
										</li>
									<?php endif; ?>

									<?php if ( strlen( bunchy_get_popular_page_url() ) ) : ?>
										<li class="menu-item menu-item-type-g1-popular <?php if ( bunchy_is_popular_page() ) {
											echo sanitize_html_class( 'current-menu-item' ); } ?>">
											<a href="<?php echo esc_url( bunchy_get_popular_page_url() ); ?>"><?php echo esc_html( bunchy_get_popular_page_label() ); ?></a>
										</li>
									<?php endif; ?>

									<?php if ( strlen( bunchy_get_hot_page_url() ) ) : ?>
										<li class="menu-item menu-item-type-g1-hot <?php if ( bunchy_is_hot_page() ) {
											echo sanitize_html_class( 'current-menu-item' ); } ?>">
											<a href="<?php echo esc_url( bunchy_get_hot_page_url() ); ?>"><?php echo esc_html( bunchy_get_hot_page_label() ); ?></a>
										</li>
									<?php endif; ?>

									<?php if ( strlen( bunchy_get_trending_page_url() ) ) : ?>
										<li class="menu-item menu-item-type-g1-trending <?php if ( bunchy_is_trending_page() ) {
											echo sanitize_html_class( 'current-menu-item' ); } ?>">
											<a href="<?php echo esc_url( bunchy_get_trending_page_url() ); ?>"><?php echo esc_html( bunchy_get_trending_page_label() ); ?></a>
										</li>
									<?php endif; ?>
								</ul>
							</nav>
						<?php endif; ?>

						<?php if ( apply_filters( 'bunchy_show_navbar_searchform', true ) ) : ?>
							<div class="g1-drop g1-drop-before g1-drop-the-search">
								<a class="g1-drop-toggle" href="#">
									<i class="bunchy-icon bunchy-icon-search"></i><?php esc_html_e( 'Search', 'bunchy' ); ?>
									<span class="g1-drop-toggle-arrow"></span>
								</a>
								<div class="g1-drop-content">
									<?php get_search_form( true ); ?>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( apply_filters( 'bunchy_show_navbar_socials', true ) && bunchy_can_use_plugin( 'g1-socials/g1-socials.php' ) ) : ?>
							<div class="g1-drop g1-drop-before g1-drop-the-socials">
								<a class="g1-drop-toggle" href="#"
								   title="<?php esc_attr_e( 'Follow us', 'bunchy' ); ?>">
									<i class="bunchy-icon bunchy-icon-follow"></i> <?php esc_html_e( 'Follow us', 'bunchy' ); ?>
									<span class="g1-drop-toggle-arrow"></span>
								</a>
								<div class="g1-drop-content">
									<p class="g1-epsilon g1-epsilon-2nd"><?php esc_html_e( 'Follow us', 'bunchy' ); ?></p>

									<?php echo do_shortcode( '[g1_socials icon_size="48" icon_color="dark"]' ); ?>
								</div>
							</div>
						<?php endif; ?>

					</div><!-- .g1-column -->

				</div>
			</div>
		<?php endif; ?>

		<?php if ( bunchy_use_sticky_header() ) : ?>
			<div class="g1-sticky-top-wrapper">
		<?php endif; ?>

			<div class="g1-row g1-row-layout-full g1-header">
				<div class="g1-row-inner">
					<div class="g1-column g1-dropable">

						<a class="g1-hamburger g1-hamburger-show" href="">
							<span class="g1-hamburger-icon"></span>
							<span class="g1-hamburger-label"><?php esc_html_e( 'Menu', 'bunchy' ); ?></span>
						</a>

						<?php get_template_part( 'template-parts/header-id' ); ?>

						<!-- BEGIN .g1-primary-nav -->
						<?php
						if ( has_nav_menu( 'bunchy_primary_nav' ) ) :
							wp_nav_menu( array(
								'theme_location'  => 'bunchy_primary_nav',
								'container'       => 'nav',
								'container_class' => 'g1-primary-nav',
								'container_id'    => 'g1-primary-nav',
								'menu_class'      => '',
								'menu_id'         => 'g1-primary-nav-menu',
								'depth'           => 0,
							) );
						endif;
						?>
						<!-- END .g1-primary-nav -->

						<?php get_template_part( 'template-parts/nav-user' ); ?>

					</div>

				</div>
				<div class="g1-row-background"></div>
			</div>

		<?php if ( bunchy_use_sticky_header() ) : ?>
			</div>
		<?php endif; ?>

		<?php
		if ( bunchy_show_global_featured_entries() ) :
			get_template_part( 'template-parts/collection-featured' );
		endif;
		?>

		<?php do_action( 'bunchy_before_content_theme_area' ); ?>

<?php
get_template_part( 'template-parts/ad-before-content-theme-area' );
