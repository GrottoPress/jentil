<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class jQueryTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $script = new jQuery(Stub::makeEmpty(AbstractTheme::class));

        $script->run();

        $add_action->wasCalledTimes(3);

        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$script, 'deregister']
        ]);

        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$script, 'enqueue']
        ]);

        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$script, 'addInlineScript']
        ]);
    }

    public function testDeregister()
    {
        $wp_deregister_script = FunctionMocker::replace('wp_deregister_script');

        $script = new jQuery(Stub::makeEmpty(AbstractTheme::class));

        $script->deregister();

        $wp_deregister_script->wasCalledTimes(1);
        $wp_deregister_script->wasCalledWithOnce([$script->id]);
    }

    public function testEnqueue()
    {
        $enqueue = FunctionMocker::replace('wp_enqueue_script');

        $test_js = \codecept_data_dir('scripts/test.js');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class)
        ]);

        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => function (
                string $type,
                string $append
            ) use ($test_js): string {
                return 'path' === $type ? $test_js : "http://my.url/test.js";
            },
        ]);

        $script = new jQuery($jentil);

        $script->enqueue();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            $script->id,
            'http://my.url/test.js',
            [],
            \filemtime($test_js),
            true
        ]);
    }

    public function testAddInlineScript()
    {
        $add_inline_script = FunctionMocker::replace('wp_add_inline_script');

        $script = new jQuery(Stub::makeEmpty(AbstractTheme::class));

        $script->addInlineScript();

        $add_inline_script->wasCalledTimes(1);

        $add_inline_script->wasCalledWithOnce([
            $script->id,
            'jQuery.noConflict();',
            'after'
        ]);
    }
}
