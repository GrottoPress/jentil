<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Title\Settings;

use GrottoPress\Jentil\Setups\Customizer\Title\Title;

final class Error404 extends AbstractSetting
{
    public function __construct(Title $title)
    {
        parent::__construct($title);

        $theme_mod = $this->themeMod(['context' => '404']);

        $this->id = $theme_mod->id;

        $this->args['default'] = $theme_mod->default;
    }
}
