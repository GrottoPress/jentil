<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Controls;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class PaginationPosition extends AbstractControl
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $this->id = $section->settings['PaginationPosition']->id;

        $this->args['label'] = \esc_html__('Pagination position', 'jentil');
        $this->args['type'] = 'select';
        $this->args['choices'] = [
            'none' => \esc_html__('None', 'jentil'),
            'top' => \esc_html__('Top', 'jentil'),
            'bottom' => \esc_html__('Bottom', 'jentil'),
            'top,bottom' => \esc_html__('Top and bottom', 'jentil'),
        ];
    }
}
