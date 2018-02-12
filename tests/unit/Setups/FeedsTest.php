<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Feeds;
use GrottoPress\WordPress\SUV\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class FeedsTest extends TestCase
{
    public function testRun()
    {
        $feeds = new Feeds(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');

        $feeds->run();

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$feeds, 'addSupport']
        ]);
    }

    public function testAddSupport()
    {
        $feeds = new Feeds(Stub::makeEmpty(AbstractTheme::class));

        $add_theme_support = FunctionMocker::replace('add_theme_support');

        $feeds->addSupport();

        $add_theme_support->wasCalledOnce();
        $add_theme_support->wasCalledWithOnce(['automatic-feed-links']);
    }
}
