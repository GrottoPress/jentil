<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Controls;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class TitleWords extends AbstractControl
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $this->id = $section->settings['TitleWords']->id;

        $this->args['label'] = \esc_html__('Title length', 'jentil');
        $this->args['type'] = 'number';
        $this->args['description'] = \esc_html__(
            "Number of words (or '-1')",
            'jentil'
        );
    }
}
