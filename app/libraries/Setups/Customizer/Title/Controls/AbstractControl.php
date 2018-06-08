<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Title\Controls;

use GrottoPress\Jentil\Setups\Customizer\Title\Title;
use GrottoPress\Jentil\Setups\Customizer\AbstractControl as Control;

abstract class AbstractControl extends Control
{
    public function __construct(Title $title)
    {
        parent::__construct($title->customizer);

        $this->args['section'] = $title->id;
        $this->args['label'] = \esc_html__('Enter title', 'jentil');
        $this->args['type'] = 'text';
    }
}
