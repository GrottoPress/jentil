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
     * Is page a page builder page?
     *
     * @param int $post_id
     *
     * @since 0.6.0
     * @access public
     *
     * @return bool
     */
    public function isPageBuilder(int $post_id = null): bool
    {
        if ($post_id) {
            return \in_array(
                $this->slug($post_id),
                ['page-builder.php', 'page-builder-blank.php']
            );
        }

        return $this->is(['page-builder.php', 'page-builder-blank.php']);
    }

    /**
     * Get page template slug
     *
     * @param int $post_id
     *
     * @since 0.6.0
     * @access public
     *
     * @return string
     */
    public function slug(int $post_id = null): string
    {
        return (string)\get_page_template_slug($post_id);
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
