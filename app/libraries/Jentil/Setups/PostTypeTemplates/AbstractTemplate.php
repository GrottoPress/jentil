<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\PostTypeTemplates;

use GrottoPress\Jentil\Setups\AbstractSetup;

abstract class AbstractTemplate extends AbstractSetup
{
    /**
     * @var string
     */
    protected $slug;

    protected function getSlug(): string
    {
        return $this->slug;
    }
}
