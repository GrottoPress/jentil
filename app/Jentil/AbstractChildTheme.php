<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil;

use GrottoPress\Jentil;
use GrottoPress\WordPress\SUV\AbstractChildTheme as ChildTheme;
use GrottoPress\WordPress\SUV\AbstractTheme;

abstract class AbstractChildTheme extends ChildTheme
{
    final protected function getParent(): AbstractTheme
    {
        return Jentil::getInstance();
    }

    public function run()
    {
        if ($this->getParent()->is('package')) {
            $this->getParent()->run();
        }

        parent::run();
    }
}
