<?php

/**
 * Theme ThemeMods
 *
 * @package GrottoPress\Jentil\Utilities\ThemeMods
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Getter\GetterTrait;

/**
 * Theme ThemeMods
 *
 * @since 0.1.0
 */
class ThemeMods
{
    use GetterTrait;
    
    /**
     * Utilities
     *
     * @since 0.1.0
     * @access private
     *
     * @var Utilities
     */
    private $utilities;

    /**
     * Colophon
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
     * @param Utilities $utilities
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Utilities $utilities)
    {
        $this->utilities = $utilities;
    }

    /**
     * Get utilities
     *
     * @since 0.1.0
     * @access private
     *
     * @return Utilities Utilities.
     */
    private function getUtilities(): Utilities
    {
        return $this->utilities;
    }

    /**
     * Get colophon
     *
     * @since 0.1.0
     * @access private
     *
     * @return Colophon
     */
    private function getColophon(): Colophon
    {
        if (null === $this->colophon) {
            $this->colophon = new Colophon($this);
        }

        return $this->colophon;
    }

    /**
     * Layout Mod
     *
     * @param array $args Mod args.
     *
     * @since 0.1.0
     * @access public
     *
     * @return Layout
     */
    public function layout(array $args = []): Layout
    {
        return new Layout($this, $args);
    }

    /**
     * Posts Mod
     *
     * @param string $setting Setting to retrieve.
     * @param array $args Mod args.
     *
     * @since 0.1.0
     * @access public
     *
     * @return Posts Posts mod.
     */
    public function posts(string $setting, array $args = []): Posts
    {
        return new Posts($this, $setting, $args);
    }

    /**
     * Title Mod
     *
     * @param array $args Mod args.
     *
     * @since 0.1.0
     * @access public
     *
     * @return Title Title mod.
     */
    public function title(array $args = []): Title
    {
        return new Title($this, $args);
    }
}
