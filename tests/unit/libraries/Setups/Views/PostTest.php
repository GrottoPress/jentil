<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\Page\Page;
use GrottoPress\WordPress\Post\Post as PostPackage;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class PostTest extends AbstractTestCase
{
    /**
     * @var AbstractTheme
     */
    private $jentil;

    /**
     * @var string
     */
    private $page;

    /**
     * @var string
     */
    private $subPage = '';

    public function _before()
    {
        $this->jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $this->jentil->utilities->page = Stub::makeEmpty(Page::class, [
            'is' => function (string $type, string $subtype = ''): bool {
                if ($subtype) {
                    return $this->page === $type && $this->subPage === $subtype;
                }

                return ($this->page === $type);
            }
        ]);
    }

    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');
        $add_filter = FunctionMocker::replace('add_filter');

        $post = new Post(Stub::makeEmpty(AbstractTheme::class));

        $post->run();

        $add_action->wasCalledOnce();
        $add_filter->wasCalledOnce();

        $add_action->wasCalledWithOnce([
            'jentil_after_title',
            [$post, 'renderByline']
        ]);

        $add_filter->wasCalledWithOnce([
            'jentil_singular_after_title',
            [$post, 'byline'],
            10,
            3
        ]);
    }

    /**
     * @dataProvider bylineProvider
     */
    public function testByline(string $page, string $subPage)
    {
        $this->page = $page;
        $this->subPage = $subPage;

        $this->jentil->utilities->post = Stub::makeEmpty(PostPackage::class, [
            'info' => true,
        ]);

        $post = new Post($this->jentil);

        if ('singular' === $page && 'post' === $subPage) {
            $this->jentil->utilities->post
                ->expects($this->atLeastOnce())->method('info');
        } else {
            $this->jentil->utilities->post
                ->expects($this->never())->method('info');
        }

        $byline = $post->byline('hello...', 1, '|');

        if ('singular' !== $page || 'post' !== $subPage) {
            $this->assertSame('hello...', $byline);
        }
    }

    /**
     * @dataProvider renderBylineProvider
     */
    public function testRenderByline(string $page, string $subPage)
    {
        $this->page = $page;

        FunctionMocker::replace('get_post', new class {
            public $ID = 1;
        });

        $this->jentil->utilities->post = Stub::makeEmpty(PostPackage::class, [
            'info' => true,
        ]);

        $post = new Post($this->jentil);

        if ('singular' === $page && 'post' === $subPage) {
            $this->jentil->utilities->post
                ->expects($this->atLeastOnce())->method('info');
        } else {
            $this->jentil->utilities->post
                ->expects($this->never())->method('info');
        }

        $post->renderByline();
    }

    public function bylineProvider(): array
    {
        return [
            'page is single post' => ['singular', 'post'],
            'page is not single post' => ['home', ''],
        ];
    }

    public function renderBylineProvider(): array
    {
        return [
            'page is single post' => ['singular', 'post'],
            'page is not single post' => ['home', ''],
        ];
    }
}
