<?php

/**
 * Abstract Child Theme
 *
 * @package GrottoPress\Jentil
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil;

use GrottoPress\WordPress\SUV\AbstractChildTheme as ChildTheme;
use GrottoPress\WordPress\SUV\AbstractTheme;

/**
 * Abstract Child Theme
 *
 * @since 0.6.0
 */
abstract class AbstractChildTheme extends ChildTheme
{
    /**
     * Get parent theme
     *
     * @since 0.6.0
     * @access protected
     *
     * @return array
     */
    protected function getParent(): AbstractTheme
    {
        return Jentil::getInstance();
    }
}
