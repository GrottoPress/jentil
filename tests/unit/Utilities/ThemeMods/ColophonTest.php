<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Utilities\ThemeMods;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Utilities\ThemeMods\ThemeMods;
use GrottoPress\Jentil\Utilities\ThemeMods\Colophon;

class ColophonTest extends TestCase
{
    public function testGetName()
    {
        $colophon = new Colophon(Stub::makeEmpty(ThemeMods::class));

        $this->assertSame('colophon', $colophon->name);
    }
}
