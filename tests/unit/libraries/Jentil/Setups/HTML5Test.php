<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class HTML5Test extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');
        $add_filter = FunctionMocker::replace('add_filter');

        $html5 = new HTML5(Stub::makeEmpty(AbstractTheme::class));

        $html5->run();

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$html5, 'addSupport']
        ]);
    }

    public function testAddSupport()
    {
        $add_theme_support = FunctionMocker::replace('add_theme_support');

        $html5 = new HTML5(Stub::makeEmpty(AbstractTheme::class));

        $html5->addSupport();

        $add_theme_support->wasCalledOnce();
        $add_theme_support->wasCalledWithOnce([
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'widgets',
            ],
        ]);
    }
}
