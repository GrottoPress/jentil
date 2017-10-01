<?php

/**
 * Loader
 *
 * Loads templates/partials.
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
 * Loader
 *
 * @since 0.1.0
 */
final class Loader
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
     * Load partial
     *
     * @param string $slug Partial slug to load.
     * @param string $name Name to append to filename before loading.
     *
     * @since 0.1.0
     * @access public
     */
    public function loadPartial(string $slug, string $name = '')
    {
        \get_template_part(\ltrim($this->utilities->filesystem()->partialsDir(
            'path',
            "/{$slug}",
            'relative'
        ), '/'), $name);
    }

    /**
     * Load template
     *
     * @param string $slug Template slug.
     * @param string $name Name to append to filename before loading.
     *
     * @since 0.1.0
     * @access public
     */
    public function loadTemplate(string $slug, string $name = '')
    {
        \get_template_part(\ltrim($this->utilities->filesystem()->templatesDir(
            'path',
            "/{$slug}",
            'relative'
        ), '/'), $name);
    }

    /**
     * Load comments template
     *
     * @param bool $separated Whether or not to separate comments by type.
     *
     * @since 0.1.0
     * @access public
     */
    public function loadComments(bool $separated = false)
    {
        \comments_template($this->utilities->filesystem()->partialsDir(
            'path',
            '/comments.php',
            'relative'
        ), $separated);
    }
}
