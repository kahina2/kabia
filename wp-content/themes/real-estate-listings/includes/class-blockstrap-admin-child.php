<?php

if ( class_exists( 'BlockStrap_Admin' ) ) {

	class BlockStrap_Admin_Child extends BlockStrap_Admin {
		public function __construct() {
			parent::__construct();
		}

		/**
		 * Get the theme title.
		 *
		 * @return string|null
		 */
		public function get_theme_title() {
			return __( 'Real Estate', 'real-estate-listings' );
		}

		/**
		 * Get the required plugins details array.
		 *
		 * @return array
		 */
		public function get_required_plugins() {
			return array(
				'blockstrap-page-builder-blocks' => esc_attr__( 'BlockStrap Builder', 'real-estate-listings' ),
				'geodirectory' => esc_attr__( 'GeoDirectory', 'real-estate-listings' ),
				'userswp' => esc_attr__( 'UsersWP', 'real-estate-listings' ),
				'real-estate-directory' => esc_attr__( 'Real Estate Directory Blocks', 'real-estate-listings' ),
			);
		}

		/**
		 * This can be set in child themes to set the GD dummy data default type.
		 *
		 * @param $type
		 * @param $post_type
		 *
		 * @return mixed
		 */
		public function gd_set_default_dummy_data_type( $type, $post_type ) {

			if ( ! $type ) {
				$type = 'property_sale';
			}
			return $type;
		}


	}

}
