<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Controls;

use GrottoPress\Jentil\Setups\Customizer\Layout;

final class Date extends AbstractControl
{
    public function __construct(Layout $layout)
    {
        parent::__construct($layout);

        $this->id = $layout->settings['Date']->id;

        $this->args['label'] = \esc_html__('Date Archives', 'jentil');
        $this->args['active_callback'] = function (): bool {
            return $this->customizer->app->utilities->page->is('date');
        };
    }
}
