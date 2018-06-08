<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Controls;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

final class PaginationNextText extends AbstractControl
{
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $this->id = $section->settings['PaginationNextText']->id;

        $this->args['label'] = \esc_html__('Next page link text', 'jentil');
        $this->args['type'] = 'text';
    }
}
