<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Utilities;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\CustomTemplate;
use GrottoPress\Jentil\Utilities\Page\Page;
use tad\FunctionMocker\FunctionMocker;

class CustomTemplateTest extends AbstractTestCase
{
    /**
     * @dataProvider isPageBuilderProvider
     */
    public function testIsPageBuilder(
        string $slug,
        int $post_id,
        bool $expected
    ) {
        $utilities = Stub::makeEmpty(Utilities::class);
        $utilities->page = Stub::makeEmpty(Page::class, [
            'is' => function (string $type, array $subtype) use ($slug): bool {
                return \in_array($slug, $subtype);
            }
        ]);

        $template = new CustomTemplate($utilities);

        FunctionMocker::replace('get_page_template_slug', $slug);

        $this->assertSame($expected, $template->isPageBuilder($post_id));
    }

    public function testSlug()
    {
        $get_page_template_slug = FunctionMocker::replace(
            'get_page_template_slug'
        );

        $template = new CustomTemplate(Stub::makeEmpty(Utilities::class));

        $template->slug(1011);

        $get_page_template_slug->wasCalledOnce();
        $get_page_template_slug->wasCalledWithOnce([1011]);
    }

    public function testIs()
    {
        $utilities = Stub::makeEmpty(Utilities::class);
        $utilities->page = Stub::makeEmpty(Page::class, ['is' => true]);

        $template = new CustomTemplate($utilities);

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
            'post id set, slug is page-builder-blank.php' => [
                'page-builder-blank.php',
                1,
                true
            ],
            'post id set, slug is invalid' => ['page.php', 1, false],
            'post id not set, slug is page-builder.php' => [
                'page-builder.php',
                0,
                true
            ],
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
