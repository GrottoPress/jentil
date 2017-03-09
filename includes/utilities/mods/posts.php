<?php

/**
 * Posts mods
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
 * Posts Mods
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Posts extends Mod {
    /**
     * Setting
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     string     $setting     Specific post setting to retrieve
     */
    protected $setting;

    /**
     * Context
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     string     $context     Context
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
     * @var         string      $context        Context
     * @var         string      $setting        Setting
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( $setting, $args = array() ) {
        $args = wp_parse_args( $args, array(
            'context' => '',
            'specific' => '',
            'more_specific' => '',
        ) );

        $this->setting = sanitize_key( $setting );
        $this->context = sanitize_key( $args['context'] );
        $this->specific = sanitize_key( $args['specific'] );
        $this->more_specific = sanitize_key( $args['more_specific'] );

        $names = $this->names();
        $this->name = isset( $names[ $this->context ] )
            ? sanitize_key( $names[ $this->context ] ) : '';

        $defaults = $this->defaults();
        $this->default = isset( $defaults[ $this->setting ] )
            ? $defaults[ $this->setting ] : '';
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
            'home' => 'post_post_type_posts',
            // 'singular' => 'singular_' . $this->specific . '_' . $this->more_specific . '_posts',
            'author' => 'author_posts',
            'category' => 'category_' . $this->more_specific . '_taxonomy_posts',
            'date' => 'date_posts',
            'post_type_archive' => $this->specific . '_post_type_posts',
            'tag' => 'post_tag_' . $this->more_specific . '_taxonomy_posts',
            'tax' => $this->specific . '_' . $this->more_specific . '_taxonomy_posts',
            'search' => 'search_posts',
            'sticky' => $this->specific . '_sticky_posts',
        );

        $names = array_map( function ( $value ) {
            $value .= '_' . $this->setting;
            $value = str_replace( '__', '_', $value );
            $value = trim( $value, '_' );

            return $value;
        }, $names );

        /**
         * Filter the posts mod names
         * 
         * @var         string          $names      Layout mod names.
         *
         * @filter      jentil_posts_mod_names
         *
         * @since       Jentil 0.1.0
         */
        return apply_filters( 'jentil_posts_mod_names', $names, $this->setting,
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
            'wrap_class' => 'archive-posts big',
            'wrap_tag' => 'div',
            'layout' => 'stack',
            'number' => ( int ) get_option( 'posts_per_page' ),
            'before_title' => '',
            'before_title_separator' => ' | ',
            'title_words' => -1,
            'title_position' => 'side',
            'after_title' => 'published_date, comments_link',
            'after_title_separator' => ' | ',
            'image' => 'mini-thumb',
            'image_alignment' => 'left',
            'image_margin' => '',
            'text_offset' => 0,
            'excerpt' => -1,
            'more_link' => esc_html__( 'read more', 'jentil' ),
            'after_content' => 'category, post_tag',
            'after_content_separator' => ' | ',
            'pagination' => '',
            'pagination_maximum' => -1,
            'pagination_position' => 'bottom',
            'pagination_previous_label' => __( '&larr; Previous', 'jentil' ),
            'pagination_next_label' => __( 'Next &rarr;', 'jentil' ),
            'sticky_posts' => 0,
        );

        if ( 'search' == $this->context ) {
            $defaults['wrap_class'] = 'archive-posts';
            $defaults['image'] = 'nano-thumb';
            $defaults['title_position'] = 'top';
            $defaults['after_title'] = 'post_type, comments_link';
            $defaults['excerpt'] = 40;
        }

        if ( 'sticky' == $this->context ) {
            $defaults['wrap_class'] = 'sticky-posts big';

            unset( $defaults['number'] );
            unset( $defaults['pagination'] );
            unset( $defaults['pagination_maximum'] );
            unset( $defaults['pagination_position'] );
            unset( $defaults['pagination_previous_label'] );
            unset( $defaults['pagination_next_label'] );
        }

        if ( ! in_array( $this->context, array(
            'post_type_archive',
            'home',
        ) ) ) {
            unset( $defaults['sticky_posts'] );
        }

        if ( in_array( $this->context, array(
            'home',
        ) ) ) {
            $defaults['sticky_posts'] = 1;
        }

        /**
         * Filter the posts mod defaults
         * 
         * @var         string      $defaults       Posts mod defaults.
         *
         * @filter      jentil_posts_mod_defaults
         *
         * @since       Jentil 0.1.0
         */
        return apply_filters( 'jentil_posts_mod_defaults', $defaults,
            $this->setting, $this->context );
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

        return get_theme_mod( $this->name, $this->default );
    }
}