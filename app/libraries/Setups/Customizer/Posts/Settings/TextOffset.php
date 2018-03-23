<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class TextOffset extends AbstractSetting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $themeMod = $this->themeMod('text_offset');

        $this->id = $themeMod->id;

        $this->args['default'] = $themeMod->default;
        $this->args['sanitize_callback'] = 'absint';

        $this->control['label'] = \esc_html__('Text offset', 'jentil');
        $this->control['description'] = \esc_html__(
            'From image align side (px)',
            'jentil'
        );
        $this->control['type'] = 'number';
    }
}
