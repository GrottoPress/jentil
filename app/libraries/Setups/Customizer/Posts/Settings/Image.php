<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class Image extends AbstractSetting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $theme_mod = $this->themeMod('image');

        $this->id = $theme_mod->id;

        $this->args['default'] = $theme_mod->default;
        $this->args['sanitize_callback'] = 'sanitize_text_field';

        $this->control['label'] = \esc_html__('Image size', 'jentil');
        $this->control['type'] = 'select';
        $this->control['choices'] = $this->customizer->app
            ->utilities->page->posts->imageSizes();
    }
}
