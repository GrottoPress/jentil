<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use WP_Customize_Manager as WPCustomizer;
use WP_Post_Type;

final class PostType extends AbstractSection
{
    /**
     * @var WP_Post_Type
     */
    protected $post_type;

    public function __construct(Posts $posts, WP_Post_Type $post_type)
    {
        parent::__construct($posts);

        $this->post_type = $post_type;

        $this->id = \sanitize_key("{$this->post_type->name}_post_type_posts");

        $this->setArgs();
        $this->setModArgs();
    }

    public function add(WPCustomizer $WPCustomizer)
    {
        $this->settings = $this->settings();

        parent::add($WPCustomizer);
    }

    private function setArgs()
    {
        $this->args['title'] = \sprintf(
            \esc_html__('%s Archive', 'jentil'),
            $this->post_type->labels->name
        );

        $this->args['active_callback'] = function (): bool {
            $page = $this->customizer->app->utilities->page;

            if ('post' === $this->post_type->name) {
                return $page->is('home');
            }

            return $page->is('post_type_archive', $this->post_type->name);
        };
    }

    private function setModArgs()
    {
        $this->themeModArgs['specific'] = $this->post_type->name;
        $this->themeModArgs['context'] = (
            'post' === $this->post_type->name ? 'home' : 'post_type_archive'
        );
    }

    /**
     * @return Settings\AbstractSetting[]
     */
    protected function settings(): array
    {
        $settings = parent::settings();

        if (!$this->customizer->app->utilities
            ->page->posts->sticky->get($this->post_type->name)
        ) {
            unset($settings['StickyPosts']);
        }

        unset($settings['Heading']);

        return $settings;
    }
}
