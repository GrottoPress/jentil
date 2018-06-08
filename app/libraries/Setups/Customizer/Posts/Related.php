<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use WP_Post_Type;

final class Related extends AbstractSection
{
    public function __construct(Posts $posts, WP_Post_Type $post_type)
    {
        parent::__construct($posts);

        $this->id = \sanitize_key("{$post_type->name}_related_posts");

        $this->setArgs($post_type);
        $this->setThemeModArgs($post_type);
    }

    private function setArgs(WP_Post_Type $post_type)
    {
        $this->args['title'] = \sprintf(
            \esc_html__('Related %s', 'jentil'),
            $post_type->labels->name
        );

        $this->args['active_callback'] = function () use ($post_type): bool {
            $utilities = $this->customizer->app->utilities;

            if ($utilities->postTypeTemplate->isPageBuilder() ||
                !\post_type_exists($post_type->name)
            ) {
                return false;
            }

            return $this->customizer->app->utilities->page->is(
                'singular',
                $post_type->name
            );
        };
    }

    private function setThemeModArgs(WP_Post_Type $post_type)
    {
        $this->themeModArgs['context'] = 'related';
        $this->themeModArgs['specific'] = $post_type->name;
    }

    protected function setSettings()
    {
        parent::setSettings();

        unset(
            $this->settings['StickyPosts'],
            $this->controls['StickyPosts'],
            $this->settings['Pagination'],
            $this->controls['Pagination'],
            $this->settings['PaginationMaximum'],
            $this->controls['PaginationMaximum'],
            $this->settings['PaginationPosition'],
            $this->controls['PaginationPosition'],
            $this->settings['PaginationPreviousText'],
            $this->controls['PaginationPreviousText'],
            $this->settings['PaginationNextText'],
            $this->controls['PaginationNextText']
        );
    }
}
