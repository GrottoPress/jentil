<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;
use GrottoPress\Jentil\Utilities\ThemeMods\Posts as PostsMod;
use GrottoPress\Jentil\Setups\Customizer\AbstractSetting as Setting;

abstract class AbstractSetting extends Setting
{
    /**
     * @var AbstractSection
     */
    protected $section;

    public function __construct(AbstractSection $section)
    {
        $this->section = $section;

        parent::__construct($this->section->customizer);
    }

    protected function themeMod(string $setting): PostsMod
    {
        return $this->customizer->app->utilities->themeMods->posts(
            $setting,
            $this->section->themeModArgs
        );
    }
}
