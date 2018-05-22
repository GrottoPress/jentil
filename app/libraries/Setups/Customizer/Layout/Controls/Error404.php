<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Controls;

use GrottoPress\Jentil\Setups\Customizer\Layout\Layout;

final class Error404 extends AbstractControl
{
    public function __construct(Layout $layout)
    {
        parent::__construct($layout);

        $this->id = $layout->settings['Error404']->id;

        $this->args['label'] = \esc_html__('Error 404', 'jentil');
        $this->args['active_callback'] = function (): bool {
            return $this->customizer->app->utilities->page->is('404');
        };
    }
}
