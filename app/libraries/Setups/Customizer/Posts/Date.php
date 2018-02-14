<?php

/**
 * Date Section
 *
 * @package GrottoPress\Jentil\Setups\Customizer\Posts
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use WP_Customize_Manager as WPCustomizer;

/**
 * Date Section
 *
 * @since 0.1.0
 */
final class Date extends AbstractSection
{
    /**
     * Constructor
     *
     * @param Posts $posts Posts.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Posts $posts)
    {
        parent::__construct($posts);
        
        $this->name = 'date_posts';
        
        $this->modArgs['context'] = 'date';

        $this->args['title'] = \esc_html__('Date Archives', 'jentil');
        $this->args['active_callback'] = function (): bool {
            return $this->customizer->app->utilities->page->is('date');
        };
    }

    /**
     * Add section
     *
     * @param WPCustomizer $WPCustomizer
     *
     * @since 0.1.0
     * @access public
     */
    public function add(WPCustomizer $WPCustomizer)
    {
        $this->settings = $this->settings();

        parent::add($WPCustomizer);
    }

    /**
     * Settings
     *
     * @since 0.1.0
     * @access protected
     *
     * @return Settings\AbstractSetting[] Settings.
     */
    protected function settings(): array
    {
        $settings = parent::settings();

        unset($settings['StickyPosts'], $settings['Heading']);

        return $settings;
    }
}
