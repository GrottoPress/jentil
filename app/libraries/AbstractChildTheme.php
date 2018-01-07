<?php

/**
 * Abstract Child Theme
 *
 * @package GrottoPress\Jentil
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil;

use GrottoPress\WordPress\SUV\AbstractApp;

/**
 * Abstract Child Theme
 *
 * @since 0.6.0
 */
abstract class AbstractChildTheme extends AbstractApp
{
    /**
     * Parent theme
     *
     * @since 0.6.0
     * @access protected
     *
     * @var Jentil
     */
    protected $parent;

    /**
     * Get parent theme
     *
     * @since 0.6.0
     * @access protected
     *
     * @return array
     */
    protected function getParent(): Jentil
    {
        return Jentil::getInstance();
    }
}
