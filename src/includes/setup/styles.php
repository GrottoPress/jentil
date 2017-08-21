<?php

/**
 * Stylesheets
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

/**
 * Stylesheets
 *
 * @since 0.1.0
 */
final class Styles extends Setup {
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
        \add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_fa' ] );
    }
    
    /**
     * Enqueue Styles
     * 
     * @since 0.1.0
     * @access public
     * 
     * @action wp_enqueue_scripts
     */
    public function enqueue() {
        \wp_enqueue_style( 'normalize',
            $this->jentil->url() . '/node_modules/normalize.css/normalize.css' );
        
        if ( \is_rtl() ) {
            \wp_enqueue_style( 'jentil',
                $this->jentil->url() . '/dist/assets/styles/jentil-rtl.min.css',
                [ 'normalize' ] );
        } else {
            \wp_enqueue_style( 'jentil',
                $this->jentil->url() . '/dist/assets/styles/jentil.min.css',
                [ 'normalize' ] );
        }
    }

    /**
     * Enqueue font awesome
     * 
     * @since 0.1.0
     * @access public
     * 
     * @action wp_enqueue_scripts
     */
    public function enqueue_fa() {
        \wp_enqueue_style( 'font-awesome',
                $this->jentil->url() . '/node_modules/font-awesome/css/font-awesome.min.css',
                [ 'normalize' ] );
    }
}
