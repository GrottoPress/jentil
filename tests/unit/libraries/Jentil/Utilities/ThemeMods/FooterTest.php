<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use GrottoPress\Jentil\Utilities\ThemeMods;
use GrottoPress\Jentil\Utilities;
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

        FunctionMocker::replace(
            ['sanitize_key', 'esc_html__'],
            function (string $key): string {
                return $key;
            }
        );

        $theme_mods = Stub::makeEmpty(ThemeMods::class);
        $theme_mods->utilities = Stub::makeEmpty(ThemeMods::class, [
            'app' => new class {
                function get()
                {
                    return new class {
                        function get(string $what): string
                        {
                            return $what;
                        }
                    };
                }
            }
        ]);

        $footer = new Footer($theme_mods, 'colophon');

        $this->assertSame('footer_colophon', $footer->id);
    }
}
