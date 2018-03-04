<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use GrottoPress\Jentil\Utilities\ThemeMods\Colophon as ColophonMod;

class Colophon
{
    /**
     * @var Utilities
     */
    private $utilities;

    public function __construct(Utilities $utilities)
    {
        $this->utilities = $utilities;
    }

    public function themeMod(): ColophonMod
    {
        return $this->utilities->themeMods->colophon;
    }
}
