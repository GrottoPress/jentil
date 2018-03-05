<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Feeds;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class FeedsTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $feeds = new Feeds(Stub::makeEmpty(AbstractTheme::class));

        $feeds->run();

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$feeds, 'addSupport']
        ]);
    }

    public function testAddSupport()
    {
        $add_theme_support = FunctionMocker::replace('add_theme_support');

        $feeds = new Feeds(Stub::makeEmpty(AbstractTheme::class));

        $feeds->addSupport();

        $add_theme_support->wasCalledOnce();
        $add_theme_support->wasCalledWithOnce(['automatic-feed-links']);
    }
}
