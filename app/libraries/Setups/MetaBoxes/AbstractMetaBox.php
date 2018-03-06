<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\MetaBoxes;

use GrottoPress\Jentil\Setups\AbstractSetup;
use GrottoPress\Jentil\IdentityTrait;

abstract class AbstractMetaBox extends AbstractSetup
{
    use IdentityTrait;

    /**
     * @var string 'normal', 'side', or 'advanced'.
     */
    protected $context;

    protected function getContext(): string
    {
        return $this->context;
    }
}
