<?php

/**
 * Colophon
 *
 * @package GrottoPress\Jentil\Utilities
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

/**
 * Colophon
 *
 * @since 0.1.0
 */
final class Colophon
{
    /**
     * Utilities
     *
     * @since 0.1.0
     * @access private
     *
     * @var Utilities $utilities Utilities.
     */
    private $utilities;

    /**
     * Constructor
     *
     * @param Utilities $utilities Utilities.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Utilities $utilities)
    {
        $this->utilities = $utilities;
    }

    /**
     * Get colophon mod
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Colophon mod.
     */
    public function mod(): string
    {
        return $this->utilities->shortTags->replace(
            $this->utilities->mods->colophon->get()
        );
    }
}
