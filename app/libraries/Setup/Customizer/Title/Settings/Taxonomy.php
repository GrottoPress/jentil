<?php

/**
 * Taxonomy
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Title\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer\Title\Settings;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup\Customizer\Title\Title;
use \WP_Taxonomy;
use \WP_Term;

/**
 * Taxonomy
 *
 * @since 0.1.0
 */
final class Taxonomy extends Setting {
    /**
     * Constructor
     *
     * @param GrottoPress\Jentil\Setup\Customizer\Customizer\Title\Title $title Title.
     * @param WP_Taxonomy $taxonomy Taxonomy.
     * @param WP_Term $term Term.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Title $title, WP_Taxonomy $taxonomy, WP_Term $term = null ) {
        parent::__construct( $title );

        $this->set_mod( $taxonomy, $term );

        $this->name = $this->mod->name();
        
        $this->args['default'] = $this->mod->default();
        
        $this->set_control( $taxonomy, $term );
    }

    /**
     * Set mod
     *
     * @param WP_Taxonomy $taxonomy Taxonomy.
     * @param WP_Term $term Term.
     *
     * @since 0.1.0
     * @access private
     */
    private function set_mod( WP_Taxonomy $taxonomy, WP_Term $term = null ) {
        $mod_context = 'tax';
        
        if ( 'post_tag' == $taxonomy->name ) {
            $mod_context = 'tag';
        } elseif ( 'category' == $taxonomy->name ) {
            $mod_context = 'category';
        }

        $mods = $this->title->customizer()->jentil()->utilities()->mods();

        if ( $term ) {
            $this->mod = $mods->title( [
                'context' => $mod_context,
                'specific' => $taxonomy->name,
                'more_specific' => $term->term_id,
            ] );
        } else {
            $this->mod = $mods->title( [
                'context' => $mod_context,
                'specific' => $taxonomy->name
            ] );
        }
    }

    /**
     * Set control
     *
     * @param WP_Taxonomy $taxonomy Taxonomy.
     * @param WP_Term $term Term.
     *
     * @since 0.1.0
     * @access private
     */
    private function set_control( WP_Taxonomy $taxonomy, WP_Term $term = null ) {
        $this->control['active_callback'] = function () use ( $taxonomy, $term ): bool {
            $page = $this->title->customizer()->jentil()->utilities()->page();

            if ( $term ) {
                return ( $page->is( 'tag', $term->term_id )
                    || $page->is( 'category', $term->term_id )
                    || $page->is( 'tax', $taxonomy, $term->term_id ) );
            }

            if ( 'post_tag' == $taxonomy->name ) {
                return $page->is( 'tag' );
            }

            if ( 'category' == $taxonomy->name ) {
                return $page->is( 'category' );
            }

            return $page->is( 'tax', $taxonomy->name );
        };

        if ( $term ) {
            $this->control['label'] = \sprintf( \esc_html__( '%1$s Archive: %2$s', 'jentil' ),
                $taxonomy->labels->singular_name, $term->name );
        } else {
            $this->control['label'] = \sprintf( \esc_html__( '%1$s Archives', 'jentil' ),
                $taxonomy->labels->singular_name );
        }
    }
}
