<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Controls;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class Image extends AbstractControl
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $this->id = $section->settings['Image']->id;

        $this->args['label'] = \esc_html__('Image size', 'jentil');
        $this->args['type'] = 'select';
        $this->args['choices'] = $this->customizer->app
            ->utilities->page->posts->imageSizes();
    }
}
