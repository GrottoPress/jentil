<?php

/**
 * Customizer
 *
 * The sections, settings and controls for our theme
 * options in the customizer
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\MagPack;

/**
 * Customizer
 *
 * The sections, settings and controls for our theme
 * options in the customizer
 *
 * @see         https://code.tutsplus.com/tutorials/a-guide-to-the-wordpress-theme-customizer-adding-a-new-setting--wp-33180
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Customizer {
    /**
     * Import traits
     *
     * @since       Jentil 0.1.0
     */
    use MagPack\Utilities\Wizard;

    /**
     * Customizer panels
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         array         $panels           Panels
     */
    protected $panels;

    /**
     * Customizer sections
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         array         $sections           Sections
     */
    protected $sections;

    /**
     * Post types
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $post_types       Post types
     */
    protected $post_types;

    /**
     * Archive Post types
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $archive_post_types       All post types with archive
     */
    protected $archive_post_types;

    /**
     * Taxonomies
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $taxonomies       Taxonomies
     */
    protected $taxonomies;

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
    public function __construct( \GrottoPress\Jentil\Setup\Jentil $jentil ) {
        $this->jentil = $jentil;

        $this->archive_post_types = [];
    }

    /**
     * Allow get
     *
     * Defines the attributes that can be retrieved
     * with our getter.
     *
     * @since       MagPack 0.1.0
     * @access      protected
     *
     * @return      array       Attributes.
     */
    protected function allow_get() {
        return [ 'post_types', 'archive_post_types', 'taxonomies' ];
    }

    /**
     * Register theme customizer
     *
     * @action      customize_register
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add( $wp_customize ) {
        $this->post_types = $this->post_types();
        $this->taxonomies = $this->taxonomies();
        $this->archive_post_types = $this->archive_post_types();

        $this->panels = $this->panels();
        $this->sections = $this->sections();

        $this->add_panels( $wp_customize );
        $this->add_sections( $wp_customize );
    }

    /**
     * Post types
     *
     * @since       Jentil 0.1.0
     * @access      private
     *
     * @return      array       Public post types
     */
    private function post_types() {
        return get_post_types( [
            'public' => true,
            // 'show_ui' => true,
        ], 'objects' );
    }

    /**
     * Taxonomies
     *
     * @since       Jentil 0.1.0
     * @access      private
     *
     * @return      array       Public taxonomies
     */
    private function taxonomies() {
        return get_taxonomies( [
            'public' => true,
            // 'show_ui' => true,
        ], 'objects' );
    }

    /**
     * Archive post types
     *
     * @since       Jentil 0.1.0
     * @access      private
     *
     * @return      array       All post types with archive
     */
    private function archive_post_types() {
        $archive_post_types = [];

        if ( ! $this->post_types ) {
            return $archive_post_types;
        }

        foreach ( $this->post_types as $post_type ) {
            if (
                $post_type->has_archive
                || 'post' == $post_type->name
                // || 'attachment' == $post_type->name
            ) {
                $archive_post_types[ $post_type->name ] = $post_type;
            }
        }

        return $archive_post_types;
    }

    /**
     * Get panels
     *
     * Panels comprise sections which, in turn,
     * comprise settings.
     *
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function panels() {
        $panels = [];

        $panels['posts'] = new Posts\Posts( $this );

        return $panels;
    }

    /**
     * Get sections
     *
     * These sections come under no panel. Each section
     * comprises its settings.
     *
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function sections() {
        $sections = [];

        $sections['logo'] = new Logo\Logo( $this );
        $sections['title'] = new Title\Title( $this );
        $sections['layout'] = new Layout\Layout( $this );
        $sections['colophon'] = new Colophon\Colophon( $this );

        return $sections;
    }
    
    /**
     * Add panels
     *
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_panels( $wp_customize ) {
        if ( ! $this->panels ) {
            return;
        }

        foreach ( $this->panels as $panel ) {
            $panel->add( $wp_customize );
        }
    }

    /**
     * Add sections
     *
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_sections( $wp_customize ) {
        if ( ! $this->sections ) {
            return;
        }

        foreach ( $this->sections as $section ) {
            $section->add( $wp_customize );
        }
    }

    /**
     * Enqueue scripts
     * 
     * @action      customize_preview_init
     * 
     * @since       Jentil 0.1.0
	 * @access      public
     */
    public function js() {
        wp_enqueue_script( 'jentil-customizer',
            $this->jentil->get( 'dir_url' ) . '/assets/javascript/customize-preview.min.js',
            [ 'jquery', 'customize-preview' ],
            '',
            true );
    }

    /**
     * Selective refresh
     * 
     * Add selective refresh support to elements
     * in the customizer.
     * 
     * @see     https://make.wordpress.org/core/2016/03/22/implementing-selective-refresh-support-for-widgets/
     *
     * @since       jentil 0.1.0
     * @since       WordPress 4.5
     * @access      public
     * 
     * @action      after_setup_theme
     */
    public function selective_refresh() {
        add_theme_support( 'customize-selective-refresh-widgets' );
    }
}