<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\Utilities\Page;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class AuthorTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $author = new Author(Stub::makeEmpty(AbstractTheme::class));

        $author->run();

        $add_action->wasCalledOnce();

        $add_action->wasCalledWithOnce([
            'jentil_before_title',
            [$author, 'renderAvatar']
        ]);
    }

    /**
     * @dataProvider renderAvatarProvider
     */
    public function testRenderAvatar(string $page)
    {
        $get_avatar = FunctionMocker::replace('get_avatar');
        $get_query_var = FunctionMocker::replace('get_query_var', 'var');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->page = Stub::makeEmpty(Page::class, [
            'is' => function (string $type) use ($page): bool {
                return ($page === $type);
            }
        ]);

        $author = new Author($jentil);

        $author->renderAvatar();

        if ('author' === $page) {
            $get_avatar->wasCalledOnce();
            $get_avatar->wasCalledWithOnce(['var', 60]);

            $get_query_var->wasCalledOnce();
            $get_query_var->wasCalledWithOnce(['author']);
        } else {
            $get_avatar->wasNotCalled();
            $get_query_var->wasNotCalled();
        }
    }

    public function renderAvatarProvider()
    {
        return [
            'page is author' => ['author'],
            'page is not author' => ['home'],
        ];
    }
}
