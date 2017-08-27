<?php

/**
 * Widgets
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
 * Widgets
 *
 * @since 0.1.0
 */
final class Widgets extends Setup {
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run() {
        \add_action( 'widgets_init', [ $this, 'register_widget_areas' ] );
        \add_action( 'jentil_inside_footer', [ $this, 'render_footer_widgets' ] );
    }

    /**
     * Register widget areas
     * 
     * @since entil 0.1.0
     * @access public
     * 
     * @action widgets_init
     */
    public function register_widget_areas() {
        \register_sidebar( [
            'name'          => \esc_html__( 'Primary', 'jentil' ),
            'id'            => 'primary-widget-area',
            'description'   => \esc_html__( 'Primary widget area', 'jentil' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ] );
        
        \register_sidebar( [
            'name'          => \esc_html__( 'Secondary', 'jentil' ),
            'id'            => 'secondary-widget-area',
            'description'   => \esc_html__( 'Secondary widget area', 'jentil' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ] );
        
        \register_sidebar( [
            'name'          => \esc_html__( 'Footer', 'jentil' ),
            'id'            => 'footer-widget-area',
            'description'   => \esc_html__( 'Footer widget area', 'jentil' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ] );
    }

    /**
     * Footer Widget Area.
     *
     * Render the footer widget area
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_footer
     */
    public function render_footer_widgets() {
        if ( ! \is_active_sidebar( 'footer-widget-area' ) ) {
            return;
        } ?>

        <aside id="footer-widget-area" class="widget-area">
            <?php \dynamic_sidebar( 'footer-widget-area' ); ?>
        </aside><!-- .widget-area -->
    <?php }
}
