<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use GrottoPress\Jentil\Utilities\ThemeMods;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class FooterTest extends AbstractTestCase
{
    public function testGetID()
    {
        FunctionMocker::replace(
            'apply_filters',
            function (string $name, $value) {
                return $value;
            }
        );

        FunctionMocker::replace('sanitize_key', function (string $key): string {
            return $key;
        });

        $footer = new Footer(Stub::makeEmpty(ThemeMods::class), 'colophon');

        $this->assertSame('footer_colophon', $footer->id);
    }
}
