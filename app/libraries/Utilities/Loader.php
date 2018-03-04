<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

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
     * @see
     * https://developer.wordpress.org/reference/functions/get_template_part/
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
