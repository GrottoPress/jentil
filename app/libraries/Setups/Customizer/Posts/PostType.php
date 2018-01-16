<?php

/**
 * Post Type Section
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
     * @param Posts $posts Posts panel.
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

        $this->setArgs();
        $this->setModArgs();
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
     * @since 0.5.0
     * @access private
     */
    private function setArgs()
    {
        $this->args['title'] = \sprintf(
            \esc_html__('%s Archive', 'jentil'),
            $this->post_type->labels->name
        );

        $this->args['active_callback'] = function (): bool {
            $page = $this->customizer->app->utilities->page;

            if ('post' === $this->post_type->name) {
                return $page->is('home');
            }

            return $page->is('post_type_archive', $this->post_type->name);
        };
    }

    /**
     * Set mod args
     *
     * @since 0.5.0
     * @access private
     */
    private function setModArgs()
    {
        $this->modArgs['specific'] = $this->post_type->name;
        $this->modArgs['context'] = (
            'post' === $this->post_type->name ? 'home' : 'post_type_archive'
        );
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

        if (!$this->customizer->app->utilities
            ->page->posts->sticky->get($this->post_type->name)
        ) {
            unset($settings['StickyPosts']);
        }

        return $settings;
    }
}
