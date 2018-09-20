<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Thumbnails;

use GrottoPress\Jentil\AbstractTheme;

final class Mini extends AbstractThumbnail
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'jentil-mini-thumb';
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
        \add_image_size($this->id, 100, 100, true);
    }
}
