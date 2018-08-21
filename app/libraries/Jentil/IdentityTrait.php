<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil;

use GrottoPress\Getter\GetterTrait;

trait IdentityTrait
{
    use GetterTrait;

    /**
     * @var string
     */
    protected $id;

    protected function getID(): string
    {
        return $this->id;
    }
}
