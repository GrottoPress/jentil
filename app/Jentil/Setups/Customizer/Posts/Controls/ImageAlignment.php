<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Controls;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class ImageAlignment extends AbstractControl
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $this->id = $section->settings['ImageAlignment']->id;

        $this->args['label'] = \esc_html__('Image alignment', 'jentil');
        $this->args['type'] = 'select';
        $this->args['choices'] = [
            'none' => \esc_html__('none', 'jentil'),
            'left' => \esc_html__('Left', 'jentil'),
            'right' => \esc_html__('Right', 'jentil'),
        ];
    }
}
