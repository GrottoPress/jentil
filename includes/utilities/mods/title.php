<?php

/**
 * Title mods
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
 * Title Mods
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Title extends Mod {
    /**
     * Context
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     string     $context   Template type
     */
    protected $context;

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
     * Constructor
     * 
     * @var         string      $context       Template name
     * @var         string      $specific       Post type name or taxonomy name
     * @var         string      $more_specific  Post ID or term ID
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( $context, $specific = '', $more_specific = '' ) {
        $this->context = sanitize_key( $context );

        $specific = sanitize_key( $specific );
        $this->specific = post_type_exists( $specific ) || taxonomy_exists( $specific )
            ? $specific : '';

        $this->more_specific = sanitize_key( $more_specific );

        $names = $this->names();
        $this->name = isset( $names[ $this->context ] )
            ? sanitize_key( $names[ $this->context ] ) : '';

        $defaults = $this->defaults();
        $this->default = isset( $defaults[ $this->context ] )
            ? $defaults[ $this->context ] : '';
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
            'home' => 'post_post_type_title',
            // 'singular' => 'singular_' . $this->specific . '_' . $this->more_specific . '_title',
            'author' => 'author_title',
            'category' => 'category_' . $this->more_specific . '_taxonomy_title',
            'date' => 'date_title',
            'post_type_archive' => $this->specific . '_post_type_title',
            'tag' => 'post_tag_' . $this->more_specific . '_taxonomy_title',
            'tax' => $this->specific . '_' . $this->more_specific . '_taxonomy_title',
            '404' => 'error_404_title',
            'search' => 'search_title',
        );

        $names = array_map( function ( $value ) {
            $value = str_replace( '__', '_', $value );
            $value = trim( $value, '_' );

            return $value;
        }, $names );

        /**
         * Filter the title mod names
         * 
         * @var         string          $names      Title mod names.
         *
         * @filter      jentil_title_mod_names
         *
         * @since       Jentil 0.1.0
         */
        return apply_filters( 'jentil_title_mod_names', $names,
            $this->context, $this->specific, $this->more_specific );
    }

    /**
     * Get settings defaults
     *
     * @since       Jentil 0.1.0
     * @access      private
     *
     * @return      string          Mod names
     */
    private function defaults() {
        $defaults = array(
            'home' => esc_html__( 'Latest Posts', 'jentil' ),
            // 'singular' => '',
            'author' => '{{author_name}}',
            'category' => '{{category_name}}',
            'day' => '{{day}}',
            'month' => '{{month}}',
            'year' => '{{year}}',
            'post_type_archive' => '{{post_type_name}}',
            'tag' => '{{tag_name}}',
            'tax' => '{{term_name}}',
            '404' => esc_html__( 'Not Found', 'jentil' ),
            'search' => '&ldquo;{{search_query}}&rdquo;',
        );

        /**
         * Filter the title mod defaults
         * 
         * @var         string      $defaults       Posts mod defaults.
         *
         * @filter      jentil_title_mod_defaults
         *
         * @since       Jentil 0.1.0
         */
        return apply_filters( 'jentil_title_mod_defaults', $defaults,
            $this->context, $this->specific, $this->more_specific );
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

        return $this->parse_placeholders( get_theme_mod( $this->name, $this->default ) );
    }

    /**
     * Parse placeholders
     *
     * Replace placeholders with actual info
     *
     * @since       Jentil 0.1.0
     * @access      private
     *
     * @return      string          Mod with placeholders replaced
     */
    private function parse_placeholders( $mod ) {
        return str_ireplace( array(
            '{{author_name}}',
            '{{category_name}}',
            '{{tag_name}}',
            '{{term_name}}',
            '{{taxonomy_name}}',
            '{{post_type_name}}',
            '{{day}}',
            '{{month}}',
            '{{year}}',
            '{{search_query}}',
        ), array(
            esc_attr( get_the_author_meta( 'display_name' ) ),
            esc_attr( single_cat_title( '', false ) ),
            esc_attr( single_tag_title( '', false ) ),
            esc_attr( single_term_title( '', false ) ),
            esc_attr( get_query_var( 'taxonomy' ) ),
            esc_attr( post_type_archive_title( '', false ) ),
            esc_attr( get_the_date() ),
            esc_attr( get_the_date( 'F Y' ) ),
            esc_attr( get_the_date( 'Y' ) ),
            esc_attr( get_search_query() ),
        ),
        $mod );
    }
}