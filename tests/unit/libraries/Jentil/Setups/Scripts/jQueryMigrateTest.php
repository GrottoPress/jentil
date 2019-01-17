<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class jQueryMigrateTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $script = new jQueryMigrate(Stub::makeEmpty(AbstractTheme::class));

        $script->run();

        $add_action->wasCalledTimes(2);

        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$script, 'deregister']
        ]);

        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$script, 'enqueue']
        ]);
    }

    public function testDeregister()
    {
        $wp_deregister_script = FunctionMocker::replace('wp_deregister_script');

        $script = new jQueryMigrate(Stub::makeEmpty(AbstractTheme::class));

        $script->deregister();

        $wp_deregister_script->wasCalledTimes(1);
        $wp_deregister_script->wasCalledWithOnce([$script->id]);
    }

    public function testEnqueue()
    {
        $enqueue = FunctionMocker::replace('wp_enqueue_script');

        $test_js = \codecept_data_dir('scripts/test.js');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
            'setups' => [
                'Scripts\jQuery' => Stub::makeEmpty(
                    AbstractScript::class,
                    ['id' => 'jq']
                ),
            ],
        ]);

        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => function (
                string $type,
                string $append
            ) use ($test_js): string {
                return 'path' === $type ? $test_js : "http://my.url/test.js";
            },
        ]);

        $script = new jQueryMigrate($jentil);

        $script->enqueue();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            $script->id,
            'http://my.url/test.js',
            ['jq'],
            \filemtime($test_js),
            true
        ]);
    }
}
