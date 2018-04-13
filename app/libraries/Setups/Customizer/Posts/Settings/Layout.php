<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class Layout extends AbstractSetting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $theme_mod = $this->themeMod('layout');

        $this->id = $theme_mod->id;

        $this->args['default'] = $theme_mod->default;
        $this->args['sanitize_callback'] = 'sanitize_key';

        $this->control['label'] = \esc_html__('Layout', 'jentil');
        $this->control['type'] = 'select';
        $this->control['choices'] = [
            'stack' => \esc_html__('Stack', 'jentil'),
            'grid' => \esc_html__('Grid', 'jentil'),
        ];
    }
}
