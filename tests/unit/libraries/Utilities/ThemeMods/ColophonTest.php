<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;

class ColophonTest extends AbstractTestCase
{
    public function testGetName()
    {
        $colophon = new Colophon(Stub::makeEmpty(ThemeMods::class));

        $this->assertSame('colophon', $colophon->id);
    }
}
