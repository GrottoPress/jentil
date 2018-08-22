<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer;

use GrottoPress\Jentil\Setups\Customizer;
use GrottoPress\Jentil\Setups\Customizer\AbstractSection;
use WP_Customize_Manager as WPCustomizer;

final class Footer extends AbstractSection
{
    public function __construct(Customizer $customizer)
    {
        parent::__construct($customizer);

        $this->id = 'footer';

        $this->args['title'] = \esc_html__('Footer', 'jentil');
    }

    public function add(WPCustomizer $wp_customizer)
    {
        $this->settings['Colophon'] = new Footer\Settings\Colophon($this);
        $this->controls['Colophon'] = new Footer\Controls\Colophon($this);

        parent::add($wp_customizer);
    }
}
