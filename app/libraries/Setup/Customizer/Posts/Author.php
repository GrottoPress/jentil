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
final class Author extends Section
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

        $this->name = 'author_posts';
        
        $this->mod_args['context'] = 'author';

        $this->args['title'] = \esc_html__('Author Archives', 'jentil');
        $this->args['active_callback'] = function (): bool {
            return $this->posts->customizer()->jentil()->utilities()
                ->page()->is('author');
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
    protected function settings(): array
    {
        $settings = [];

        $settings['sticky_posts'] = new Settings\StickyPosts($this);
        $settings['number'] = new Settings\Number($this);

        $settings = \array_merge($settings, parent::settings());

        $settings['pagination'] = new Settings\Pagination($this);
        $settings['pagination_maximum'] = new Settings\PaginationMaximum($this);
        $settings['pagination_position'] =
            new Settings\PaginationPosition($this);
        $settings['pagination_previous_label'] =
            new Settings\PaginationPreviousLabel($this);
        $settings['pagination_next_label'] =
            new Settings\PaginationNextLabel($this);

        return $settings;
    }
}
