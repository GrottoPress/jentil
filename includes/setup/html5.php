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
    die;
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
final class HTML5 {
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
        add_theme_support( 'html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'widgets',
        ] );
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
        $template = Utilities\Template\Template::instance();

        if (
            $template->is( 'admin' )
            || $template->is( 'login' )
            || $template->is( 'register' )
        ) {
            return $output;
        }

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

        $output .= '"';

        return $output;
    }

    /**
     * Whitelist attributes in WP kses
     *
     * Allow itemscope, itemtype, itemprop and other
     * html5 attributes to pass wp kses filters.
     *
     * @since       Jentil 0.1.0
     * @access      public
     * 
     * @filter      wp_kses_allowed_html
     */
    public function kses_allow( $allowed, $context ) {
        if ( ! isset( $allowed['span'] ) ) {
            $allowed['span'] = array(
                'dir' => true,
                'align' => true,
                'lang' => true,
                'xml:lang' => true,
            );
        }

        foreach ( $allowed as $tag => $atts ) {
            $allowed[ $tag ]['itemprop'] = true;
            $allowed[ $tag ]['itemscope'] = true;
            $allowed[ $tag ]['itemtype'] = true;
            $allowed[ $tag ]['itemref'] = true;
            $allowed[ $tag ]['itemid'] = true;
        }

        return $allowed;
    }
}