<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class MenuTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $script = new Menu(Stub::makeEmpty(AbstractTheme::class));

        $script->run();

        $add_action->wasCalledTimes(2);

        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$script, 'enqueue']
        ]);

        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$script, 'localize']
        ]);
    }

    public function testEnqueue()
    {
        $enqueue = FunctionMocker::replace('wp_enqueue_script');

        $test_js = \codecept_data_dir('scripts/test.js');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => function (
                string $type,
                string $append
            ) use ($test_js): string {
                return 'path' === $type ? $test_js : "http://my.url/test.js";
            },
        ]);

        $script = new Menu($jentil);

        $script->enqueue();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            $script->id,
            'http://my.url/test.js',
            ['jquery'],
            \filemtime($test_js),
            true,
        ]);
    }

    public function testLocalize()
    {
        $localize = FunctionMocker::replace('wp_localize_script');

        FunctionMocker::replace('esc_html__');

        $script = new Menu(Stub::makeEmpty(AbstractTheme::class));

        $script->localize();

        $localize->wasCalledOnce();
        $localize->wasCalledWithOnce([$script->id, 'jentilMenuL10n']);
    }
}
