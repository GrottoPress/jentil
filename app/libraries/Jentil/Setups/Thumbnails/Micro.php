<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Thumbnails;

use GrottoPress\Jentil\AbstractTheme;

final class Micro extends AbstractThumbnail
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = "{$this->app->theme->stylesheet}-micro";
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
        \add_image_size($this->id, 75, 75, true);
    }
}
