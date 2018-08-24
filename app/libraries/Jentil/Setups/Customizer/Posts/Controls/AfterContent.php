<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Controls;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class AfterContent extends AbstractControl
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $this->id = $section->settings['AfterContent']->id;

        $this->args['type'] = 'text';
        $this->args['label'] = \esc_html__('After content', 'jentil');
        $this->args['description'] = \esc_html__('Comma-separated', 'jentil');
    }
}
