<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Comments;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\Page\Page;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class CommentsTest extends TestCase
{
    public function testRun()
    {
        $comments = new Comments(Stub::makeEmpty(AbstractTheme::class));
        
        $add_action = FunctionMocker::replace('add_action');

        $comments->run();

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$comments, 'enqueueScript']
        ]);
    }

    /**
     * @dataProvider enqueueScriptProvider
     */
    public function testEnqueueScript(
        string $page,
        bool $comments_open,
        bool $thread_comments
    ) {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->page = Stub::makeEmpty(
            Page::class,
            ['is' => function (string $type) use ($page): bool {
                return ($type === $page);
            }]
        );

        $comments = new Comments($jentil);

        $copen = FunctionMocker::replace('comments_open', $comments_open);
        $get_option = FunctionMocker::replace('get_option', $thread_comments);
        $enqueue = FunctionMocker::replace('wp_enqueue_script');

        $comments->enqueueScript();

        if (!$comments_open || !$thread_comments || 'singular' !== $page) {
            $enqueue->wasNotCalled();
        } else {
            $enqueue->wasCalledOnce();
            $enqueue->wasCalledWithOnce(['comment-reply']);
        }
    }

    public function enqueueScriptProvider(): array
    {
        return [
            'page is not singular' => ['home', true, true],
            'comments closed' => ['singular', false, true],
            'comments threaded' => ['singular', true, false],
            'page is singular and comments closed and comments threaded' => [
                'singular',
                true,
                true,
            ]
        ];
    }
}
