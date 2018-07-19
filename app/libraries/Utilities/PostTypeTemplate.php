<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

class PostTypeTemplate
{
    /**
     * @var Utilities
     */
    private $utilities;

    public function __construct(Utilities $utilities)
    {
        $this->utilities = $utilities;
    }

    public function isPageBuilder(int $post_id = null): bool
    {
        $page_builder = [
            $this->utilities->app
                ->setups['PostTypeTemplates\PageBuilder']->slug,
            $this->utilities->app
                ->setups['PostTypeTemplates\PageBuilderBlank']->slug,
        ];

        if ($post_id) {
            return \in_array($this->slug($post_id), $page_builder);
        }

        return $this->is($page_builder);
    }

    public function slug(int $post_id = null): string
    {
        return (string)\get_page_template_slug($post_id);
    }

    /**
     * @param string[int] $type
     */
    public function is(array $type): bool
    {
        return $this->utilities->page->is('page_template', $type);
    }
}
