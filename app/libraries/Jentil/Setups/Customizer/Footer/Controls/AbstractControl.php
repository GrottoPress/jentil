<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Footer\Controls;

use GrottoPress\Jentil\Setups\Customizer\Footer;
use GrottoPress\Jentil\Setups\Customizer\AbstractControl as Control;

abstract class AbstractControl extends Control
{
    public function __construct(Footer $footer)
    {
        parent::__construct($footer->customizer);

        $this->args['section'] = $footer->id;
    }
}
