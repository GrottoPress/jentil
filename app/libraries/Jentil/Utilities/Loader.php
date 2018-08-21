<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use GrottoPress\Jentil\Utilities;

class Loader
{
    /**
     * @var Utilities
     */
    private $utilities;

    public function __construct(Utilities $utilities)
    {
        $this->utilities = $utilities;
    }

    public function loadPartial(string $slug, string $name = '')
    {
        return $this->load('partial', $slug, $name);
    }

    public function loadTemplate(string $slug, string $name = '')
    {
        return $this->load('template', $slug, $name);
    }

    public function loadComments(string $file = '', bool $separated = false)
    {
        $file = $this->utilities->fileSystem->partialsDir(
            'path',
            '/'.(\ltrim($file, '/') ?: 'comments.php'),
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
     * This mimics WordPress' `\get_template_part()` function.
     *
     * @see
     * https://developer.wordpress.org/reference/functions/get_template_part/
     *
     * @param string $type 'template' or 'partial'
     */
    private function load(string $type, string $slug, string $name = ''): string
    {
        $slug = \ltrim($slug, '/');
        $slug = \rtrim($slug, '.php');

        $this->doAction($type, $slug, $name);

        $slug = $this->rewriteSlug($type, $slug);
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

    private function doAction(string $type, string $slug, string $name = '')
    {
        if ('partial' === $type) {
            if (\in_array($slug, ['header', 'footer', 'sidebar'])) {
                \do_action("get_{$slug}", $name);
            } else {
                \do_action("get_template_part_{$slug}", $slug, $name);
            }
        }
    }

    private function rewriteSlug(string $type, string $slug): string
    {
        if ('partial' === $type) {
            return $this->utilities->fileSystem->partialsDir(
                'path',
                "/{$slug}",
                'relative'
            );
        }

        return $this->utilities->fileSystem->templatesDir(
            'path',
            "/{$slug}",
            'relative'
        );
    }
}
