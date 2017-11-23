<?php

/**
 * Sticky Posts Section
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Posts
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

use WP_Post_Type;

/**
 * Sticky Posts Section
 *
 * @since 0.1.0
 */
final class Sticky extends AbstractSection
{
    /**
     * Constructor
     *
     * @param Posts $posts Posts.
     * @param WP_Post_Type $post_type Post type.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Posts $posts, WP_Post_Type $post_type)
    {
        parent::__construct($posts);

        $this->name = \sanitize_key($post_type->name.'_sticky_posts');

        $this->modArgs['context'] = 'sticky';
        $this->modArgs['specific'] = $post_type->name;

        // $this->args['panel'] = '';
        $this->args['title'] = \sprintf(\esc_html__(
            'Sticky %s',
            'jentil'
        ), $post_type->labels->name);
        $this->args['active_callback'] = function () use ($post_type): bool {
            $page = $this->posts->customizer->theme->utilities->page;
            $has_sticky = $this->posts->customizer->theme->utilities
                ->page->posts->sticky->get($post_type->name);

            if ('post' == $post_type->name) {
                return ($page->is('home') && $has_sticky);
            }
            
            if (\post_type_exists($post_type->name)) {
                return ($page->is('post_type_archive') && $has_sticky);
            }

            return false;
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
        unset($settings['number']);
        unset($settings['pagination']);
        unset($settings['pagination_maximum']);
        unset($settings['pagination_position']);
        unset($settings['pagination_previous_label']);
        unset($settings['pagination_next_label']);

        return $settings;
    }
}
