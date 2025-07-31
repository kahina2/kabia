<?php
/**
 * Real Estate Elementor manage the Customizer panels.
 *
 * @subpackage real-estate-elementor
 * @since 1.0 
 */

/**
 * General Settings Panel
 */
Kirki::add_panel( 'real_estate_elementor_general_panel', array(
	'priority' => 10,
	'title'    => __( 'General Settings', 'real-estate-elementor' ),
) );

/**
 * Real State Elementor Options
 */
Kirki::add_panel( 'real_estate_elementor_options_panel', array(
	'priority' => 20,
	'title'    => __( 'Real Estate Elementor Theme Options', 'real-estate-elementor' ),
) );