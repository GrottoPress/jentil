<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Title\Settings;

use GrottoPress\Jentil\Setups\Customizer\Title;
use GrottoPress\Jentil\Utilities\ThemeMods\Title as TitleMod;
use GrottoPress\Jentil\Setups\Customizer\AbstractSetting as Setting;

abstract class AbstractSetting extends Setting
{
    public function __construct(Title $title)
    {
        parent::__construct($title->customizer);

        $this->args['transport'] = 'postMessage';
        $this->args['sanitize_callback'] = 'wp_kses_data';
    }

    /**
     * @param array<string, mixed> $args
     */
    protected function themeMod(array $args): TitleMod
    {
        return $this->customizer->app->utilities->themeMods->title($args);
    }
}
