<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Colophon;

use GrottoPress\Jentil\Setups\Customizer\Customizer;
use GrottoPress\Jentil\Setups\Customizer\AbstractSection;
use WP_Customize_Manager as WPCustomizer;

final class Colophon extends AbstractSection
{
    public function __construct(Customizer $customizer)
    {
        parent::__construct($customizer);

        $this->id = 'colophon';

        $this->args['title'] = \esc_html__('Colophon', 'jentil');
    }

    public function add(WPCustomizer $wp_customizer)
    {
        $this->settings['Colophon'] = new Settings\Colophon($this);
        $this->controls['Colophon'] = new Controls\Colophon($this);

        parent::add($wp_customizer);
    }
}
