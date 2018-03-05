<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Thumbnails;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class ThumbnailsTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $thumbnails = new Thumbnails(Stub::makeEmpty(AbstractTheme::class));

        $thumbnails->run();

        $add_action->wasCalledTimes(3);

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$thumbnails, 'addSupport']
        ]);

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$thumbnails, 'setSize']
        ]);

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$thumbnails, 'addSizes']
        ]);
    }

    public function testAddSupport()
    {
        $add_support = FunctionMocker::replace('add_theme_support');

        $thumbnails = new Thumbnails(Stub::makeEmpty(AbstractTheme::class));

        $thumbnails->addSupport();

        $add_support->wasCalledOnce();
        $add_support->wasCalledWithOnce(['post-thumbnails']);
    }

    public function testSetSize()
    {
        $set_thumb_size = FunctionMocker::replace('set_post_thumbnail_size');

        $thumbnails = new Thumbnails(Stub::makeEmpty(AbstractTheme::class));

        $thumbnails->setSize();

        $set_thumb_size->wasCalledOnce();
        $set_thumb_size->wasCalledWithOnce([640, 360, true]);
    }

    public function testAddSizes()
    {
        $set_thumb_size = FunctionMocker::replace('set_post_thumbnail_size');
        $add_size = FunctionMocker::replace('add_image_size');

        $thumbnails = new Thumbnails(Stub::makeEmpty(AbstractTheme::class));

        $thumbnails->addSizes();

        $add_size->wasCalledTimes(3);
        $add_size->wasCalledWithOnce(['mini-thumb', 100, 100, true]);
        $add_size->wasCalledWithOnce(['micro-thumb', 75, 75, true]);
        $add_size->wasCalledWithOnce(['nano-thumb', 50, 50, true]);
    }
}
