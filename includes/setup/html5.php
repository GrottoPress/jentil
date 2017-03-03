<?php

/**
 * HTML5
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;
use GrottoPress\Jentil\Utilities;

/**
 * HTML5
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class HTML5 extends MagPack\Utilities\Singleton {
    /**
	 * Constructor
	 *
	 * @since       MagPack 0.1.0
	 * @access      public
	 */
	protected function __construct() {}

    /**
     * HTML5
     * 
     * Add support for html5 markup for certain features
     *
     * @see         https://codex.wordpress.org/Theme_Markup
     *
     * @since       jentil 0.1.0
     * @access      public
     * 
     * @action      after_setup_theme
     */
    public function enable() {
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'widgets',
        ) );
    }

    /**
     * Microdata schema
     *
     * Use schema.org's vocabulary to provide microdata
     * markup for this theme.
     *
     * @see         http://www.paulund.co.uk/add-schema-org-wordpress
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @filter      language_attributes
     */
    public function html_tag_schema( $output ) {
        $template = new Utilities\Template\Template();

        $output .= ' itemscope itemtype="http://schema.org/';

        if ( $template->is( 'home' ) ) {
            $output .= 'Blog';
        } elseif ( $template->is( 'author' ) ) {
            $output .= 'ProfilePage';
        } elseif ( $template->is( 'search' ) ) {
            $output .= 'SearchResultsPage';
        } elseif ( $template->is( 'singular', 'post' ) ) {
            $output .= 'BlogPosting';
        } else {
            $output .= 'WebPage';
        }

        $output .= '" ';

        return $output;
    }
}