<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class Number extends AbstractSetting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $themeMod = $this->themeMod('number');

        $this->id = $themeMod->id;

        $this->args['default'] = $themeMod->default;
        $this->args['sanitize_callback'] = function ($value): int {
            return \intval($value);
        };

        $this->control['label'] = \esc_html__('Number of posts', 'jentil');
        $this->control['type'] = 'number';
    }
}
