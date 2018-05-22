<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Title\Controls;

use GrottoPress\Jentil\Setups\Customizer\Title\Title;

final class Date extends AbstractControl
{
    public function __construct(Title $title)
    {
        parent::__construct($title);

        $this->id = $title->settings['Date']->id;

        $this->args['label'] = \esc_html__('Date Archives', 'jentil');
        $this->args['active_callback'] = function (): bool {
            return $this->customizer->app->utilities->page->is('date');
        };
    }
}
