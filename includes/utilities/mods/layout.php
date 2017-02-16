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
     * @var         string      $specific       Post type name or taxonomy name
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( $template, $specific = '' ) {
        $this->template = sanitize_key( $template );
        $this->specific = sanitize_key( $specific );

        $this->names = $this->names();
        $this->name = isset( $this->names[ $template ] )
            ? sanitize_key( $this->names[ $template ] ) : '';

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
        return array(
            'home' => 'post_post_type_layout',
            'singular' => ( is_post_type_hierarchical( $this->specific ) ? 'layout' : 'single_' . $this->specific . '_layout' ),
            'author' => 'author_layout',
            'category' => 'category_taxonomy_layout',
            'date' => 'date_layout',
            'post_type_archive' => $this->specific . '_post_type_layout',
            'tag' => 'tag_taxonomy_layout',
            'tax' => $this->specific . '_taxonomy_layout',
            '404' => 'error_404_layout',
            'search' => 'search_layout',
        );
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

        if ( 'singular' == $this->template && is_post_type_hierarchical( $this->specific ) ) {
            global $post;

            return sanitize_title( get_post_meta( $post->ID, $this->name, true ) );
        }

        return sanitize_title( get_theme_mod( $this->name, $this->default ) );
    }
}