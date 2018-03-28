<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\Utilities\ThemeMods\Layout as LayoutMod;
use tad\FunctionMocker\FunctionMocker;

class LayoutTest extends AbstractTestCase
{
    /**
     * @dataProvider columnProvider
     */
    public function testColumn(string $theme_mod, string $expected)
    {
        FunctionMocker::replace('sanitize_title', function (
            string $text
        ): string {
            return $text;
        });

        $page = Stub::makeEmpty(Page::class);
        $page->layouts = Stub::makeEmpty(Layouts::class, [
            'get' => [
                'l-3-c' => [
                    'c-s-s' => 'CSS',
                    's-s-c' => 'SSC',
                    's-c-s' => 'SCS',
                ],
                'l-2-c' => ['c-s' => 'CS', 's-c' => 'SC'],
                'l-1-c' => ['c' => 'C'],
            ],
        ]);

        $layout = Stub::construct(Layout::class, [$page], [
            'themeMod' => Stub::makeEmpty(LayoutMod::class, [
                'get' => $theme_mod,
            ]),
        ]);

        $this->assertSame($expected, $layout->column());
    }

    public function columnProvider(): array
    {
        return [
            'content-sidebar-sidebar' => [
                'c-s-s',
                'l-3-c',
            ],
            'sidebar-sidebar-content' => [
                's-s-c',
                'l-3-c',
            ],
            'sidebar-content-sidebar' => [
                's-c-s',
                'l-3-c',
            ],
            'content-sidebar' => [
                'c-s',
                'l-2-c',
            ],
            'sidebar-content' => [
                's-c',
                'l-2-c',
            ],
            'content' => [
                'c',
                'l-1-c',
            ],
        ];
    }
}
