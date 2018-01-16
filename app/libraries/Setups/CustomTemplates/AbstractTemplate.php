<?php

/**
 * Abstract Template
 *
 * @see https://make.wordpress.org/core/2016/11/03/post-type-templates-in-4-7/
 *
 * @package GrottoPress\Jentil\Setups\CustomTemplates
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\CustomTemplates;

use GrottoPress\WordPress\SUV\Setups\AbstractSetup;
use WP_Theme;

/**
 * Abstract Template
 *
 * @since 0.6.0
 */
abstract class AbstractTemplate extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.6.0
     * @access public
     */
    public function run()
    {
        \add_action('wp_loaded', [$this, 'load']);
    }

    /**
     * Load template
     *
     * @since 0.6.0
     * @access public
     *
     * @action wp_loaded
     */
    public function load()
    {
        $post_types = $this->postTypes();
        
        foreach ($post_types as $post_type) {
            \add_action("theme_{$post_type}_templates", [$this, 'add'], 10, 4);
        }
    }

    /**
     * Add template
     *
     * @param array $templates
     * @param WP_Theme $theme
     * @param \WP_Post $post
     * @param string $post_type
     *
     * @since 0.6.0
     * @access public
     *
     * @filter theme_{$post_type}_templates
     *
     * @return array
     */
    abstract public function add(
        array $templates,
        WP_Theme $theme,
        $post,
        string $post_type
    ): array;

    /**
     * Post types to load template for.
     *
     * @since 0.6.0
     * @access protected
     *
     * @return array
     */
    protected function postTypes(): array
    {
        return \get_post_types(['public' => true, 'show_ui' => true]);
    }
}
