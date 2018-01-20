<?php

/**
 * Custom Template
 *
 * @package GrottoPress\Jentil\Utilities
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

/**
 * Custom Template
 *
 * @since 0.6.0
 */
final class CustomTemplate
{
    /**
     * Utilities
     *
     * @since 0.6.0
     * @access private
     *
     * @var Utilities
     */
    private $utilities;

    /**
     * Constructor
     *
     * @param Utilities $utilities
     *
     * @since 0.6.0
     * @access public
     */
    public function __construct(Utilities $utilities)
    {
        $this->utilities = $utilities;
    }

    /**
     * Are we on a page builder page?
     *
     * @since 0.6.0
     * @access public
     *
     * @return bool
     */
    public function isPageBuilder(): bool
    {
        return $this->is(['page-builder.php', 'page-builder-blank.php']);
    }

    /**
     * Are we on a given page template?
     *
     * @param array $type
     *
     * @since 0.6.0
     * @access public
     *
     * @return bool
     */
    public function is(array $type): bool
    {
        return $this->utilities->page->is('page_template', $type);
    }
}
