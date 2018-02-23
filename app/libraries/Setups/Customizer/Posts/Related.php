<?php

/**
 * Related Posts Section
 *
 * @package GrottoPress\Jentil\Setups\Customizer\Posts
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use WP_Customize_Manager as WPCustomizer;
use WP_Post_Type;

/**
 * Related Posts Section
 *
 * @since 0.6.0
 */
final class Related extends AbstractSection
{
    /**
     * Constructor
     *
     * @param Posts $posts Posts.
     * @param WP_Post_Type $post_type Post type.
     *
     * @since 0.6.0
     * @access public
     */
    public function __construct(Posts $posts, WP_Post_Type $post_type)
    {
        parent::__construct($posts);

        $this->name = \sanitize_key("{$post_type->name}_related_posts");

        $this->setArgs($post_type);
        $this->setModArgs($post_type);
    }

    /**
     * Add section
     *
     * @param WPCustomizer $WPCustomizer
     *
     * @since 0.6.0
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
     * @since 0.6.0
     * @access private
     */
    private function setArgs(WP_Post_Type $post_type)
    {
        $this->args['title'] = \sprintf(
            \esc_html__('Related %s', 'jentil'),
            $post_type->labels->name
        );

        $this->args['active_callback'] = function () use ($post_type): bool {
            $utilities = $this->customizer->app->utilities;

            if ($utilities->postTypeTemplate->isPageBuilder() ||
                !\post_type_exists($post_type->name)
            ) {
                return false;
            }

            return $this->customizer->app->utilities->page->is(
                'singular',
                $post_type->name
            );
        };
    }

    /**
     * Set mod args
     *
     * @param WP_Post_Type $post_type Post type.
     *
     * @since 0.6.0
     * @access private
     */
    private function setModArgs(WP_Post_Type $post_type)
    {
        $this->modArgs['context'] = 'related';
        $this->modArgs['specific'] = $post_type->name;
    }

    /**
     * Get settings
     *
     * @since 0.6.0
     * @access protected
     *
     * @return Settings\AbstractSetting[] Settings.
     */
    protected function settings(): array
    {
        $settings = parent::settings();

        unset(
            $settings['StickyPosts'],
            $settings['Pagination'],
            $settings['PaginationMaximum'],
            $settings['PaginationPosition'],
            $settings['PaginationPreviousText'],
            $settings['PaginationNextText']
        );

        return $settings;
    }
}
