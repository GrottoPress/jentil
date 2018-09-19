<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

final class Thumbnail extends AbstractSetup
{
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'addSupport']);
        \add_action('after_setup_theme', [$this, 'setSize']);
        \add_action('after_setup_theme', [$this, 'addSizes']);
    }

    /**
     * @action after_setup_theme
     */
    public function addSupport()
    {
        \add_theme_support('post-thumbnails');
    }

    /**
     * @action after_setup_theme
     */
    public function setSize()
    {
        \set_post_thumbnail_size(640, 360, true);
    }

    /**
     * @action after_setup_theme
     */
    public function addSizes()
    {
        \add_image_size('jentil-mini-thumb', 100, 100, true);
        \add_image_size('jentil-micro-thumb', 75, 75, true);
        \add_image_size('jentil-nano-thumb', 50, 50, true);
    }
}
