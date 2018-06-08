<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Controls;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class TextOffset extends AbstractControl
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $this->id = $section->settings['TextOffset']->id;

        $this->args['label'] = \esc_html__('Text offset', 'jentil');
        $this->args['type'] = 'number';
        $this->args['description'] = \esc_html__(
            'From image align side (px)',
            'jentil'
        );
    }
}
