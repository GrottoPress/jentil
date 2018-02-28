<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Scripts;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Scripts\CommentReply;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\Page\Page;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class CommentReplyTest extends AbstractTestCase
{
    /**
     * @dataProvider enqueueProvider
     */
    public function testEnqueue(
        string $page,
        bool $script_open,
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

        $script = new CommentReply($jentil);

        $copen = FunctionMocker::replace('comments_open', $script_open);
        $get_option = FunctionMocker::replace('get_option', $thread_comments);
        $enqueue = FunctionMocker::replace('wp_enqueue_script');

        $script->enqueue();

        if (!$script_open || !$thread_comments || 'singular' !== $page) {
            $enqueue->wasNotCalled();
        } else {
            $enqueue->wasCalledOnce();
            $enqueue->wasCalledWithOnce(['comment-reply']);
        }
    }

    public function enqueueProvider(): array
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
