<?php
/**
 * Snax Post Content Template Part
 *
 * @package snax
 * @subpackage Theme
 */

bunchy_set_template_part_data(
	array(
		'elements' => array(
			'featured_media' => true,
			'summary'        => true,
			'author'         => true,
			'date'           => true,
		),
	)
);

get_template_part( 'template-parts/content-classic' );

bunchy_reset_template_part_data();

