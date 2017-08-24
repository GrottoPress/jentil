<?php

/**
 * Language
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
 * Language
 *
 * @since 0.1.0
 */
final class Language extends Setup {
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_action( 'after_setup_theme', [ $this, 'load_textdomain' ] );
    }

    /**
     * Load textdomain.
     *
     * Make theme available for translation. Translations can
     * be filed in the '/src/languages' directory.
     *
     * @since 0.1.0
     * @access public
     * 
     * @action after_setup_theme
     */
    public function load_textdomain() {
        \load_theme_textdomain( 'jentil', $this->jentil->dir( 'path', '/src/languages' ) );
    }
}
