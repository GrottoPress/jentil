<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Controls;

use GrottoPress\Jentil\Setups\Customizer\Layout;
use GrottoPress\Jentil\Setups\Customizer\AbstractControl as Control;

abstract class AbstractControl extends Control
{
    public function __construct(Layout $layout)
    {
        parent::__construct($layout->customizer);

        $this->args['section'] = $layout->id;
        $this->args['label'] = \esc_html__('Select layout', 'jentil');
        $this->args['type'] = 'select';
        $this->args['choices'] = $this->customizer->app
            ->utilities->page->layouts->IDs();
    }
}
