<?php

/**
 * Sticky Posts Section
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
        
        $this->name = \sanitize_key("{$post_type->name}_sticky_posts");
        
        $this->setArgs($post_type);
        $this->setModArgs($post_type);
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
     * Set args
     *
     * @param WP_Post_Type $post_type Post type.
     *
     * @since 0.5.0
     * @access private
     */
    private function setArgs(WP_Post_Type $post_type)
    {
        $this->args['title'] = \sprintf(
            \esc_html__('Sticky %s', 'jentil'),
            $post_type->labels->name
        );

        $this->args['active_callback'] = function () use ($post_type): bool {
            $page = $this->customizer->app->utilities->page;
            $has_sticky = $this->customizer->app->utilities
                ->page->posts->sticky->get($post_type->name);

            if ('post' === $post_type->name) {
                return ($page->is('home') && $has_sticky);
            }
            
            if (\post_type_exists($post_type->name)) {
                return ($page->is('post_type_archive') && $has_sticky);
            }

            return false;
        };
    }

    /**
     * Set mod args
     *
     * @param WP_Post_Type $post_type Post type.
     *
     * @since 0.5.0
     * @access private
     */
    private function setModArgs(WP_Post_Type $post_type)
    {
        $this->modArgs['context'] = 'sticky';
        $this->modArgs['specific'] = $post_type->name;
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

        unset(
            $settings['StickyPosts'],
            $settings['Number'],
            $settings['Pagination'],
            $settings['PaginationMaximum'],
            $settings['PaginationPosition'],
            $settings['PaginationPrevious_label'],
            $settings['PaginationNextLabel']
        );

        return $settings;
    }
}
