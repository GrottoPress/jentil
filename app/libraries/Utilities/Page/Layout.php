<?php

/**
 * Layout
 *
 * @package GrottoPress\Jentil\Utilities\Page
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Utilities\Page;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

/**
 * Layout
 *
 * @since 1.0.0
 */
final class Layout {
    /**
     * Page
     *
     * @since 0.1.0
     * @access private
     * 
     * @var GrottoPress\Jentil\Utilities\Page\Page $page Page.
     */
    private $page;
    
    /**
     * Constructor
     *
     * @param GrottoPress\Jentil\Utilities\Page\Page $page Page.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Page $page ) {
        $this->page = $page;
    }
    
    /**
     * Get mod
     * 
     * @since 0.1.0
     * @access public
     * 
     * @return string Layout mod.
     */
    public function mod(): string {
        $page = $this->page->type();

        $specific = '';
        $more_specific = '';

        foreach ( $page as $type ) {
            if ( 'post_type_archive' == $type ) {
                $specific = \get_query_var( 'post_type' );
            } elseif ( 'tax' == $type ) {
                $specific = \get_query_var( 'taxonomy' );
            } elseif ( 'category' == $type ) {
                $specific = 'category';
            } elseif ( 'tag' == $type ) {
                $specific = 'post_tag';
            } elseif ( 'singular' == $type ) {
                global $post;

                $specific = $post->post_type;

                if ( \is_post_type_hierarchical( $post->post_type ) ) {
                    $more_specific = $post->ID;
                }
            }

            if ( \is_array( $specific ) ) {
                $specific = $specific[0];
            }

            if ( \is_array( $more_specific ) ) {
                $more_specific = $more_specific[0];
            }

            $mod = $this->page->utilities()->mods()->layout( [
                'context' => $type,
                'specific' => $specific,
                'more_specific' => $more_specific
            ] );

            if ( $mod->name() ) {
                return $mod->get();
            }
        }

        return $mod->default();
    }
    
    /**
     * Layouts
     * 
     * @since 0.1.0
     * @access public
     * 
     * @return array Layout column type
     */
    public function layouts(): array {
        $layouts = [
            'one-column' => [
                'content' => \esc_html__( 'content', 'jentil' ),
            ],
            'two-columns' => [
                'content-sidebar' => \esc_html__( 'content / sidebar', 'jentil' ),
                'sidebar-content' => \esc_html__( 'sidebar / content', 'jentil' ),
            ],
            'three-columns' => [
                'sidebar-content-sidebar' => \esc_html__( 'sidebar / content / sidebar', 'jentil' ),
                'content-sidebar-sidebar' => \esc_html__( 'content / sidebar / sidebar', 'jentil' ),
                'sidebar-sidebar-content' => \esc_html__( 'sidebar / sidebar / content', 'jentil' ),
            ],
        ];

        /**
         * @filter jentil_page_layouts
         *
         * @var array $layouts Layouts.
         *
         * @since 0.1.0
         */
        return \apply_filters( 'jentil_page_layouts', $layouts );
    }

    /**
     * Layouts IDS/slugs
     * 
     * @since 0.1.0
     * @access public
     * 
     * @return array Layout IDs/slugs.
     */
    public function layouts_ids(): array {
        return \array_map( 'sanitize_title', \array_keys( $this->layouts_ids_names() ) );
    }
    
    /**
     * Layouts columns
     * 
     * @since 0.1.0
     * @access public
     * 
     * @return array Layout columns.
     */
    public function layouts_columns(): array {
        return \array_map( 'sanitize_title', \array_keys( $this->layouts() ) );
    }

    /**
     * Layouts [ IDs => Names ]
     * 
     * Used to build a dropdown of layouts.
     * 
     * @since 0.1.0
     * @access public
     * 
     * @return array Layout ids mapping to names.
     */
    public function layouts_ids_names(): array {
        $return = [];
        
        foreach ( $this->layouts() as $column_type => $layouts ) {
            foreach ( $layouts as $layout_id => $layout_name ) {
                $return[ \sanitize_title( $layout_id ) ] = \sanitize_text_field( $layout_name );
            }
        }
    
        return $return;
    }
    
    /**
     * Get current layout's column
     * 
     * @since 0.1.0
     * @access public
     * 
     * @return string Layout column name.
     */
    public function column(): string {
        $layout_ids = [];
        
        foreach ( $this->layouts() as $column_slug => $layouts ) {
            foreach ( $layouts as $layout_id => $layout_name ) {
                if ( $this->mod() == $layout_id ) {
                    return \sanitize_title( $column_slug );
                }
            }
        }
    
        return '';
    }
}
