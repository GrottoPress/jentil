<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Controls;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class WrapClass extends AbstractControl
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $this->id = $section->settings['WrapClass']->id;

        $this->args['label'] = \esc_html__('Wrapper class', 'jentil');
        $this->args['type'] = 'text';
        $this->args['description'] = \esc_html__(
            'Comma- or space-separated',
            'jentil'
        );
    }
}
