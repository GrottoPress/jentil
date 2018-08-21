<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use GrottoPress\Jentil\Utilities;
use BadMethodCallException;

/**
 * @method bool isPageBuilder(int $post_id)
 * @method bool isPageBuilderBlank(int $post_id)
 */
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

    /**
     * @param mixed[int] $args
     */
    public function __call(string $name, array $args)
    {
        $template = $this->utilities->app->setups['PostTypeTemplates\\'.
            \substr($name, 2)]->slug ?? '';

        if ($template && (0 === \strpos($name, 'is'))) {
            if (!empty($args[0])) {
                return \in_array($this->slug($args[0]), [$template]);
            }

            return $this->is([$template]);
        }

        throw new BadMethodCallException("Method `{$name}` does not exist!");
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
