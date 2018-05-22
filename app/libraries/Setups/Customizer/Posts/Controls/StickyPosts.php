<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Controls;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class StickyPosts extends AbstractControl
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $this->id = $section->settings['StickyPosts']->id;

        $this->args['label'] = \esc_html__('Show sticky posts?', 'jentil');
        $this->args['type'] = 'checkbox';
    }
}
