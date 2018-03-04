<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Colophon\Settings;

use GrottoPress\Jentil\Setups\Customizer\Colophon\Colophon as Section;
use GrottoPress\Jentil\Setups\Customizer\AbstractSetting;

final class Colophon extends AbstractSetting
{
    public function __construct(Section $colophon)
    {
        parent::__construct($colophon);

        $mod = $this->section->customizer->app->utilities
            ->themeMods->colophon;

        $this->id = $mod->id;

        $this->args['default'] = $mod->default;
        $this->args['transport'] = 'postMessage';
        $this->args['sanitize_callback'] = function (string $value): string {
            return \wp_kses($value, 'pre_user_description');
        };

        $this->control['section'] = $this->section->id;
        $this->control['label'] = \esc_html__('Colophon', 'jentil');
        $this->control['type'] = 'textarea';
    }
}
