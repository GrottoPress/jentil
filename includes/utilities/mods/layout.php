<?php

/**
 * Layout mods
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Utilities\Mods;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Utilities;

/**
 * Layout Mods
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Layout extends Mod {
    /**
     * Template
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     string     $template   Template type
     */
    protected $template;

    /**
     * Specific template
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     string     $specific   Post type name or taxonomy name
     */
    protected $specific;

    /**
     * More specific template
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     mixed     $more_specific   Post ID or term ID/name
     */
    protected $more_specific;

    /**
     * Names
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array     $names   Template names
     */
    protected $names;

    /**
     * Constructor
     * 
     * @var         string      $template       Template name
     * @var         string      $specific       Post type name or taxonomy name
     * @var         string      $more_specific  Post ID or term ID
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( $template, $specific = '', $more_specific = '' ) {
        $this->template = sanitize_key( $template );

        $specific = sanitize_key( $specific );
        $this->specific = post_type_exists( $specific ) || taxonomy_exists( $specific )
            ? $specific : '';

        $this->more_specific = sanitize_key( $more_specific );

        $this->names = $this->names();
        $this->name = isset( $this->names[ $this->template ] )
            ? sanitize_key( $this->names[ $this->template ] ) : '';

        $this->default = 'content-sidebar';
    }

    /**
     * Get mod names
     *
     * @since       Jentil 0.1.0
     * @access      private
     *
     * @return      string          Mod names
     */
    private function names() {
        $names = array(
            'home' => 'post_post_type_layout',
            'singular' => 'singular_' . $this->specific . '_' . $this->more_specific . '_layout',
            'author' => 'author_layout',
            'category' => 'category_' . $this->more_specific . '_taxonomy_layout',
            'date' => 'date_layout',
            'post_type_archive' => $this->specific . '_post_type_layout',
            'tag' => 'post_tag_' . $this->more_specific . '_taxonomy_layout',
            'tax' => $this->specific . '_' . $this->more_specific . '_taxonomy_layout',
            '404' => 'error_404_layout',
            'search' => 'search_layout',
        );

        $names = array_map( function ( $value ) {
            $value = str_replace( '__', '_', $value );
            $value = trim( $value, '_' );

            return $value;
        }, $names );

        /**
         * Filter the layout mod names
         * 
         * @var         string          $names         Not found page content.
         *
         * @filter      jentil_layout_mod_names
         *
         * @since       Jentil 0.1.0
         */
        return apply_filters( 'jentil_layout_mod_names', $names, $this->template, $this->specific );
    }

    /**
     * Get mod
     *
     * @since		Jentil 0.1.0
     * @access      public
     *
     * @return      string          Mod
     */
    public function mod() {
        if ( ! $this->name ) {
            return false;
        }

        return sanitize_title( get_theme_mod( $this->name, $this->default ) );
    }
}