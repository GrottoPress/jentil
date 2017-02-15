<?php

/**
 * Search archive content customizer section
 *
 * The sections, settings and controls for our
 * Search archive content section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Content\Sections;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

/**
 * Search archive content customizer section
 *
 * The sections, settings and controls for our
 * Search archive content section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */
final class Search extends Section {
    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Setup\Customizer\Content\Content $content ) {
        parent::__construct( $content );

        $this->name = 'search_' . $this->content->get( 'name' );
        $this->args = array(
            'title' => esc_html__( 'Search Content', 'jentil' ),
            'panel' => $this->content->get( 'name' ),
        );

        $this->default['wrap_class'] = 'archive-posts';
        $this->default['image'] = 'nano-thumb';
        $this->default['title_position'] = 'top';
        $this->default['after_title'] = 'post_type, comments_link';
        $this->default['excerpt'] = '160';
    }
}