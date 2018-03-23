<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;
use GrottoPress\Jentil\Utilities\ThemeMods\Posts as PostsMod;
use GrottoPress\Jentil\Setups\Customizer\AbstractSetting as Setting;

abstract class AbstractSetting extends Setting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $this->control['section'] = $this->section->id;
    }

    protected function themeMod(string $setting): PostsMod
    {
        return (
            $this->section->panel->customizer->app->utilities->themeMods->posts(
                $setting,
                $this->section->themeModArgs
            )
        );
    }
}
