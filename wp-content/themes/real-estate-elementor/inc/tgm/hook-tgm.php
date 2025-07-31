<?php
/**
 * Recommended plugins
 *
 * @package real-estate-elementor
 */

if ( ! function_exists( 'real_estate_elementor_recommended_plugins' ) ) :

    /**
     * Recommend plugins.
     *
     * @since 1.0.0
     */
    function real_estate_elementor_recommended_plugins() {

        $plugins = array(              
          
            array(
                'name'     => esc_html__( 'Testerwp Ecommerce Companion', 'real-estate-elementor' ),
                'slug'     => 'testerwp-ecommerce-companion',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'Estatik', 'real-estate-elementor' ),
                'slug'     => 'estatik',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'One Click Demo Import', 'real-estate-elementor' ),
                'slug'     => 'one-click-demo-import',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'Elementor Website Builder', 'real-estate-elementor' ),
                'slug'     => 'elementor',
                'required' => false,
            ),
             array(
                'name'     => esc_html__( 'ElementsKit Lite', 'real-estate-elementor' ),
                'slug'     => 'elementskit-lite',
                'required' => false,
            ),
             array(
                'name'     => esc_html__( 'WooCommerce', 'real-estate-elementor' ),
                'slug'     => 'woocommerce',
                'required' => false,
            ),
        );

        tgmpa( $plugins );

    }

endif;

add_action( 'tgmpa_register', 'real_estate_elementor_recommended_plugins' );