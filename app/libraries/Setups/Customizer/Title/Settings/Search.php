<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Title\Settings;

use GrottoPress\Jentil\Setups\Customizer\Title\Title;

final class Search extends AbstractSetting
{
    public function __construct(Title $title)
    {
        parent::__construct($title);

        $theme_mod = $this->themeMod(['context' => 'search']);

        $this->id = $theme_mod->id;

        $this->args['default'] = $theme_mod->default;

        $this->control['label'] = \esc_html__('Search Results', 'jentil');
        $this->control['active_callback'] = function (): bool {
            return $this->customizer->app->utilities->page->is('search');
        };
    }
}
