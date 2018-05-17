<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class TitleWords extends AbstractSetting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $theme_mod = $this->themeMod('title_words');

        $this->id = $theme_mod->id;

        $this->args['default'] = $theme_mod->default;
        $this->args['sanitize_callback'] = function ($value): int {
            return \intval($value);
        };

        $this->control['label'] = \esc_html__('Title length', 'jentil');
        $this->control['type'] = 'number';
        $this->control['description'] = \esc_html__(
            "Number of words (or '-1')",
            'jentil'
        );
    }
}
