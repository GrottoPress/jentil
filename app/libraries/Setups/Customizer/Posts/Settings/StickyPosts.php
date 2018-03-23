<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class StickyPosts extends AbstractSetting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $themeMod = $this->themeMod('sticky_posts');

        $this->id = $themeMod->id;

        $this->args['default'] = $themeMod->default;
        $this->args['sanitize_callback'] = 'absint';

        $this->control['label'] = \esc_html__('Show sticky posts?', 'jentil');
        $this->control['type'] = 'checkbox';
    }
}
