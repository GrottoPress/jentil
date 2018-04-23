<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use WP_Post_Type;

final class PostType extends AbstractSection
{
    /**
     * @var WP_Post_Type
     */
    protected $postType;

    public function __construct(Posts $posts, WP_Post_Type $post_type)
    {
        parent::__construct($posts);

        $this->postType = $post_type;

        $this->id = \sanitize_key("{$this->postType->name}_post_type_posts");

        $this->setArgs();
        $this->setThemeModArgs();
    }

    private function setArgs()
    {
        $this->args['title'] = \sprintf(
            \esc_html__('%s Archive', 'jentil'),
            $this->postType->labels->name
        );

        $this->args['active_callback'] = function (): bool {
            $page = $this->customizer->app->utilities->page;

            if ('post' === $this->postType->name) {
                return $page->is('home');
            }

            return $page->is('post_type_archive', $this->postType->name);
        };
    }

    private function setThemeModArgs()
    {
        $this->themeModArgs['specific'] = $this->postType->name;
        $this->themeModArgs['context'] = (
            'post' === $this->postType->name ? 'home' : 'post_type_archive'
        );
    }

    /**
     * @return Settings\AbstractSetting[string]
     */
    protected function settings(): array
    {
        $settings = parent::settings();

        if (!$this->customizer->app->utilities
            ->page->posts->sticky->get($this->postType->name)
        ) {
            unset($settings['StickyPosts']);
        }

        unset($settings['Heading']);

        return $settings;
    }
}
