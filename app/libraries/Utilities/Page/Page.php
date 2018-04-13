<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page;

use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\WordPress\Page\Page as PagePackage;
use GrottoPress\Getter\GetterTrait;

class Page extends PagePackage
{
    use GetterTrait;

    /**
     * @var Utilities
     */
    private $utilities;

    /**
     * @var Layout
     */
    private $layout = null;

    /**
     * @var Layouts
     */
    private $layouts = null;

    /**
     * @var string
     */
    private $title = null;

    /**
     * @var Posts
     */
    private $posts = null;

    /**
     * @var string[]
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

    private function getTitle(): Title
    {
        if (null === $this->title) {
            $this->title = new Title($this);
        }

        return $this->title;
    }

    private function getLayout(): Layout
    {
        if (null === $this->layout) {
            $this->layout = new Layout($this);
        }

        return $this->layout;
    }

    private function getLayouts(): Layouts
    {
        if (null === $this->layouts) {
            $this->layouts = new Layouts($this);
        }

        return $this->layouts;
    }

    private function getPosts(): Posts\Posts
    {
        if (null === $this->posts) {
            $this->posts = new Posts\Posts($this);
        }

        return $this->posts;
    }

    /**
     * Page type is used too many times on archives
     * for getting posts mods, so let's make sure method
     * is called only once per page cycle, except, of course,
     * in the customizer.
     *
     * @return string[]
     */
    private function getType(): array
    {
        if (null === $this->type || $this->is('customize_preview')) {
            $this->type = parent::type();
        }

        return $this->type;
    }
}
