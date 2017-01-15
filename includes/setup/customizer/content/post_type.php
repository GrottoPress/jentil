<?php

/**
 * Post type archive content customizer section
 *
 * The sections, settings and controls for our
 * Post type archive content section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Content;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup\Customizer;

/**
 * Post type archive content customizer section
 *
 * The sections, settings and controls for our
 * Post type archive content section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */
class Post_Type extends Content {
    /**
     * Post type
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     \WP_Post_Type      $post_type       Post type object
     */
    protected $layouts;

    /**
     * Constructor
     *
     * @var         \WP_Post_Type      $post_type       Post type object
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Customizer\Customizer $customizer, $post_type ) {
        $this->post_type = $post_type;
        $this->name = sanitize_key( $this->post_type->name . '_post_type_content' );
        $this->args = array(
            'title' => sprintf(
                esc_html__( '%s Archive Content', 'jentil' ),
                $this->post_type->labels->singular_name
            ),
            //'priority' => 200,
        );

        parent::__construct( $customizer );
    }

    /**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings() {
        $settings = array();

        if ( 'post' == $this->post_type->name ) {
            $settings[] = new Settings\Sticky_Posts( $this );
        }

        $settings[] = new Settings\Wrap_Class( $this );
        $settings[] = new Settings\Layout( $this );
        $settings[] = new Settings\Number( $this );
        $settings[] = new Settings\Before_Title( $this );
        $settings[] = new Settings\Title_Words( $this );
        $settings[] = new Settings\Title_Position( $this );
        $settings[] = new Settings\After_Title( $this );
        $settings[] = new Settings\Image( $this );
        $settings[] = new Settings\Image_Alignment( $this );
        $settings[] = new Settings\Image_Margin( $this );
        $settings[] = new Settings\Text_Offset( $this );
        $settings[] = new Settings\Excerpt( $this );
        $settings[] = new Settings\After_Content( $this );
        $settings[] = new Settings\Pagination_Position( $this );

        return $settings;
    }
}