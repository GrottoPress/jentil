<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use GrottoPress\Jentil\Utilities;
use GrottoPress\Getter\GetterTrait;

class ThemeMods
{
    use GetterTrait;

    /**
     * @var Utilities
     */
    private $utilities;

    /**
     * @var ThemeMods\Colophon
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

    private function getColophon(): ThemeMods\Colophon
    {
        if (null === $this->colophon) {
            $this->colophon = new ThemeMods\Colophon($this);
        }

        return $this->colophon;
    }

    /**
     * @param mixed[string] $args
     */
    public function layout(array $args = []): ThemeMods\Layout
    {
        return new ThemeMods\Layout($this, $args);
    }

    /**
     * @param mixed[string] $args
     */
    public function posts(string $setting, array $args = []): ThemeMods\Posts
    {
        return new ThemeMods\Posts($this, $setting, $args);
    }

    /**
     * @param mixed[string] $args
     */
    public function title(array $args = []): ThemeMods\Title
    {
        return new ThemeMods\Title($this, $args);
    }
}
