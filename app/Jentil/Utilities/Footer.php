<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\Utilities\ThemeMods\Footer as FooterMod;

class Footer
{
    /**
     * @var Utilities
     */
    private $utilities;

    public function __construct(Utilities $utilities)
    {
        $this->utilities = $utilities;
    }

    public function themeMod(string $setting): FooterMod
    {
        return $this->utilities->themeMods->footer($setting);
    }
}
