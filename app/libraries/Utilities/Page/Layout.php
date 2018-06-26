<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page;

use GrottoPress\Jentil\Utilities\ThemeMods\Layout as LayoutMod;

class Layout
{
    /**
     * @var Page
     */
    private $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function themeMod(): LayoutMod
    {
        $page = $this->page->type;

        $specific = '';
        $more_specific = 0;

        foreach ($page as $type) {
            if ('post_type_archive' === $type) {
                $specific = \get_query_var('post_type');
            } elseif ('tax' === $type) {
                $specific = \get_query_var('taxonomy');
            } elseif ('category' === $type) {
                $specific = 'category';
            } elseif ('tag' === $type) {
                $specific = 'post_tag';
            } elseif ('singular' === $type) {
                $specific = ($post = \get_post())->post_type;

                if ($this->isPagelike($post->post_type, $post->ID)) {
                    $more_specific = $post->ID;
                }
            }

            if (\is_array($specific)) {
                $specific = $specific[0];
            }

            if (\is_array($more_specific)) {
                $more_specific = $more_specific[0];
            }

            $mod = $this->page->utilities->themeMods->layout([
                'context' => $type,
                'specific' => $specific,
                'more_specific' => $more_specific
            ]);

            if ($mod->id) {
                return $mod;
            }
        }

        return $mod;
    }

    public function column(): string
    {
        foreach ($this->page->layouts->get() as $column_slug => $layouts) {
            foreach ($layouts as $layout_id => $layout_name) {
                if ($this->themeMod()->get() === $layout_id) {
                    return \sanitize_title($column_slug);
                }
            }
        }

        return '';
    }

    public function isPagelike(string $post_type = '', int $post_id = 0): bool
    {
        $check = (
            \is_post_type_hierarchical($post_type) &&
            !\get_post_type_archive_link($post_type)
        );

        if ($check && $post_id && ('page' === \get_option('show_on_front'))) {
            return ($post_id !== (int)\get_option('page_for_posts'));
        }

        return $check;
    }
}
