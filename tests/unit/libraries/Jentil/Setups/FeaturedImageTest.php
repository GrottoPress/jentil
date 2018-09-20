<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class FeaturedImageTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $image = new FeaturedImage(Stub::makeEmpty(AbstractTheme::class));

        $image->run();

        $add_action->wasCalledTimes(2);

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$image, 'addSupport']
        ]);

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$image, 'setSize']
        ]);
    }

    public function testAddSupport()
    {
        $add_support = FunctionMocker::replace('add_theme_support');

        $image = new FeaturedImage(Stub::makeEmpty(AbstractTheme::class));

        $image->addSupport();

        $add_support->wasCalledOnce();
        $add_support->wasCalledWithOnce(['post-thumbnails']);
    }

    public function testSetSize()
    {
        $set_thumb_size = FunctionMocker::replace('set_post_thumbnail_size');

        $image = new FeaturedImage(Stub::makeEmpty(AbstractTheme::class));

        $image->setSize();

        $set_thumb_size->wasCalledOnce();
        $set_thumb_size->wasCalledWithOnce([640, 360, true]);
    }
}
