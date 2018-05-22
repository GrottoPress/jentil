<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Controls;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class PaginationPreviousText extends AbstractControl
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $this->id = $section->settings['PaginationPreviousText']->id;

        $this->args['label'] = \esc_html__('Previous page link text', 'jentil');
        $this->args['type'] = 'text';
    }
}
