<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Footer\Settings;

use GrottoPress\Jentil\Setups\Customizer\Footer;
use GrottoPress\Jentil\Utilities\ThemeMods\Footer as FooterMod;
use GrottoPress\Jentil\Setups\Customizer\AbstractSetting as Setting;

abstract class AbstractSetting extends Setting
{
    public function __construct(Footer $footer)
    {
        parent::__construct($footer->customizer);
    }

    protected function themeMod(string $setting): FooterMod
    {
        return $this->customizer->app->utilities->themeMods->footer($setting);
    }
}
