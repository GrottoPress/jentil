<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use WP_Taxonomy;
use WP_Term;

final class Taxonomy extends AbstractSection
{
    public function __construct(
        Posts $posts,
        WP_Taxonomy $taxonomy,
        WP_Term $term = null
    ) {
        parent::__construct($posts);

        $this->setName($taxonomy, $term);
        $this->setModArgs($taxonomy, $term);
        $this->setArgs($taxonomy, $term);
    }

    private function setName(WP_Taxonomy $taxonomy, WP_Term $term = null)
    {
        if ($term) {
            $this->id = \sanitize_key(
                "{$taxonomy->name}_{$term->term_id}_taxonomy_posts"
            );
        } else {
            $this->id = \sanitize_key("{$taxonomy->name}_taxonomy_posts");
        }
    }

    private function setModArgs(WP_Taxonomy $taxonomy, WP_Term $term = null)
    {
        $this->themeModArgs['context'] = 'tax';

        if ('post_tag' === $taxonomy->name) {
            $this->themeModArgs['context'] = 'tag';
        } elseif ('category' === $taxonomy->name) {
            $this->themeModArgs['context'] = 'category';
        }

        $this->themeModArgs['specific'] = $taxonomy->name;
        $this->themeModArgs['more_specific'] = ($term ? $term->term_id : 0);
    }

    private function setArgs(WP_Taxonomy $taxonomy, WP_Term $term = null)
    {
        $this->args['active_callback'] = function () use (
            $taxonomy,
            $term
        ): bool {
            $page = $this->customizer->app->utilities->page;

            if ($term) {
                return (
                    $page->is('tag', $term->term_id) ||
                    $page->is('category', $term->term_id) ||
                    $page->is('tax', $taxonomy->name, $term->term_id)
                );
            }

            if ('post_tag' === $taxonomy->name) {
                return $page->is('tag');
            }

            if ('category' === $taxonomy->name) {
                return $page->is('category');
            }

            return $page->is('tax', $taxonomy->name);
        };

        if ($term) {
            $this->args['title'] = \sprintf(\esc_html__(
                '%1$s Archive: %2$s',
                'jentil'
            ), $taxonomy->labels->singular_name, $term->name);
        } else {
            $this->args['title'] = \sprintf(\esc_html__(
                '%s Archives',
                'jentil'
            ), $taxonomy->labels->singular_name);
        }
    }

    protected function settings(): array
    {
        $settings = parent::settings();

        unset($settings['StickyPosts'], $settings['Heading']);

        return $settings;
    }
}
