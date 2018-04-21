<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setups\Customizer\Layout\Layout;
use GrottoPress\Jentil\Utilities\ThemeMods\Layout as LayoutMod;
use GrottoPress\Jentil\Setups\Customizer\AbstractSetting as Setting;

abstract class AbstractSetting extends Setting
{
    public function __construct(Layout $layout)
    {
        parent::__construct($layout->customizer);

        $this->args['sanitize_callback'] = 'sanitize_title';
        $this->args['transport'] = 'postMessage';

        $this->control['section'] = $layout->id;
        $this->control['label'] = \esc_html__('Select layout', 'jentil');
        $this->control['type'] = 'select';
        $this->control['choices'] = $this->customizer->app
            ->utilities->page->layouts->IDs();
    }

    protected function themeMod(array $args): LayoutMod
    {
        return $this->customizer->app->utilities->themeMods->layout($args);
    }
}
