<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

final class FeaturedImage extends AbstractSetup
{
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'addSupport']);
        \add_action('after_setup_theme', [$this, 'setSize']);
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
}
