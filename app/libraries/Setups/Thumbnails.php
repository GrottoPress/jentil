<?php

/**
 * Thumbnails (Featured Images)
 *
 * @package GrottoPress\Jentil\Setups
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use GrottoPress\WordPress\SUV\Setups\AbstractSetup;

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
     * Add/set thumbnail sizes.
     *
     * @since 0.1.0
     * @access public
     *
     * @action after_setup_theme
     */
    public function addSizes()
    {
        \set_post_thumbnail_size(640, 360, true);
        
        \add_image_size('mini-thumb', 100, 100, true);
        \add_image_size('micro-thumb', 75, 75, true);
        \add_image_size('nano-thumb', 50, 50, true);
    }
}
