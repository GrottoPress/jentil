<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Controls;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class WrapTag extends AbstractControl
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $this->id = $section->settings['WrapTag']->id;

        $this->args['label'] = \esc_html__('Wrapper tag', 'jentil');
        $this->args['type'] = 'text';
    }
}
