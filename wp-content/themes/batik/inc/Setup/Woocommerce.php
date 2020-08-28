<?php

namespace Batik\Setup;

class Woocommerce {

    public function register() {
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

}