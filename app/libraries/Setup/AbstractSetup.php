<?php

/**
 * Setup
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup;

use GrottoPress\Jentil\Theme;
use GrottoPress\Getter\Getter;

/**
 * Setup
 *
 * @since 0.1.0
 */
abstract class AbstractSetup
{
    use Getter;
    
    /**
     * Theme
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Theme $theme Theme.
     */
    protected $theme;

    /**
     * Constructor
     *
     * @param Theme $theme Theme.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * Theme
     *
     * @since 0.1.0
     * @access protected
     *
     * @return Theme Theme.
     */
    final protected function getTheme(): Theme
    {
        return $this->theme;
    }

    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    abstract public function run();
}
