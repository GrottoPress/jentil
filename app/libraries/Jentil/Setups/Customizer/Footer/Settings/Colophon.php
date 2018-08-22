<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Footer\Settings;

use GrottoPress\Jentil\Setups\Customizer\Footer;

final class Colophon extends AbstractSetting
{
    public function __construct(Footer $footer)
    {
        parent::__construct($footer);

        $theme_mod = $this->themeMod('colophon');

        $this->id = $theme_mod->id;

        $this->args['default'] = $theme_mod->default;
        $this->args['transport'] = 'postMessage';
        $this->args['sanitize_callback'] = function ($value): string {
            return \wp_kses($value, 'pre_user_description');
        };
    }
}
