<?php

/**
 * Layout
 *
 * @package GrottoPress\Jentil\Utilities\Mods
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Utilities\Mods;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

/**
 * Layout
 *
 * @since 0.1.0
 */
final class Layout extends Mod {
    /**
     * Context
     *
     * @since 0.1.0
     * @access protected
     * 
     * @var string $context Page type.
     */
    protected $context;

    /**
     * Specific page type
     *
     * @since 0.1.0
     * @access protected
     * 
     * @var string $specific Post type or taxonomy name.
     */
    protected $specific;

    /**
     * More specific page type
     *
     * @since 0.1.0
     * @access protected
     * 
     * @var mixed $more_specific Post ID or term ID/name.
     */
    protected $more_specific;

    /**
     * Constructor
     * 
     * @var array $args Mod args
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Mods $mods, array $args = [] ) {
        $this->set_attributes( $args );

        parent::__construct( $mods );
    }

    /**
     * Set attributes
     *
     * @since 0.1.0
     * @access private
     */
    private function set_attributes( array $args ) {
        $args = \wp_parse_args( $args, [
            'context' => '',
            'specific' => '',
            'more_specific' => '',
        ] );

        $this->context = \sanitize_key( $args['context'] );
        $this->more_specific = \sanitize_key( $args['more_specific'] );
        $this->default = 'content-sidebar';

        $this->specific = \post_type_exists( $args['specific'] )
            || \taxonomy_exists( $args['specific'] ) ? $args['specific'] : '';

        $names = $this->names();
        $this->name = isset( $names[ $this->context ] )
            ? \sanitize_key( $names[ $this->context ] ) : '';
    }

    /**
     * Get mod names
     *
     * @since 0.1.0
     * @access private
     *
     * @return array Mod names.
     */
    private function names(): array {
        $names = [
            'home' => 'post_post_type_layout',
            'singular' => ( \is_post_type_hierarchical( $this->specific ) ? 'layout'
                : 'singular_' . $this->specific . '_' . $this->more_specific . '_layout' ),
            'author' => 'author_layout',
            'category' => 'category_' . $this->more_specific . '_taxonomy_layout',
            'date' => 'date_layout',
            'post_type_archive' => $this->specific . '_post_type_layout',
            'tag' => 'post_tag_' . $this->more_specific . '_taxonomy_layout',
            'tax' => $this->specific . '_' . $this->more_specific . '_taxonomy_layout',
            '404' => 'error_404_layout',
            'search' => 'search_layout',
        ];

        $names = \array_map( function ( string $value ): string {
            $value = \str_replace( '__', '_', $value );
            $value = \trim( $value, '_' );

            return $value;
        }, $names );

        /**
         * @filter jentil_layout_mod_names
         *
         * @var string $names Layout mod names.
         *
         * @since 0.1.0
         */
        return \apply_filters( 'jentil_layout_mod_names', $names,
            $this->context, $this->specific, $this->more_specific );
    }

    /**
     * Get mod
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Mod.
     */
    public function get(): string {
        if ( ! $this->name ) {
            return false;
        }

        if ( \is_post_type_hierarchical( $this->specific ) ) {
            if ( ( $mod = \get_post_meta( $this->more_specific, $this->name, true ) ) ) {
                return \sanitize_title( $mod );
            } 

            return $this->default;
        }

        return \sanitize_title( parent::get() );
    }
}
