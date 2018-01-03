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

/**
 * Abstract Child Theme
 *
 * @since 0.6.0
 */
abstract class AbstractChildTheme extends AbstractTheme
{
    /**
     * Parent theme
     *
     * @since 0.6.0
     * @access protected
     *
     * @var Jentil $parent Parent Theme.
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
