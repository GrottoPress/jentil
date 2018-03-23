<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use WP_Customize_Manager as WPCustomizer;
use WP_Post_Type;

final class Related extends AbstractSection
{
    public function __construct(Posts $posts, WP_Post_Type $post_type)
    {
        parent::__construct($posts);

        $this->id = \sanitize_key("{$post_type->name}_related_posts");

        $this->setArgs($post_type);
        $this->setModArgs($post_type);
    }

    public function add(WPCustomizer $WPCustomizer)
    {
        $this->settings = $this->settings();

        parent::add($WPCustomizer);
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

    private function setModArgs(WP_Post_Type $post_type)
    {
        $this->themeModArgs['context'] = 'related';
        $this->themeModArgs['specific'] = $post_type->name;
    }

    /**
     * @return Settings\AbstractSetting[]
     */
    protected function settings(): array
    {
        $settings = parent::settings();

        unset(
            $settings['StickyPosts'],
            $settings['Pagination'],
            $settings['PaginationMaximum'],
            $settings['PaginationPosition'],
            $settings['PaginationPreviousText'],
            $settings['PaginationNextText']
        );

        return $settings;
    }
}
