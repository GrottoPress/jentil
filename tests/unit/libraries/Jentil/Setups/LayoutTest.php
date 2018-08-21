<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\Utilities\Page;
use GrottoPress\Jentil\Utilities\Page\Layout as LayoutUtil;
use GrottoPress\Jentil\Utilities\PostTypeTemplate;
use GrottoPress\Jentil\Utilities\ThemeMods;
use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
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
        bool $is_page_builder_blank,
        string $theme_mod,
        string $column,
        array $expected
    ) {
        FunctionMocker::replace(
            'sanitize_html_class',
            function (string $content): string {
                return $content;
            }
        );

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->postTypeTemplate = Stub::makeEmpty(
            PostTypeTemplate::class,
            [
                '__call' => function (string $name, array $args) use (
                    $is_page_builder,
                    $is_page_builder_blank
                ) {
                    return (
                        'isPageBuilderBlank' === $name ?
                        $is_page_builder_blank :
                        $is_page_builder
                    );
                }
            ]
        );

        $jentil->utilities->page = Stub::makeEmpty(Page::class);
        $jentil->utilities->page->layout = Stub::makeEmpty(LayoutUtil::class, [
            'themeMod' => Stub::makeEmpty(ThemeMods\Layout::class, [
                'get' => $theme_mod,
            ]),
            'column' => $column,
        ]);

        $layout = new Layout($jentil);

        $this->assertSame($expected, $layout->addBodyClasses($classes));
    }

    public function testSetContentWidth()
    {
        $layout = new Layout(Stub::makeEmpty(AbstractTheme::class));

        $layout->setContentWidth();

        global $content_width;

        $this->assertSame(1000, $content_width);
    }

    public function addBodyClassesProvider(): array
    {
        return [
            'body classes not added if using pagebuilder template' => [
                ['class-1', 'class-2'],
                true,
                false,
                'content-sidebar-sidebar',
                'three-columns',
                ['class-1', 'class-2'],
            ],
            'body classes not added if using blank pagebuilder template' => [
                ['class-1', 'class-2'],
                false,
                true,
                'content-sidebar-sidebar',
                'three-columns',
                ['class-1', 'class-2'],
            ],
            'body classes added if themeMod not empty' => [
                ['class-1', 'class-2'],
                false,
                false,
                'sidebar-content',
                '',
                ['class-1', 'class-2', 'layout-sidebar-content'],
            ],
            'body classes added if column not empty' => [
                ['class-3', 'class-4'],
                false,
                false,
                '',
                'three-columns',
                ['class-3', 'class-4', 'layout-three-columns'],
            ],
            'body classes added if column and themeMod not empty' => [
                ['class-7', 'class-8'],
                false,
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
            'body classes not added if column and themeMod empty' => [
                ['class-7', 'class-8'],
                false,
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
