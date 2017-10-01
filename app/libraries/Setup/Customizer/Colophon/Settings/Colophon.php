<?php

/**
 * Colophon Setting
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Colophon\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer\Colophon\Settings;

use GrottoPress\Jentil\Setup\Customizer\AbstractSetting;
use GrottoPress\Jentil\Setup\Customizer\Colophon\Colophon as Section;

/**
 * Colophon Setting
 *
 * @since 0.1.0
 */
final class Colophon extends AbstractSetting
{
    /**
     * Colophon section
     *
     * @since 0.1.0
     * @access private
     *
     * @var Colophon $colophon Colophon.
     */
    private $colophon;
    
    /**
     * Constructor
     *
     * @param Colophon $colophon Colophon section.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Section $colophon)
    {
        $this->colophon = $colophon;

        $mod = $this->colophon->customizer()->jentil()->utilities()
            ->mods()->colophon();

        $this->name = $mod->name();

        $this->args = [
            'default' => $mod->default(),
            'transport' => 'postMessage',
            'sanitize_callback' => function (string $value): string {
                return \wp_kses($value, 'pre_user_description');
            },
        ];
        
        $this->control = [
            'section' => $this->colophon->name(),
            'label' => \esc_html__('Colophon', 'jentil'),
            'type' => 'textarea',
        ];
    }
}
