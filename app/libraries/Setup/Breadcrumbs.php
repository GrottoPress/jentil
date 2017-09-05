<?php

/**
 * Breadcrumbs
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
 * Breadcrumbs
 *
 * @since 0.1.0
 */
final class Breadcrumbs extends Setup {
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_action( 'jentil_before_before_title', [ $this, 'render' ] );
    }

    /**
     * Render
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_before_before_title
     */
    public function render() {
        if (
            $this->jentil->utilities()->page()->is( 'front_page' )
            && ! $this->jentil->utilities()->page()->is( 'paged' )
        ) {
            return;
        }

        $args = [
            'before' => \esc_html__( 'Path: ', 'jentil' ),
        ];

        echo $this->jentil->utilities()->breadcrumbs( $args )->render();
    }
}
