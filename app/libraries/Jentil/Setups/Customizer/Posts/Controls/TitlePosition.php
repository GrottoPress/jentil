<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Controls;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class TitlePosition extends AbstractControl
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $this->id = $section->settings['TitlePosition']->id;

        $this->args['label'] = \esc_html__('Title position', 'jentil');
        $this->args['description'] = \esc_html__('Relative to image', 'jentil');
        $this->args['type'] = 'select';
        $this->args['choices'] = [
            'side' => \esc_html__('Side', 'jentil'),
            'top' => \esc_html__('Top', 'jentil'),
        ];
    }
}
