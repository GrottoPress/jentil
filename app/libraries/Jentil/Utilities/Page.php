<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use GrottoPress\Jentil\Utilities;
use GrottoPress\WordPress\Page as PagePackage;
use GrottoPress\Getter\GetterTrait;

class Page extends PagePackage
{
    use GetterTrait;

    /**
     * @var Utilities
     */
    private $utilities;

    /**
     * @var Page\Layout
     */
    private $layout;

    /**
     * @var Page\Layouts
     */
    private $layouts;

    /**
     * @var Page\Title
     */
    private $title;

    /**
     * @var Page\Posts
     */
    private $posts;

    /**
     * @var string[int]
     */
    private $type;

    public function __construct(Utilities $utilities)
    {
        $this->utilities = $utilities;
    }

    private function getUtilities(): Utilities
    {
        return $this->utilities;
    }

    private function getTitle(): Page\Title
    {
        return $this->title = $this->title ?: new Page\Title($this);
    }

    private function getLayout(): Page\Layout
    {
        return $this->layout = $this->layout ?: new Page\Layout($this);
    }

    private function getLayouts(): Page\Layouts
    {
        return $this->layouts = $this->layouts ?: new Page\Layouts($this);
    }

    private function getPosts(): Page\Posts
    {
        return $this->posts = $this->posts ?: new Page\Posts($this);
    }

    /**
     * Page type is used too many times on archives
     * for getting posts mods, so let's make sure method
     * is called only once per page cycle, except, of course,
     * in the customizer.
     *
     * @return string[int]
     */
    private function getType(): array
    {
        if (!$this->type || $this->is('customize_preview')) {
            $this->type = parent::type();
        }

        return $this->type;
    }
}
