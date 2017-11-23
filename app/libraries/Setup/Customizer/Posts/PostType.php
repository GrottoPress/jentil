<?php

/**
 * Post Type Section
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
 * Post Type Section
 *
 * @since 0.1.0
 */
final class PostType extends AbstractSection
{
    /**
     * Post type
     *
     * @since 0.1.0
     * @access protected
     *
     * @var WP_Post_Type $post_type Post type.
     */
    protected $post_type;

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

        $this->post_type = $post_type;

        $this->name = \sanitize_key($this->post_type->name.'_post_type_posts');

        $this->modArgs['specific'] = $this->post_type->name;
        $this->modArgs['context'] = (
            'post' == $this->post_type->name ? 'home' : 'post_type_archive'
        );

        $this->args['title'] = \sprintf(
            \esc_html__('%s Archive', 'jentil'),
            $this->post_type->labels->name
        );
        $this->args['active_callback'] = function (): bool {
            $page = $this->posts->customizer->theme->utilities->page;

            if ('post' == $this->post_type->name) {
                return $page->is('home');
            }

            return $page->is('post_type_archive', $this->post_type->name);
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

        if (!$this->posts->customizer->theme->utilities
            ->page->posts->sticky->get($this->post_type->name)
        ) {
            unset($settings['sticky_posts']);
        }

        return $settings;
    }
}
