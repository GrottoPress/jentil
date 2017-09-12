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

use GrottoPress\Jentil\Setup;
use GrottoPress\Jentil\Utilities;
use \WP_Post_Type;

/**
 * Post Type Section
 *
 * @since 0.1.0
 */
final class PostType extends Section
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

        $this->mod_args['context'] = (
            'post' == $this->post_type->name ? 'home' : 'post_type_archive'
        );
        
        $this->mod_args['specific'] = $this->post_type->name;

        $this->args['title'] = \sprintf(\esc_html__('%s Archive', 'jentil'), $this->post_type->labels->name);
        $this->args['active_callback'] = function (): bool {
            $page = $this->posts->customizer()->jentil()->utilities()->page();

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
     * @return array Settings.
     */
    protected function settings(): array
    {
        $settings = [];

        if ($this->hasSticky()) {
            $settings['sticky_posts'] = new Settings\StickyPosts($this);
        }

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

    /**
     * Does post type have sticky posts?
     *
     * @since 0.1.0
     * @access private
     *
     * @return bool
     */
    private function hasSticky(): bool
    {
        $sticky_posts = \get_option('sticky_posts');

        if ($sticky_posts) {
            foreach ($sticky_posts as $post) {
                if (\get_post_type($post) == $this->post_type->name) {
                    return true;
                }
            }
        }

        return false;
    }
}
