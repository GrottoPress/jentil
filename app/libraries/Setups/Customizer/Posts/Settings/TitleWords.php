<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class TitleWords extends AbstractSetting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $mod = $this->themeMod('title_words');

        $this->id = $mod->id;

        $this->args['default'] = $mod->default;
        $this->args['sanitize_callback'] = function ($value): int {
            return \intval($value);
        };

        $this->control['label'] = \esc_html__('Title length', 'jentil');
        $this->control['description'] = \esc_html__(
            'Number of words',
            'jentil'
        );
        $this->control['type'] = 'number';
    }
}
