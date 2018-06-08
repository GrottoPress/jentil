<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use WP_Post_Type;

final class Sticky extends AbstractSection
{
    public function __construct(Posts $posts, WP_Post_Type $post_type)
    {
        parent::__construct($posts);

        $this->id = \sanitize_key("{$post_type->name}_sticky_posts");

        $this->setArgs($post_type);
        $this->setThemeModArgs($post_type);
    }

    private function setArgs(WP_Post_Type $post_type)
    {
        $this->args['title'] = \sprintf(
            \esc_html__('Sticky %s', 'jentil'),
            $post_type->labels->name
        );

        $this->args['active_callback'] = function () use ($post_type): bool {
            $page = $this->customizer->app->utilities->page;
            $has_sticky = $this->customizer->app->utilities
                ->page->posts->sticky->get($post_type->name);

            if ('post' === $post_type->name) {
                return ($page->is('home') && $has_sticky);
            }

            if (\post_type_exists($post_type->name)) {
                return ($page->is('post_type_archive') && $has_sticky);
            }

            return false;
        };
    }

    private function setThemeModArgs(WP_Post_Type $post_type)
    {
        $this->themeModArgs['context'] = 'sticky';
        $this->themeModArgs['specific'] = $post_type->name;
    }

    protected function setSettings()
    {
        parent::setSettings();

        unset(
            $this->settings['StickyPosts'],
            $this->controls['StickyPosts'],
            $this->settings['Number'],
            $this->controls['Number'],
            $this->settings['Pagination'],
            $this->controls['Pagination'],
            $this->settings['PaginationMaximum'],
            $this->controls['PaginationMaximum'],
            $this->settings['PaginationPosition'],
            $this->controls['PaginationPosition'],
            $this->settings['PaginationPreviousText'],
            $this->controls['PaginationPreviousText'],
            $this->settings['PaginationNextText'],
            $this->controls['PaginationNextText'],
            $this->settings['Heading'],
            $this->controls['Heading']
        );
    }
}
