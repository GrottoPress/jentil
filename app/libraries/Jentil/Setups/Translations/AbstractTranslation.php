<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Translations;

use GrottoPress\Jentil\Setups\AbstractSetup;
use GrottoPress\Getter\GetterTrait;

abstract class AbstractTranslation extends AbstractSetup
{
    use GetterTrait;

    /**
     * @var string
     */
    protected $textDomain;

    protected function getTextDomain(): string
    {
        return $this->textDomain;
    }
}
