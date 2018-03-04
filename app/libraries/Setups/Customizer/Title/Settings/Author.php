<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Title\Settings;

use GrottoPress\Jentil\Setups\Customizer\Title\Title;

final class Author extends AbstractSetting
{
    public function __construct(Title $title)
    {
        parent::__construct($title);

        $this->mod = $this->themeMod(['context' => 'author']);

        $this->id = $this->mod->id;

        $this->args['default'] = $this->mod->default;

        $this->control['label'] = \esc_html__('Author Archives', 'jentil');
        $this->control['active_callback'] = function (): bool {
            return $this->section->customizer->app->utilities
                ->page->is('author');
        };
    }
}
