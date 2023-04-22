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
        foreach ($this->templates() as $template) {
            \add_filter(
                "{$template}_template_hierarchy",
                [$this, 'templateHierarchy']
            );
        }
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
            '404',
            'archive',
            'attachment',
            'author',
            'category',
            'date',
            'embed',
            'home',
            'index',
            'frontpage',
            'page',
            'paged',
            'privacypolicy',
            'search',
            'single',
            'singular',
            'tag',
            'taxonomy',
        ];
    }
}
