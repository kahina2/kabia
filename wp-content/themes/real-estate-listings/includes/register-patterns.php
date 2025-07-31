<?php

/**
 * Register Block Patterns.
 */
if ( function_exists( 'register_block_pattern' ) ) {

	register_block_pattern(
		'real-estate-listings/header-transparent',
		array(
			'title'      => esc_html__( 'Header Transparent', 'real-estate-listings' ),
			'categories' => array( 'site-header' ),
			'content'    => defined( 'BLOCKSTRAP_BLOCKS_VERSION' ) ? apply_filters(
				'real_estate_pattern_header_transparent',
				'<!-- wp:site-title /-->'
			) : '<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"20px","bottom":"20px"}},"elements":{"link":{"color":{"text":"var:preset|color|light"}}}},"backgroundColor":"primary","textColor":"light","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide has-light-color has-primary-background-color has-text-color has-background has-link-color" style="padding-top:20px;padding-bottom:20px"><!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"},"layout":{"selfStretch":"fit","flexSize":null}},"layout":{"type":"flex"}} -->
<div class="wp-block-group"><!-- wp:site-logo {"width":60} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"0px"}}} -->
<div class="wp-block-group"><!-- wp:site-title {"level":0} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"left"}} -->
<div class="wp-block-group"></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		)
	);

	register_block_pattern(
		'real-estate-listings/feature-home-default',
		array(
			'title'      => esc_html__( 'Hero home', 'real-estate-listings' ),
			'categories' => array( 'blockstrap-feature-sections' ),
			'content'    => defined( 'BLOCKSTRAP_BLOCKS_VERSION' ) ? apply_filters(
				'blockstrap_pattern_feature_home_default',
				''
			) : '<!-- wp:group {"tagName":"main"} -->
<main class="wp-block-group has-background"><!-- wp:paragraph -->
<p>' . esc_attr__( 'Real Estate Listings is a lightweight and minimalist WordPress theme that was built specifically to work seamlessly with the plugins: BlockStrap page builder and GeoDirectory.', 'real-estate-listings' ) . '</p>
<!-- /wp:paragraph --></main>
<!-- /wp:group -->',
		)
	);

	// menu wrapper
	register_block_pattern(
		'real-estate-listings/menu-wrapper',
		array(
			'title'      => esc_html__( 'Menu Wrapper', 'real-estate-listings' ),
			'categories' => array( 'site-header' ),
			'content'    => defined( 'BLOCKSTRAP_BLOCKS_VERSION' ) ? apply_filters(
				'real_estate_listings_pattern_menu_wrapper',
				'<!-- wp:site-title /-->'
			) : '<!-- wp:site-title /-->',
		)
	);
}

