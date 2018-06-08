<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Colophon\Settings;

use GrottoPress\Jentil\Setups\Customizer\Colophon\Colophon as Section;
use GrottoPress\Jentil\Setups\Customizer\AbstractSetting;

final class Colophon extends AbstractSetting
{
    public function __construct(Section $colophon)
    {
        parent::__construct($colophon->customizer);

        $theme_mod = $this->customizer->app->utilities->themeMods->colophon;

        $this->id = $theme_mod->id;

        $this->args['default'] = $theme_mod->default;
        $this->args['transport'] = 'postMessage';
        $this->args['sanitize_callback'] = function ($value): string {
            return \wp_kses($value, 'pre_user_description');
        };
    }
}
