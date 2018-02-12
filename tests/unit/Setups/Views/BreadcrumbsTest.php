<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Views;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Views\Breadcrumbs;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\Page\Page;
use GrottoPress\WordPress\SUV\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class BreadcrumbsTest extends TestCase
{
    public function testRun()
    {
        $breadcrumbs = new Breadcrumbs(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');

        $breadcrumbs->run();

        $add_action->wasCalledOnce();

        $add_action->wasCalledWithOnce([
            'jentil_before_before_title',
            [$breadcrumbs, 'render']
        ]);
    }

    /**
     * @dataProvider renderProvider
     */
    public function testRender(string $page1, string $page2 = '')
    {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->page = Stub::makeEmpty(Page::class, [
            'is' => function (string $type) use ($page1, $page2): bool {
                return \in_array($type, [$page1, $page2]);
            }
        ]);

        FunctionMocker::replace('esc_html__', 'Path');

        $breadcrumbs = new Breadcrumbs($jentil);

        if ($page1 === 'front_page' && $page2 !== 'paged') {
            $jentil->utilities
                ->expects($this->never())->method('breadcrumbs');
        } else {
            $jentil->utilities
                ->expects($this->once())->method('breadcrumbs')
                ->with($this->equalTo(['before' => 'Path']));
        }

        $breadcrumbs->render();
    }

    public function renderProvider(): array
    {
        return [
            'page is front page' => ['front_page'],
            'page is front page and paged' => ['front_page', 'paged'],
            'page is neither front page nor paged' => ['single'],
        ];
    }
}
