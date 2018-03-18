<?php
/**
 * The Template Part for displaying search form.
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
?>

<?php
global $bunchy_searchform_data;

if ( empty( $bunchy_searchform_data['final_class'] ) ) {
	$bunchy_searchform_data['final_class'] = array( 'g1-searchform-tpl-default', 'g1-form-s' );
}

if ( empty( $bunchy_searchform_data['input_label'] ) ) {
	$bunchy_searchform_data['input_label'] = esc_html_x( 'Search &hellip;', 'placeholder', 'bunchy' );
}

if ( empty( $bunchy_searchform_data['submit_label'] ) ) {
	$bunchy_searchform_data['submit_label'] = esc_html_x( 'Search', 'submit button', 'bunchy' );
}
?>

<div role="search">
	<form method="get"
	      class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $bunchy_searchform_data['final_class'] ) ); ?> search-form"
	      action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label>
			<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'bunchy' ); ?></span>
			<input type="search" class="search-field"
			       placeholder="<?php echo esc_attr( $bunchy_searchform_data['input_label'] ); ?>"
			       value="<?php echo esc_attr( get_search_query() ); ?>" name="s"
			       title="<?php echo esc_attr_x( 'Search for:', 'label', 'bunchy' ); ?>"/>
		</label>
		<input type="submit" class="search-submit"
		       value="<?php echo esc_attr( $bunchy_searchform_data['submit_label'] ); ?>"/>
	</form>
</div>
