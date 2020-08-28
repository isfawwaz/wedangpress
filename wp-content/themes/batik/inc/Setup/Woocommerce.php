<?php

namespace Batik\Setup;

class Woocommerce {

    public function register() {
        /**
         * Add woocommerce support
         */
        add_action( 'after_setup_theme', [ $this, 'woocommerce_support' ] );
        /**
         * Change several of the breadcrumb defaults
         */
        add_filter( 'woocommerce_breadcrumb_defaults', [ $this, 'breadcrumbs' ] );

        /**
         * Change html tree for hook - woocommerce_before_shop_loop
         */
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

        /**
         * Change the order of catalog ordering
         */
        add_filter( 'woocommerce_catalog_orderby', [ $this, 'catalog_ordering' ] );

        /**
         * Customize product data tabs
         */
        add_filter( 'woocommerce_product_tabs', [ $this, 'woo_custom_description_tab' ], 98 );

        /**
         * 
         */
        remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 30 );
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 40 );
    }

    public function woocommerce_support() {
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }

    public function breadcrumbs() {
        return [
            'delimiter'   => '',
            'wrap_before' => '<ol class="wd-breadcrumb" itemprop="breadcrumb">',
            'wrap_after'  => '</ol>',
            'before'      => '<li class="wd-breadcrumb__item">',
            'after'       => '</li>',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
        ];
    }

    public function catalog_ordering() {
        return [
            'date' => __( 'Terbaru', 'woocommerce' ),
            'price' => __( 'Termurah', 'woocommerce' ),
            'price-desc' => __( 'Termahal', 'woocommerce' ),
            'popularity' => __( 'Terlaris', 'woocommerce' ),
            'rating' => __( 'Rating Tinggi', 'woocommerce' ),
            'menu_order' => __( 'Default sorting', 'woocommerce' ),
        ];
    }

    public function woo_custom_description_tab( $tabs ) {
        
        $tabs['additional_information']['title'] = __('Specification', 'woocommerce');

        return $tabs;
    }

}