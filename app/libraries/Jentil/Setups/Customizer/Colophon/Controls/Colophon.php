<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Colophon\Controls;

use GrottoPress\Jentil\Setups\Customizer\Colophon as Section;
use GrottoPress\Jentil\Setups\Customizer\AbstractControl;

final class Colophon extends AbstractControl
{
    public function __construct(Section $colophon)
    {
        parent::__construct($colophon->customizer);

        $this->id = $colophon->settings['Colophon']->id;

        $this->args['section'] = $colophon->id;
        $this->args['label'] = \esc_html__('Colophon', 'jentil');
        $this->args['type'] = 'textarea';
    }
}
