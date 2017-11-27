<?php

/**
 * Search Section
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Posts
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

/**
 * Search Section
 *
 * @since 0.1.0
 */
final class Search extends AbstractSection
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

        $this->name = 'search_posts';

        $this->modArgs['context'] = 'search';

        $this->args['title'] = \esc_html__('Search Results', 'jentil');
        $this->args['active_callback'] = function (): bool {
            return $this->panel->customizer->theme->utilities
                ->page->is('search');
        };
    }

    /**
     * Get settings
     *
     * @since  0.1.0
     * @access protected
     */
    protected function getSettings(): array
    {
        $settings = parent::getSettings();

        unset($settings['sticky_posts']);

        return $settings;
    }
}
