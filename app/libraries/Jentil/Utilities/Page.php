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
    private $layout = null;

    /**
     * @var Page\Layouts
     */
    private $layouts = null;

    /**
     * @var Page\Title
     */
    private $title = null;

    /**
     * @var Page\Posts
     */
    private $posts = null;

    /**
     * @var string[int]
     */
    private $type = null;

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
        if (null === $this->title) {
            $this->title = new Page\Title($this);
        }

        return $this->title;
    }

    private function getLayout(): Page\Layout
    {
        if (null === $this->layout) {
            $this->layout = new Page\Layout($this);
        }

        return $this->layout;
    }

    private function getLayouts(): Page\Layouts
    {
        if (null === $this->layouts) {
            $this->layouts = new Page\Layouts($this);
        }

        return $this->layouts;
    }

    private function getPosts(): Page\Posts
    {
        if (null === $this->posts) {
            $this->posts = new Page\Posts($this);
        }

        return $this->posts;
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
        if (null === $this->type || $this->is('customize_preview')) {
            $this->type = parent::type();
        }

        return $this->type;
    }
}
