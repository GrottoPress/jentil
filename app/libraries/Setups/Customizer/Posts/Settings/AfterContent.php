<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class AfterContent extends AbstractSetting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $mod = $this->themeMod('after_content');

        $this->id = $mod->id;

        $this->args['default'] = $mod->default;
        $this->args['sanitize_callback'] = 'sanitize_text_field';

        $this->control['type'] = 'text';
        $this->control['label'] = \esc_html__('After content', 'jentil');
        $this->control['description'] = \esc_html__(
            'Comma-separated',
            'jentil'
        );
    }
}
