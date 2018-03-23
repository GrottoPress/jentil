<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setups\Customizer\Layout\Layout;

final class Date extends AbstractSetting
{
    public function __construct(Layout $layout)
    {
        parent::__construct($layout);

        $this->themeMod = $this->themeMod(['context' => 'date']);

        $this->id = $this->themeMod->id;

        $this->args['default'] = $this->themeMod->default;

        $this->control['label'] = \esc_html__('Date Archives', 'jentil');
        $this->control['active_callback'] = function (): bool {
            return $this->section->customizer->app->utilities
                ->page->is('date');
        };
    }
}
