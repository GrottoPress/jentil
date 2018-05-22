<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Controls;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class PaginationMaximum extends AbstractControl
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $this->id = $section->settings['PaginationMaximum']->id;

        $this->args['label'] = \esc_html__('Maximum pagination', 'jentil');
        $this->args['type'] = 'number';
    }
}
