<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Styles;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class WordPressPostsTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $style = new WordPressPosts(Stub::makeEmpty(AbstractTheme::class));

        $style->run();

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$style, 'enqueue']
        ]);
    }

    public function testEnqueue()
    {
        $enqueue = FunctionMocker::replace('wp_enqueue_style');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
            'setups' => ['Styles\Normalize' => new class {
                public $id;
            }],
        ]);
        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => 'http://my.url/dist/styles/posts.css'
        ]);

        $style = new WordPressPosts($jentil);

        $style->enqueue();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            $style->id,
            'http://my.url/dist/styles/posts.css',
            [$jentil->setups['Styles\Normalize']->id],
        ]);
    }
}
