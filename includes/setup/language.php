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

use GrottoPress\MagPack;

/**
 * Language
 *
 * Internationalisation and translation features
 *
 * @package			jentil
 * @subpackage		jentil/includes/setup
 * @author			N Atta Kusi Adusei
 */
final class Language extends MagPack\Utilities\Singleton {
    /**
     * Jentil
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         \GrottoPress\Jentil\Setup\Jentil         $jentil       Jentil
     */
    protected $jentil;

    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    protected function __construct( Jentil $jentil ) {
        $this->jentil = $jentil;
    }

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
    public function load_textdomain() {
        load_theme_textdomain( 'jentil', get_template_directory() . '/languages' );
    }
}