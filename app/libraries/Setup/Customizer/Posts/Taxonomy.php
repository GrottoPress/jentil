<?php

/**
 * Taxonomy Section
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Posts
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use \WP_Taxonomy;
use \WP_Term;

/**
 * Taxonomy Section
 *
 * @since 0.1.0
 */
final class Taxonomy extends Section {
    /**
     * Constructor
     *
     * @param GrottoPress\Jentil\Setup\Customizer\Posts\Posts $posts Posts.
     * @param \WP_Taxonomy $taxonomy Taxonomy.
     * @param \WP_Term $term Term.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Posts $posts, WP_Taxonomy $taxonomy, WP_Term $term = null ) {
        parent::__construct( $posts );

        $this->set_name( $taxonomy, $term );
        $this->set_mod_args( $taxonomy, $term );
        $this->set_args( $taxonomy, $term );
    }

    /**
     * Set name
     *
     * @since 0.1.0
     * @access private
     */
    private function set_name( WP_Taxonomy $taxonomy, WP_Term $term = null ) {
        if ( $term ) {
            $this->name = \sanitize_key( $taxonomy->name . '_' . $term->term_id . '_taxonomy_posts' );
        } else {
            $this->name = \sanitize_key( $taxonomy->name . '_taxonomy_posts' );
        }
    }

    /**
     * Set mod args
     *
     * @since 0.1.0
     * @access private
     */
    private function set_mod_args( WP_Taxonomy $taxonomy, WP_Term $term = null ) {
        $this->mod_args['context'] = 'tax';
        
        if ( 'post_tag' == $taxonomy->name ) {
            $this->mod_args['context'] = 'tag';
        } elseif ( 'category' == $taxonomy->name ) {
            $this->mod_args['context'] = 'category';
        }

        $this->mod_args['specific'] = $taxonomy->name;
        $this->mod_args['more_specific'] = ( $term ? $term->term_id : '' );
    }

    /**
     * Set active callback
     *
     * @since 0.1.0
     * @access private
     */
    private function set_args( WP_Taxonomy $taxonomy, WP_Term $term = null ) {
        $this->args['active_callback'] = function () use ( $taxonomy, $term ): bool {
            $page = $this->posts->customizer()->jentil()->utilities()->page();

            if ( $term ) {
                return ( $page->is( 'tag', $term->term_id )
                    || $page->is( 'category', $term->term_id )
                    || $page->is( 'tax', $taxonomy->name, $term->term_id ) );
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
            $this->args['title'] = \sprintf( \esc_html__( '%1$s Archive: %2$s', 'jentil' ),
                $taxonomy->labels->singular_name, $term->name );
        } else {
            $this->args['title'] = \sprintf( \esc_html__( '%s Archives', 'jentil' ), $taxonomy->labels->singular_name );
        }
    }

    /**
     * Get settings
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Settings.
     */
    protected function settings(): array {
        $settings = [];

        $settings['number'] = new Settings\Number( $this );

        $settings = \array_merge( $settings, parent::settings() );

        $settings['pagination'] = new Settings\Pagination( $this );
        $settings['pagination_maximum'] = new Settings\Pagination_Maximum( $this );
        $settings['pagination_maximum'] = new Settings\Pagination_Position( $this );
        $settings['pagination_previous_label'] = new Settings\Pagination_Previous_Label( $this );
        $settings['pagination_next_label'] = new Settings\Pagination_Next_Label( $this );

        return $settings;
    }
}
