<?php
/**
 * Real Estate Elementor manage the Customizer options of general panel.
 *
 * @subpackage real-estate-elementor
 * @since 1.0 
 */
Kirki::add_field(
	'real_estate_elementor_config', array(
		'type'        => 'checkbox',
		'settings'    => 'real_estate_elementor_home_posts',
		'label'       => esc_attr__( 'Checked to hide latest posts in homepage.', 'real-estate-elementor' ),
		'section'     => 'static_front_page',
		'default'     => true,
	)
);
