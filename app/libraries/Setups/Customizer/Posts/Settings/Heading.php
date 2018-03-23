<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class Heading extends AbstractSetting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $themeMod = $this->themeMod('heading');

        $this->id = $themeMod->id;

        $this->args['default'] = $themeMod->default;
        $this->args['transport'] = 'postMessage';
        $this->args['sanitize_callback'] = 'sanitize_text_field';

        $this->control['label'] = \esc_html__('Heading', 'jentil');
        $this->control['type'] = 'text';
        $this->control['description'] = \esc_html__('Posts heading', 'jentil');
    }
}
