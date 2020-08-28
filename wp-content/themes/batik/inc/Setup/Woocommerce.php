<?php

namespace Batik\Setup;

class Woocommerce {

    public function register() {
        /**
         * Change the breadcrumb separator
         */
        add_filter( 'woocommerce_breadcrumb_defaults', [ $this, 'breadcrumb_delimiter' ] );

        /**
         * Change several of the breadcrumb defaults
         */
        add_filter( 'woocommerce_breadcrumb_defaults', [ $this, 'breadcrumbs' ] );
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

    public function breadcrumb_delimiter( $defaults ) {
        // Change the breadcrumb delimeter from '/' to '>'
        $defaults['delimiter'] = ' > ';
        return $defaults;
    }

}