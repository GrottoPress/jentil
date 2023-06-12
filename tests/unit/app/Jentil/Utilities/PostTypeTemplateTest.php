<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\Utilities\Page;
use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\Setups\PostTypeTemplates\AbstractTemplate;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class PostTypeTemplateTest extends AbstractTestCase
{
    /**
     * @dataProvider isPageBuilderProvider
     */
    public function testIsPageBuilder(
        string $slug,
        int $post_id,
        bool $expected
    ) {
        FunctionMocker::replace('get_page_template_slug', $slug);

        $utilities = Stub::makeEmpty(Utilities::class);
        $utilities->app = Stub::makeEmpty(AbstractTheme::class, [
            'setups' => [
                'PostTypeTemplates\PageBuilder' => Stub::makeEmpty(
                    AbstractTemplate::class,
                    ['slug' => 'page-builder.php']
                ),
                'PostTypeTemplates\PageBuilderBlank' => Stub::makeEmpty(
                    AbstractTemplate::class,
                    ['slug' => 'page-builder-blank.php']
                ),
            ],
        ]);
        $utilities->page = Stub::makeEmpty(Page::class, [
            'is' => function (string $type, array $subtype) use ($slug): bool {
                return \in_array($slug, $subtype);
            }
        ]);

        $template = new PostTypeTemplate($utilities);

        $this->assertSame($expected, $template->isPageBuilder($post_id));
    }

    /**
     * @dataProvider isPageBuilderBlankProvider
     */
    public function testIsPageBuilderBlank(
        string $slug,
        int $post_id,
        bool $expected
    ) {
        FunctionMocker::replace('get_page_template_slug', $slug);

        $utilities = Stub::makeEmpty(Utilities::class);
        $utilities->app = Stub::makeEmpty(AbstractTheme::class, [
            'setups' => [
                'PostTypeTemplates\PageBuilder' => Stub::makeEmpty(
                    AbstractTemplate::class,
                    ['slug' => 'page-builder.php']
                ),
                'PostTypeTemplates\PageBuilderBlank' => Stub::makeEmpty(
                    AbstractTemplate::class,
                    ['slug' => 'page-builder-blank.php']
                ),
            ],
        ]);
        $utilities->page = Stub::makeEmpty(Page::class, [
            'is' => function (string $type, array $subtype) use ($slug): bool {
                return \in_array($slug, $subtype);
            }
        ]);

        $template = new PostTypeTemplate($utilities);

        $this->assertSame($expected, $template->isPageBuilderBlank($post_id));
    }

    public function testSlug()
    {
        $get_page_template_slug = FunctionMocker::replace(
            'get_page_template_slug'
        );

        $template = new PostTypeTemplate(Stub::makeEmpty(Utilities::class));

        $template->slug(1011);

        $get_page_template_slug->wasCalledOnce();
        $get_page_template_slug->wasCalledWithOnce([1011]);
    }

    public function testIs()
    {
        $utilities = Stub::makeEmpty(Utilities::class);
        $utilities->page = Stub::makeEmpty(Page::class, ['is' => true]);

        $template = new PostTypeTemplate($utilities);

        $utilities->page->expects($this->once())->method('is')
            ->with($this->equalTo('page_template'), $this->equalTo(['a.php']));

        $template->is(['a.php']);
    }

    public function isPageBuilderProvider(): array
    {
        return [
            'post id set, slug is page-builder.php' => [
                'page-builder.php',
                1,
                true
            ],
            'post id set, slug is invalid' => ['page.php', 1, false],
            'post id not set, slug is page-builder.php' => [
                'page-builder.php',
                0,
                true
            ],
            'post id not set, slug is invalid' => [
                'page.php',
                0,
                false
            ],
        ];
    }

    public function isPageBuilderBlankProvider(): array
    {
        return [
            'post id set, slug is page-builder-blank.php' => [
                'page-builder-blank.php',
                1,
                true
            ],
            'post id set, slug is invalid' => ['page.php', 1, false],
            'post id not set, slug is page-builder-blank.php' => [
                'page-builder-blank.php',
                0,
                true
            ],
            'post id not set, slug is invalid' => [
                'page.php',
                0,
                false
            ],
        ];
    }
}
