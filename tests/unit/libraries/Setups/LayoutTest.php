<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\Page;
use GrottoPress\Jentil\Utilities\PostTypeTemplate;
use GrottoPress\Jentil\Utilities\ThemeMods;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class LayoutTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');
        $add_filter = FunctionMocker::replace('add_filter');

        $layout = new Layout(Stub::makeEmpty(AbstractTheme::class));

        $layout->run();

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$layout, 'setContentWidth']
        ]);

        $add_filter->wasCalledOnce();
        $add_filter->wasCalledWithOnce([
            'body_class',
            [$layout, 'addBodyClasses']
        ]);
    }

    /**
     * @dataProvider addBodyClassesProvider
     */
    public function testAddBodyClasses(
        array $classes,
        bool $is_page_builder,
        string $theme_mod,
        string $column,
        array $expected
    ) {
        $sanitize_title = FunctionMocker::replace(
            'sanitize_title',
            function (string $content): string {
                return $content;
            }
        );

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->postTypeTemplate = Stub::makeEmpty(
            PostTypeTemplate::class,
            ['isPageBuilder' => $is_page_builder]
        );

        $jentil->utilities->page = Stub::makeEmpty(Page\Page::class);
        $jentil->utilities->page->layout = Stub::makeEmpty(Page\Layout::class, [
            'themeMod' => Stub::makeEmpty(ThemeMods\Layout::class, [
                'get' => $theme_mod,
            ]),
            'column' => $column,
        ]);

        $layout = new Layout($jentil);

        $this->assertSame($expected, $layout->addBodyClasses($classes));

        if ($is_page_builder) {
            $sanitize_title->wasNotCalled();
        } else {
            if ($theme_mod) {
                $sanitize_title->wasCalledWithOnce(["layout-{$theme_mod}"]);
            }

            if ($column) {
                $sanitize_title->wasCalledWithOnce(["layout-{$column}"]);
            }
        }
    }

    public function testSetContentWidth()
    {
        $layout = new Layout(Stub::makeEmpty(AbstractTheme::class));

        $layout->setContentWidth();

        global $content_width;

        $this->assertSame(960, $content_width);
    }

    public function addBodyClassesProvider(): array
    {
        return [
            'body classes not added if is pagebuilder' => [
                ['class-1', 'class-2'],
                true,
                'content-sidebar-sidebar',
                'three-columns',
                ['class-1', 'class-2'],
            ],
            'body classes added if themeMod not empty' => [
                ['class-1', 'class-2'],
                false,
                'sidebar-content',
                '',
                ['class-1', 'class-2', 'layout-sidebar-content'],
            ],
            'body classes added if content not empty' => [
                ['class-3', 'class-4'],
                false,
                '',
                'three-columns',
                ['class-3', 'class-4', 'layout-three-columns'],
            ],
            'body classes added if content and themeMod not empty' => [
                ['class-7', 'class-8'],
                false,
                'content-sidebar-content',
                'three-columns',
                [
                    'class-7',
                    'class-8',
                    'layout-content-sidebar-content',
                    'layout-three-columns'
                ],
            ],
            'body classes not added if content and themeMod empty' => [
                ['class-7', 'class-8'],
                false,
                '',
                '',
                [
                    'class-7',
                    'class-8',
                ],
            ],
        ];
    }
}
