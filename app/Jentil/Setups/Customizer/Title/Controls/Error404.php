<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Title\Controls;

use GrottoPress\Jentil\Setups\Customizer\Title;

final class Error404 extends AbstractControl
{
    public function __construct(Title $title)
    {
        parent::__construct($title);

        $this->id = $title->settings['Error404']->id;

        $this->args['label'] = \esc_html__('Error 404', 'jentil');
        $this->args['active_callback'] = function (): bool {
            return $this->customizer->app->utilities->page->is('404');
        };
    }
}
