<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use GrottoPress\Jentil\Setups\Customizer\Posts;

final class Author extends AbstractSection
{
    public function __construct(Posts $posts)
    {
        parent::__construct($posts);

        $this->id = 'author_posts';

        $this->themeModArgs['context'] = 'author';

        $this->args['title'] = \esc_html__('Author Archives', 'jentil');
        $this->args['active_callback'] = function (): bool {
            return $this->customizer->app->utilities->page->is('author');
        };
    }

    protected function setSettings()
    {
        parent::setSettings();

        unset(
            $this->settings['StickyPosts'],
            $this->controls['StickyPosts'],
            $this->settings['Heading'],
            $this->controls['Heading']
        );
    }
}
