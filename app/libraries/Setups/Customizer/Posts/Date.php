<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts;

final class Date extends AbstractSection
{
    public function __construct(Posts $posts)
    {
        parent::__construct($posts);

        $this->id = 'date_posts';

        $this->themeModArgs['context'] = 'date';

        $this->args['title'] = \esc_html__('Date Archives', 'jentil');
        $this->args['active_callback'] = function (): bool {
            return $this->customizer->app->utilities->page->is('date');
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
