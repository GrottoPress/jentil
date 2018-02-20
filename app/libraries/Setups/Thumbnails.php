<?php

/**
 * Thumbnails (Featured Images)
 *
 * @package GrottoPress\Jentil\Setups
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

/**
 * Thumbnails (Featured Images)
 *
 * @since 0.1.0
 */
final class Thumbnails extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'addSupport']);
        \add_action('after_setup_theme', [$this, 'setThumbnailSize']);
        \add_action('after_setup_theme', [$this, 'addSizes']);
    }

    /**
     * Add support
     *
     * Add support for featured images (post thumbnails).
     *
     * @since 0.1.0
     * @access public
     *
     * @action after_setup_theme
     */
    public function addSupport()
    {
        \add_theme_support('post-thumbnails');
    }

    /**
     * Set post thumbnail size
     *
     * @since 0.6.0
     * @access public
     *
     * @action after_setup_theme
     */
    public function setSize()
    {
        \set_post_thumbnail_size(640, 360, true);
    }

    /**
     * Add additional thumbnail sizes.
     *
     * @since 0.1.0
     * @access public
     *
     * @action after_setup_theme
     */
    public function addSizes()
    {
        \add_image_size('mini-thumb', 100, 100, true);
        \add_image_size('micro-thumb', 75, 75, true);
        \add_image_size('nano-thumb', 50, 50, true);
    }
}
