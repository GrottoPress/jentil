<?php

/**
 * Language
 *
 * Internationalisation and translation features
 *
 * @since			Jentil 0.1.0
 *
 * @package			jentil
 * @subpackage		jentil/includes/setup
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack\Utilities\Singleton;

/**
 * Language
 *
 * Internationalisation and translation features
 *
 * @package			jentil
 * @subpackage		jentil/includes/setup
 * @author			N Atta Kusi Adusei
 */
class Language extends Singleton {
    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function __construct() {}
    
    /**
     * Translations.
     *
     * Make theme available for translation. Translations can
     * be filed in the '/languages' directory.
     *
     * @since       jentil 0.1.0
     * @access      public
     * 
     * @action      after_setup_theme
     */
    public function enable_translation() {
        load_theme_textdomain( 'jentil', get_template_directory() . '/languages' );
    }
}