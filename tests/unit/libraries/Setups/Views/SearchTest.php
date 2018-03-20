<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\Page\Page;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;
use Exception;

class SearchTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $search = new Search(Stub::makeEmpty(AbstractTheme::class));

        $search->run();

        $add_action->wasCalledTimes(2);

        $add_action->wasCalledWithOnce([
            'template_redirect',
            [$search, 'redirect']
        ]);

        $add_action->wasCalledWithOnce([
            'jentil_before_content',
            [$search, 'renderSearchForm']
        ]);
    }

    /**
     * @dataProvider redirectProvider
     */
    public function testRedirect(
        string $page,
        string $keywords,
        bool $permalinks
    ) {
        $this->markTestSkipped('Find a better way to deal with the exit call');

        FunctionMocker::setGlobal('wp_rewrite', new class($permalinks) {
            private $permalinks;

            function __construct($permalinks)
            {
                $this->permalinks = $permalinks;
            }

            function using_permalinks(): bool
            {
                return $this->permalinks;
            }
        });

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->page = Stub::makeEmpty(Page::class, [
            'is' => function (string $type) use ($page): bool {
                return ($page === $type);
            },
            'URL' => "http://my.site/?s={$keywords}",
        ]);

        $search = new Search($jentil);

        $wp_redirect = FunctionMocker::replace('wp_redirect');
        $get_search_link = FunctionMocker::replace(
            'get_search_link',
            "http://my.site/search/{$keywords}"
        );

        // if ('search' === $page && $keywords && $permalinks) {
        //     $this->expectException(Exception::class);
        // }

        $search->redirect();

        if ('search' === $page && $keywords && $permalinks) {
            $wp_redirect->wasCalledOnce();
            $wp_redirect->wasCalledWithOnce([
                "http://my.site/search/{$keywords}",
                301
            ]);
            $get_search_link->wasCalledOnce();
        } else {
            $wp_redirect->wasNotCalled();
            $get_search_link->wasNotCalled();
        }
    }

    /**
     * @dataProvider renderSearchFormProvider
     */
    public function testRenderSearchForm(string $page)
    {
        $get_search_form = FunctionMocker::replace('get_search_form');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->page = Stub::makeEmpty(Page::class, [
            'is' => function (string $type) use ($page): bool {
                return ($page === $type);
            }
        ]);

        $search = new Search($jentil);

        $search->renderSearchForm();

        if ('search' === $page) {
            $get_search_form->wasCalledOnce();
        } else {
            $get_search_form->wasNotCalled();
        }
    }

    public function redirectProvider(): array
    {
        return [
            'on search archive' => ['search', '', false],
            'on search archive and using permalinks' => ['search', '', true],
            'on search archive and search term set' => [
                'search',
                'koko',
                false,
            ],
            'on search archive, using permalinks and search term set' => [
                'search',
                'holiday+inn',
                true,
            ],
            'using permalinks' => ['home', '', true],
            'using permalinks and search term set' => ['home', 'hello',  true],
            'search term set' => ['home', 'bambara+beans', false],
        ];
    }

    public function renderSearchFormProvider(): array
    {
        return [
            'on search archive' => ['search'],
            'not on search archive' => ['home'],
        ];
    }
}
