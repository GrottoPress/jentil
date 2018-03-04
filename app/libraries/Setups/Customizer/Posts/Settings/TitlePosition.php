<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class TitlePosition extends AbstractSetting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $mod = $this->themeMod('title_position');

        $this->id = $mod->id;

        $this->args['default'] = $mod->default;
        $this->args['sanitize_callback'] = 'sanitize_key';

        $this->control['label'] = \esc_html__('Title position', 'jentil');
        $this->control['description'] = \esc_html__(
            'Relative to image',
            'jentil'
        );
        $this->control['type'] = 'select';
        $this->control['choices'] = [
            'side' => \esc_html__('Side', 'jentil'),
            'top' => \esc_html__('Top', 'jentil'),
        ];
    }
}
