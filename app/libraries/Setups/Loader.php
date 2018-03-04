<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

final class Loader extends AbstractSetup
{
    public function run()
    {
        $templates = $this->templates();

        foreach ($templates as $template) {
            \add_filter(
                "{$template}_template_hierarchy",
                [$this, 'loadTemplates']
            );
        }
    }

    /**
     * @filter {$type}_template_hierarchy
     */
    public function loadTemplates(array $templates): array
    {
        $j_templates = [];

        foreach ($templates as $template) {
            $templates_dir = $this->app->utilities->fileSystem->templatesDir(
                'path',
                "/{$template}",
                'relative'
            );

            $j_templates[] = $templates_dir;

            if (($rel_dir = $this->app->utilities->fileSystem->relativeDir())) {
                $j_templates[] = "{$rel_dir}/{$templates_dir}";
            }
        }

        return $j_templates;
    }

    /**
     * @return string[]
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
            'front_page',
            'page',
            'paged',
            'search',
            'single',
            'singular',
            'attachment',
        ];
    }
}
