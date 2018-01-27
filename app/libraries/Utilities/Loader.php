<?php

/**
 * Loader: Loads templates/partials.
 *
 * The goal here is to include this theme's subdirectories
 * with the paths we search when looking for a template or partial.
 * This is particularly critical for when this
 * theme is used as a package (eg, via composer) rather than as a theme.
 *
 * @package GrottoPress\Jentil\Utilities
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

/**
 * Loader
 *
 * @since 0.1.0
 */
class Loader
{
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
     * Load partial
     *
     * @param string $slug Partial slug to load.
     * @param string $name Name to append to filename before loading.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string
     */
    public function loadPartial(string $slug, string $name = '')
    {
        return $this->load('partial', $slug, $name);
    }

    /**
     * Load template
     *
     * @param string $slug Template slug.
     * @param string $name Name to append to filename before loading.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string
     */
    public function loadTemplate(string $slug, string $name = '')
    {
        return $this->load('template', $slug, $name);
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
        $file = $this->utilities->fileSystem->partialsDir(
            'path',
            "/comments.php",
            'relative'
        );
        
        if (!\is_readable(\get_stylesheet_directory()."/{$file}") &&
            !\is_readable(\get_template_directory()."/{$file}") &&
            ($rel_dir = $this->utilities->fileSystem->relativeDir())
        ) {
            return \comments_template("/{$rel_dir}/{$file}", $separated);
        }
    
        return \comments_template("/{$file}", $separated);
    }
    
    /**
     * Helper to load partial or template
     *
     * This mimics, and uses code from, WordPress'
     * `\get_template_part()` function.
     *
     * @param string $type 'template' or 'partial'
     * @param string $slug
     * @param string $name
     *
     * @see https://developer.wordpress.org/reference/functions/get_template_part/
     *
     * @return string Located template path.
     */
    private function load(string $type, string $slug, string $name = ''): string
    {
        if ('partial' === $type) {
            $slug = $this->utilities->fileSystem->partialsDir(
                'path',
                "/{$slug}",
                'relative'
            );
        } else {
            $slug = $this->utilities->fileSystem->templatesDir(
                'path',
                "/{$slug}",
                'relative'
            );
        }

        $rel_dir = $this->utilities->fileSystem->relativeDir();
    
        $templates = [];

        if ($name) {
            $templates[] = "{$slug}-{$name}.php";

            if ($rel_dir) {
                $templates[] = "{$rel_dir}/{$slug}-{$name}.php";
            }
        }
    
        $templates[] = "{$slug}.php";

        if ($rel_dir) {
            $templates[] = "{$rel_dir}/{$slug}.php";
        }
    
        return \locate_template($templates, true, false);
    }
}
