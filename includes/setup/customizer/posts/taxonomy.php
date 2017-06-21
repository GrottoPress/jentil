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
use GrottoPress\Jentil\Utilities;

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
            $this->args['title'] = sprintf( esc_html__( '%1$s Archive: %2$s', 'jentil' ),
                $this->taxonomy->labels->singular_name, $term->name );
        } else {
            $this->args['title'] = sprintf( esc_html__( '%s Archives', 'jentil' ), $this->taxonomy->labels->singular_name );
        }
        
        $this->args['active_callback'] = function () use ( $term ) {
            $template = Utilities\Template\Template::instance();

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

    /**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings() {
        $settings = array();

        $settings['number'] = new Settings\Number( $this );

        $settings = array_merge( $settings, parent::settings() );

        $settings['pagination'] = new Settings\Pagination( $this );
        $settings['pagination_maximum'] = new Settings\Pagination_Maximum( $this );
        $settings['pagination_maximum'] = new Settings\Pagination_Position( $this );
        $settings['pagination_previous_label'] = new Settings\Pagination_Previous_Label( $this );
        $settings['pagination_next_label'] = new Settings\Pagination_Next_Label( $this );

        return $settings;
    }
}