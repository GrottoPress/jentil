<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Getter\GetterTrait;

class ThemeMods
{
    use GetterTrait;

    /**
     * @var Utilities
     */
    private $utilities;

    /**
     * @var Colophon
     */
    private $colophon;

    public function __construct(Utilities $utilities)
    {
        $this->utilities = $utilities;
    }

    private function getUtilities(): Utilities
    {
        return $this->utilities;
    }

    private function getColophon(): Colophon
    {
        if (null === $this->colophon) {
            $this->colophon = new Colophon($this);
        }

        return $this->colophon;
    }

    /**
     * @param mixed[string] $args
     */
    public function layout(array $args = []): Layout
    {
        return new Layout($this, $args);
    }

    /**
     * @param mixed[string] $args
     */
    public function posts(string $setting, array $args = []): Posts
    {
        return new Posts($this, $setting, $args);
    }

    /**
     * @param mixed[string] $args
     */
    public function title(array $args = []): Title
    {
        return new Title($this, $args);
    }
}
