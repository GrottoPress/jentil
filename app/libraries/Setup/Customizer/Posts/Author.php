<?php

/**
 * Author Section
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
 * Author Section
 *
 * @since 0.1.0
 */
final class Author extends AbstractSection
{
    /**
     * Constructor
     *
     * @param Posts $posts Posts panel.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Posts $posts)
    {
        parent::__construct($posts);

        $this->name = 'author_posts';
        
        $this->modArgs['context'] = 'author';

        $this->args['title'] = \esc_html__('Author Archives', 'jentil');
        $this->args['active_callback'] = function (): bool {
            return $this->panel->customizer->theme->utilities
                ->page->is('author');
        };
    }

    /**
     * Get settings
     *
     * @since 0.1.0
     * @access protected
     *
     * @return Settings\AbstractSetting[] Settings.
     */
    protected function settings(): array
    {
        $settings = parent::settings();

        unset($settings['sticky_posts']);

        return $settings;
    }
}
