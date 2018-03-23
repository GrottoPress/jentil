<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class ImageAlignment extends AbstractSetting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $themeMod = $this->themeMod('image_alignment');

        $this->id = $themeMod->id;

        $this->args['default'] = $themeMod->default;
        $this->args['sanitize_callback'] = 'sanitize_title';

        $this->control['label'] = \esc_html__('Image alignment', 'jentil');
        $this->control['type'] = 'select';
        $this->control['choices'] = [
            'none' => \esc_html__('none', 'jentil'),
            'left' => \esc_html__('Left', 'jentil'),
            'right' => \esc_html__('Right', 'jentil'),
        ];
    }
}
