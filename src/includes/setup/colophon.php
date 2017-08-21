<?php

/**
 * Colophon
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

/**
 * Colophon
 *
 * @since 0.1.0
 */
final class Colophon extends Setup {
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_action( 'jentil_inside_footer', [ $this, 'render' ] );
    }

    /**
     * Render
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_footer
     */
    public function render() {
        if (
            ! ( $mod = $this->jentil->utilities()->colophon()->mod() )
            && ! $this->jentil->utilities()->page()->is( 'customize_preview' )
        ) {
            return;
        }

        echo '<div id="colophon"><small>' . $mod . '</small></div><!-- #colophon -->';
    }
}
