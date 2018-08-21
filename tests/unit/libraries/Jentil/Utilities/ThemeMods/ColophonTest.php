<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use GrottoPress\Jentil\Utilities\ThemeMods;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class ColophonTest extends AbstractTestCase
{
    public function testGetID()
    {
        FunctionMocker::replace(
            'apply_filters',
            function (string $name, $value) {
                return $value;
            }
        );

        $colophon = new Colophon(Stub::makeEmpty(ThemeMods::class));

        $this->assertSame('colophon', $colophon->id);
    }
}
