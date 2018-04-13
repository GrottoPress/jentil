<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Title\Settings;

use GrottoPress\Jentil\Setups\Customizer\Title\Title;
use GrottoPress\Jentil\Utilities\ThemeMods\Title as TitleMod;
use GrottoPress\Jentil\Setups\Customizer\AbstractSetting as Setting;

abstract class AbstractSetting extends Setting
{
    /**
     * @var TitleMod
     */
    protected $themeMod;

    public function __construct(Title $title)
    {
        parent::__construct($title);

        $this->args['transport'] = 'postMessage';
        $this->args['sanitize_callback'] = 'wp_kses_data';

        $this->control['section'] = $this->section->id;
        $this->control['label'] = \esc_html__('Enter title', 'jentil');
        $this->control['type'] = 'text';
    }

    protected function themeMod(array $args): TitleMod
    {
        return $this->section->customizer->app->utilities->themeMods->title(
            $args
        );
    }
}
