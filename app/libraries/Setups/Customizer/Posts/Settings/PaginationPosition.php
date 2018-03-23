<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class PaginationPosition extends AbstractSetting
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $themeMod = $this->themeMod('pagination_position');

        $this->id = $themeMod->id;

        $this->args['default'] = $themeMod->default;
        $this->args['sanitize_callback'] = 'sanitize_text_field';

        $this->control['label'] = \esc_html__('Pagination position', 'jentil');
        $this->control['type'] = 'select';
        $this->control['choices'] = [
            'none' => \esc_html__('None', 'jentil'),
            'top' => \esc_html__('Top', 'jentil'),
            'bottom' => \esc_html__('Bottom', 'jentil'),
            'top,bottom' => \esc_html__('Top and bottom', 'jentil'),
        ];
    }
}
