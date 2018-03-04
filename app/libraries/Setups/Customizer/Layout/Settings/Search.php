<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setups\Customizer\Layout\Layout;

final class Search extends AbstractSetting
{
    public function __construct(Layout $layout)
    {
        parent::__construct($layout);

        $this->mod = $this->themeMod(['context' => 'search']);

        $this->id = $this->mod->id;

        $this->args['default'] = $this->mod->default;

        $this->control['label'] = \esc_html__('Search Results', 'jentil');
        $this->control['active_callback'] = function (): bool {
            return $this->section->customizer->app->utilities
                ->page->is('search');
        };
    }
}
