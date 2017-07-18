<?php

/**
 * Title tag
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\MagPack;

/**
 * Title tag
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Title_Tag {
    /**
     * Import traits
     *
     * @since       Jentil 0.1.0
     */
    use MagPack\Utilities\Wizard;

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
	public function __construct( Jentil $jentil ) {
        $this->jentil = $jentil;
    }

    /**
     * Title tag.
     * 
     * Add support for the title tag.
     *
     * @since       Jentil 0.1.0
     * @since       WordPress 4.1
     * @access      public
     * 
     * @action      after_setup_theme
     */
    public function enable() {
        if ( ! function_exists( 'wp_get_document_title' ) ) {
            return;
        }
    
        add_theme_support( 'title-tag' );
    }

    /**
     * Title tag
     * 
     * Add backwards compatibility for wp_title().
     *
     * @deprecated  WordPress 4.4
     * @see         https://make.wordpress.org/core/2015/10/20/document-title-in-4-4/
     *
     * @since       Jentil 0.1.0
     * @access      public
     * 
     * @action      wp_head
     */
    public function render() {
        if ( function_exists( 'wp_get_document_title' ) ) {
            return;
        }
    
        echo '<title itemprop="name">'; wp_title(); echo '</title>';
    }
}