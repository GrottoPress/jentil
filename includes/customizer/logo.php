<?php

/**
 * Logo customizer
 *
 * The sections, settings and controls for our logo
 * options in the customizer (for WordPress < 4.5)
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Customizer;

/**
 * logo customizer
 *
 * The sections, settings and controls for our logo
 * options in the customizer (for WordPress < 4.5)
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
class Logo {
    /**
     * Customizer
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     \GrottoPress\Jentil\Customizer\Customizer     $customizer       Customizer instance
     */
    private $customizer;

    /**
     * Default layout
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         array         $default       Default layout
	 */
    private $default;
    
    /**
     * Are we using WordPress >= 4.5?
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         bool         $custom_logo_supported       WordPress core supports custom logo feature?
	 */
    private $custom_logo_supported;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Customizer $customizer ) {
        $this->customizer = $customizer;

        $this->default = '';
        $this->custom_logo_supported = function_exists( 'get_custom_logo' );
	}
    
    /**
     * Add logo section
     * 
     * @see         https://code.tutsplus.com/tutorials/wordpress-theme-customizer-methodology-for-sections-settings-and-controls-part-1--wp-33238
     * 
     * @since       Jentil 0.1.0
	 * @access      public
     */
    public function add_section( $wp_customize ) {
        if ( $this->custom_logo_supported ) {
            return;
        }
        
        // We'll be using the Core 'title_tagline' Section
        return;
    }
    
    /**
     * Add logo settings
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add_settings( $wp_customize ) {
        if ( $this->custom_logo_supported ) {
            return;
        }
        
        $this->add_logo_setting( $wp_customize );
    }
    
    /**
     * Add logo setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_logo_setting( $wp_customize ) {
        $wp_customize->add_setting(
            'custom_logo',
            array(
                'default'    =>  $this->default,
                //'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add logo controls
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add_controls( $wp_customize ) {
        if ( $this->custom_logo_supported ) {
            return;
        }
        
        $this->add_logo_control( $wp_customize );
    }
    
    /**
     * Add category layout control
     * 
     * @see         https://github.com/WordPress/WordPress/blob/master/wp-includes/class-wp-customize-manager.php
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_logo_control( $wp_customize ) {
        $logo = new \GrottoPress\Jentil\Logo();
        $logo_raw = $logo->raw_attributes();
        
        $wp_customize->add_control( new \WP_Customize_Cropped_Image_Control( $wp_customize, 'custom_logo', array(
			'label'         => esc_html__( 'Logo', 'jentil' ),
			'section'       => 'title_tagline',
			'priority'      => 8,
			'height'        => $logo_raw['height'],
			'width'         => $logo_raw['width'],
			'flex_height'   => $logo_raw['flex-height'],
			'flex_width'    => $logo_raw['flex-width'],
			'button_labels' => array(
				'select'       => esc_html__( 'Select logo', 'jentil' ),
				'change'       => esc_html__( 'Change logo', 'jentil' ),
				'remove'       => esc_html__( 'Remove', 'jentil' ),
				'default'      => esc_html__( 'Default', 'jentil' ),
				'placeholder'  => esc_html__( 'No logo selected', 'jentil' ),
				'frame_title'  => esc_html__( 'Select logo', 'jentil' ),
				'frame_button' => esc_html__( 'Choose logo', 'jentil' ),
		    ),
	    ) ) );
	    
	    $wp_customize->selective_refresh->add_partial( 'custom_logo', array(
			'settings'            => array( 'custom_logo' ),
			'selector'            => '.custom-logo-link',
			'render_callback'     => array( $logo, 'get' ),
			'container_inclusive' => true,
		) );
    }
}