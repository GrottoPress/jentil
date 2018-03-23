<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class Excerpt extends AbstractSetting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $themeMod = $this->themeMod('excerpt');

        $this->id = $themeMod->id;

        $this->args['default'] = $themeMod->default;
        $this->args['sanitize_callback'] = function ($value): int {
            return \intval($value);
        };

        $this->control['label'] = \esc_html__('Excerpt', 'jentil');
        $this->control['type'] = 'number';
        $this->control['description'] = \esc_html__(
            "Number of words (or -1, -2)",
            'jentil'
        );
    }
}
