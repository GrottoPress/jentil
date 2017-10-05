<?php

/**
 * Setting
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Title\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer\Title\Settings;

use GrottoPress\Jentil\Setup\Customizer\Title\Title;
use GrottoPress\Jentil\Setup\Customizer\AbstractSetting as Setting;

/**
 * Setting
 *
 * @since 0.1.0
 */
abstract class AbstractSetting extends Setting
{
    /**
     * Title section
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Title $title Title section.
     */
    protected $title;

    /**
     * Mod
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Title $mod Mod.
     */
    protected $mod;

    /**
     * Constructor
     *
     * @param Title $title Title section.
     *
     * @since 0.1.0
     * @access protected
     */
    protected function __construct(Title $title)
    {
        $this->title = $title;

        // $this->args['transport'] = 'postMessage';
        $this->arg['sanitize_callback'] = 'wp_kses_data';

        $this->control['section'] = $this->title->name();
        $this->control['label'] = \esc_html__('Enter title', 'jentil');
        $this->control['type'] = 'text';
    }
}