<?php

/**
 * Layout
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

/**
 * Layout
 *
 * @since 0.1.0
 */
final class Layout extends Setup {
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_filter( 'body_class', [ $this, 'add_body_classes' ] );
        \add_action( 'after_setup_theme', [ $this, 'set_content_width' ] );
    }

    /**
     * Add Body Classes
     *
     * @since 0.1.0
     * @access public
     *
     * @filter body_class
     */
    public function add_body_classes( array $classes ): array {
        if ( ( $mod = $this->jentil->utilities()->page()->layout()->mod() ) ) {
            $classes[] = \sanitize_title( 'layout-' . $mod );
        }

        if ( ( $column = $this->jentil->utilities()->page()->layout()->column() ) ) {
            $classes[] = \sanitize_title( 'layout-' . $column );
        }

        return $classes;
    }

    /**
     * Content width
     *
     * @since 0.1.0
     * @access public
     *
     * @global int $content_width Required by WordPress.
     *
     * @action after_setup_theme
     */
    public function set_content_width() {
        $GLOBALS['content_width'] = 960;
    }
}
