<?php

/**
 * Logo customizer setting
 *
 * Add settings and controls for our logo
 * options in the customizer (for WordPress < 4.5)
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes/setup
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Logo\Settings;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;
use GrottoPress\Jentil\Utilities;

/**
 * Logo customizer setting
 *
 * Add settings and controls for our logo
 * options in the customizer (for WordPress < 4.5)
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes/setup
 * @since			Jentil 0.1.0
 */
final class Logo extends Setup\Customizer\Setting {
    /**
     * Logo section
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     \GrottoPress\Jentil\Setup\Customizer\Logo\Logo     $logo       Logo section instance
     */
    private $logo;

    /**
     * Mod
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     \GrottoPress\Jentil\Utilities\Mod\Logo     $mod     Logo mod
     */
    private $mod;

    /**
     * Logo utility
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     \GrottoPress\Jentil\Utilities\Logo\Logo     $ulogo       Logo utility
     */
    private $ulogo;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Setup\Customizer\Logo\Logo $logo ) {
        $this->logo = $logo;

        $this->ulogo = new Utilities\Logo();

        $this->mod = new Utilities\Mods\Logo();

        $this->name = $this->mod->get( 'name' );
        
        $this->args = array(
            'transport' => 'postMessage',
            'default' => $this->mod->get( 'default' ),
            'sanitize_callback' => 'absint',
        );

        $logo_raw = $this->ulogo->raw_attributes();

        $this->control = array(
            'label'         => esc_html__( 'Logo', 'jentil' ),
            'section'       => 'title_tagline',
            'settings'      => $this->name,
            'priority'      => 8,
            'height'        => absint( $logo_raw['height'] ),
            'width'         => absint( $logo_raw['width'] ),
            'flex_height'   => ( bool ) $logo_raw['flex-height'],
            'flex_width'    => ( bool ) $logo_raw['flex-width'],
            'button_labels' => array(
                'select'       => esc_html__( 'Select logo', 'jentil' ),
                'change'       => esc_html__( 'Change logo', 'jentil' ),
                'remove'       => esc_html__( 'Remove', 'jentil' ),
                'default'      => esc_html__( 'Default', 'jentil' ),
                'placeholder'  => esc_html__( 'No logo selected', 'jentil' ),
                'frame_title'  => esc_html__( 'Select logo', 'jentil' ),
                'frame_button' => esc_html__( 'Choose logo', 'jentil' ),
            ),
        );
	}

    /**
     * Add setting
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add( $wp_customize ) {
        if ( function_exists( 'get_custom_logo' ) ) {
            return;
        }

        $wp_customize->add_setting( $this->name, $this->args );

        if ( class_exists( '\WP_Customize_Cropped_Image_Control' ) ) {
            $wp_customize->add_control( new \WP_Customize_Cropped_Image_Control(
                 $wp_customize, $this->name, $this->control
            ) );
        } //else {
            // $wp_customize->add_control( new \WP_Customize_Image_Control(
            //     $wp_customize, $this->name, $this->control
            // ) );
        // }

        if ( isset( $wp_customize->selective_refresh ) ) {
            $wp_customize->selective_refresh->add_partial( $this->name, array(
                'settings'            => array( $this->name ),
                'selector'            => '.custom-logo-link',
                'render_callback'     => array( $this->ulogo, 'markup' ),
                'container_inclusive' => true,
            ) );
        }
    }
}