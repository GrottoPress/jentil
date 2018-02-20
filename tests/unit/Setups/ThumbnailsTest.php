<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Thumbnails;
use GrottoPress\WordPress\SUV\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class ThumbnailsTest extends TestCase
{
    public function testRun()
    {
        $thumbnails = new Thumbnails(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');

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
        $thumbnails = new Thumbnails(Stub::makeEmpty(AbstractTheme::class));

        $add_support = FunctionMocker::replace('add_theme_support');

        $thumbnails->addSupport();

        $add_support->wasCalledOnce();
        $add_support->wasCalledWithOnce(['post-thumbnails']);
    }

    public function testSetSize()
    {
        $thumbnails = new Thumbnails(Stub::makeEmpty(AbstractTheme::class));

        $set_thumb_size = FunctionMocker::replace('set_post_thumbnail_size');

        $thumbnails->setSize();

        $set_thumb_size->wasCalledOnce();
        $set_thumb_size->wasCalledWithOnce([640, 360, true]);
    }

    public function testAddSizes()
    {
        $thumbnails = new Thumbnails(Stub::makeEmpty(AbstractTheme::class));

        $set_thumb_size = FunctionMocker::replace('set_post_thumbnail_size');
        $add_size = FunctionMocker::replace('add_image_size');

        $thumbnails->addSizes();

        $add_size->wasCalledTimes(3);
        $add_size->wasCalledWithOnce(['mini-thumb', 100, 100, true]);
        $add_size->wasCalledWithOnce(['micro-thumb', 75, 75, true]);
        $add_size->wasCalledWithOnce(['nano-thumb', 50, 50, true]);
    }
}
