<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use GrottoPress\Jentil\Utilities\ThemeMods;
use GrottoPress\WordPress\SUV\Utilities\ThemeMods\AbstractThemeMod as ThemeMod;

abstract class AbstractThemeMod extends ThemeMod
{
    /**
     * @var ThemeMods
     */
    protected $themeMods;

    public function __construct(ThemeMods $theme_mods)
    {
        $this->themeMods = $theme_mods;
    }
}
