<?php

/**
 * Widgets
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\MagPack;

/**
 * Widgets
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Widgets {
    /**
     * Import traits
     *
     * @since       Jentil 0.1.0
     */
    use MagPack\Utilities\Wizard;

    /**
     * Jentil
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         \GrottoPress\Jentil\Setup\Jentil         $jentil       Jentil
     */
    protected $jentil;

    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Jentil $jentil ) {
        $this->jentil = $jentil;
    }

    /**
     * Register widget areas
     * 
     * @since       Jentil 0.1.0
     * @access      public
     * 
     * @action      widgets_init
     */
    public function register() {
        register_sidebar( [
            'name'          => esc_html__( 'Primary', 'jentil' ),
            'id'            => 'primary-widget-area',
            'description'   => esc_html__( 'Primary widget area', 'jentil' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ] );
        
        register_sidebar( [
            'name'          => esc_html__( 'Secondary', 'jentil' ),
            'id'            => 'secondary-widget-area',
            'description'   => esc_html__( 'Secondary widget area', 'jentil' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ] );
        
        register_sidebar( [
            'name'          => esc_html__( 'Footer', 'jentil' ),
            'id'            => 'footer-widget-area',
            'description'   => esc_html__( 'Footer widget area', 'jentil' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ] );
    }

    /**
     * Footer Widget Area.
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @action      jentil_inside_footer
     */
    public function footer_widgets() {
        if ( ! is_active_sidebar( 'footer-widget-area' ) ) {
            return;
        } ?>

        <aside id="footer-widget-area" class="widget-area">
            <?php dynamic_sidebar( 'footer-widget-area' ); ?>
        </aside><!-- .widget-area -->
    <?php }
}