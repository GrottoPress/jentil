<?php

/**
 * Template Loader
 *
 * We're using this to load templates from the 'app/templates'
 * directory, instead of from the theme directory.
 *
 * @see https://developer.wordpress.org/reference/functions/get_query_template/
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup;

/**
 * Template Loader
 *
 * @since 0.1.0
 */
class Loader extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        $types = [
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

        foreach ($types as $type) {
            \add_filter("{$type}_template_hierarchy", [$this, 'load']);
        }
    }

    /**
     * Load templates
     *
     * @since 0.1.0
     * @access public
     *
     * @filter {$type}_template_hierarchy
     */
    public function load(array $templates): array
    {
        $j_templates = [];

        foreach ($templates as $template) {
            $j_templates[] = \ltrim(
                $this->theme->utilities->fileSystem->templatesDir(
                    'path',
                    '/'.$template,
                    'relative'
                ),
                '/'
            );
        }

        return $j_templates;
    }
}
