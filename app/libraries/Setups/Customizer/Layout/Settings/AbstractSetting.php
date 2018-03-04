<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setups\Customizer\Layout\Layout;
use GrottoPress\Jentil\utilities\ThemeMods\Layout as LayoutMod;
use GrottoPress\Jentil\Setups\Customizer\AbstractSetting as Setting;

abstract class AbstractSetting extends Setting
{
    /**
     * @var LayoutMod
     */
    protected $mod;

    protected function __construct(Layout $layout)
    {
        parent::__construct($layout);

        $this->args['sanitize_callback'] = 'sanitize_title';

        $this->control['section'] = $this->section->id;
        $this->control['label'] = \esc_html__('Select layout', 'jentil');
        $this->control['type'] = 'select';
        $this->control['choices'] = $this->section->customizer->app
            ->utilities->page->layouts->IDs();
    }

    protected function themeMod(array $args): LayoutMod
    {
        return
            $this->section->customizer->app->utilities->themeMods->layout(
                $args
            );
    }
}
