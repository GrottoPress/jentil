<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

final class Loader extends AbstractSetup
{
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'loadTemplates']);
    }

    /**
     * @action after_setup_theme
     */
    public function loadTemplates()
    {
        $templates = $this->templates();

        \array_walk($templates, function (string $template, int $i) {
            \add_filter(
                "{$template}_template_hierarchy",
                [$this, 'templateHierarchy']
            );
        });
    }

    /**
     * @filter {$template}_template_hierarchy
     * @param string[int] $templates
     * @return string[int]
     */
    public function templateHierarchy(array $templates): array
    {
        $return = [];

        foreach ($templates as $template) {
            $new_template = $this->app->utilities->fileSystem->templatesDir(
                'path',
                "/{$template}",
                'relative'
            );

            $return[] = $new_template;

            if ($rel_dir = $this->app->utilities->fileSystem->relativeDir()) {
                $return[] = "{$rel_dir}/{$new_template}";
            }
        }

        return $return;
    }

    /**
     * @return string[int]
     */
    private function templates(): array
    {
        return [
            'index',
            '404',
            'archive',
            'author',
            'category',
            'tag',
            'taxonomy',
            'date',
            'embed',
            'home',
            'frontpage',
            'page',
            'paged',
            'search',
            'single',
            'singular',
            'attachment',
        ];
    }
}
