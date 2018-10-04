<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Thumbnails;

use GrottoPress\Jentil\AbstractTheme;

final class Nano extends AbstractThumbnail
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = "{$this->app->meta['slug']}-nano";
    }

    public function run()
    {
        \add_action('after_setup_theme', [$this, 'addSize']);
    }

    /**
     * @action after_setup_theme
     */
    public function addSize()
    {
        \add_image_size($this->id, 50, 50, true);
    }
}
