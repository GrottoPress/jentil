<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Footer\Controls;

use GrottoPress\Jentil\Setups\Customizer\Footer;

final class Colophon extends AbstractControl
{
    public function __construct(Footer $footer)
    {
        parent::__construct($footer);

        $this->id = $footer->settings['Colophon']->id;

        $this->args['label'] = \esc_html__('Colophon', 'jentil');
        $this->args['type'] = 'textarea';
    }
}
