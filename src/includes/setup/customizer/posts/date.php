<?php

/**
 * Date Section
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Posts
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

/**
 * Date Section
 *
 * @since 0.1.0
 */
final class Date extends Section {
    /**
     * Constructor
     *
     * @var GrottoPress\Jentil\Setup\Posts\Posts $posts Posts.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Posts $posts ) {
        parent::__construct( $posts );

        $this->name = 'date_posts';

        $this->mod_args['context'] = 'date';

        $this->args['title'] = \esc_html__( 'Date Archives', 'jentil' );
        $this->args['active_callback'] = function (): bool {
            return $this->posts->customizer()->jentil()->utilities()->page()->is( 'date' );
        };
    }

    /**
     * Get settings
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Settings.
     */
    protected function settings(): array {
        $settings = [];

        $settings['sticky_posts'] = new Settings\Sticky_Posts( $this );
        $settings['number'] = new Settings\Number( $this );

        $settings = \array_merge( $settings, parent::settings() );

        $settings['pagination'] = new Settings\Pagination( $this );
        $settings['pagination_maximum'] = new Settings\Pagination_Maximum( $this );
        $settings['pagination_position'] = new Settings\Pagination_Position( $this );
        $settings['pagination_previous_label'] = new Settings\Pagination_Previous_Label( $this );
        $settings['pagination_next_label'] = new Settings\Pagination_Next_Label( $this );

        return $settings;
    }
}
