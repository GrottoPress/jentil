<?php

/**
 * Taxonomy archive content customizer section
 *
 * The sections, settings and controls for our
 * Taxonomy archive content section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

/**
 * Taxonomy archive content customizer section
 *
 * The sections, settings and controls for our
 * Taxonomy archive content section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */
final class Taxonomy extends Section {
    /**
     * Taxonomy
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     object      $taxonomy       Taxonomy object
     */
    protected $taxonomy;

    /**
     * Constructor
     *
     * @var         object      $taxonomy       Taxonomy object
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Posts $posts, $taxonomy, $term = '' ) {
        parent::__construct( $posts );

        $this->taxonomy = $taxonomy;

        if ( $term ) {
            $this->name = sanitize_key( $this->taxonomy->name . '_' . $term->term_id . '_taxonomy_posts' );
        } else {
            $this->name = sanitize_key( $this->taxonomy->name . '_taxonomy_posts' );
        }

        $this->mod_args['context'] = 'tax';
        
        if ( 'post_tag' == $taxonomy->name ) {
            $this->mod_args['context'] = 'tag';
        } elseif ( 'category' == $taxonomy->name ) {
            $this->mod_args['context'] = 'category';
        }

        $this->mod_args['specific'] = $this->taxonomy->name;
        $this->mod_args['more_specific'] = ( $term ? $term->term_id : '' );

        // echo '<pre>'; print_r( $this->mod_args ); echo '</pre>';

        if ( $term ) {
            $this->args['title'] = sprintf( esc_html__( '%1$s: %2$s', 'jentil' ),
                $this->taxonomy->labels->singular_name, $term->name );
        } else {
            $this->args['title'] = $this->taxonomy->labels->name;
        }
        
        $this->args['active_callback'] = function () use ( $term ) {
            $template = $this->posts->get( 'customizer' )->get( 'template' );

            if ( $term ) {
                return ( $template->is( 'tag', $term->term_id )
                    || $template->is( 'category', $term->term_id )
                    || $template->is( 'tax', $this->taxonomy->name, $term->term_id ) );
            }

            if ( 'post_tag' == $this->taxonomy->name ) {
                return $template->is( 'tag' );
            }

            if ( 'category' == $this->taxonomy->name ) {
                return $template->is( 'category' );
            }

            return $template->is( 'tax', $this->taxonomy->name );
        };
    }
}