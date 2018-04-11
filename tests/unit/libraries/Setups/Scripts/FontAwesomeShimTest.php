<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class FontAwesomeShimTest extends AbstractTestCase
{
    public function testRun()
    {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'setups' => [
                'Scripts\FontAwesome' => Stub::makeEmpty(
                    AbstractScript::class,
                    ['id' => 'fa']
                ),
            ],
        ]);

        $script = new FontAwesomeShim($jentil);

        $add_action = FunctionMocker::replace('add_action');
        $add_filter = FunctionMocker::replace('add_filter');

        $script->run();

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$script, 'enqueue']
        ]);
    }

    public function testEnqueue()
    {
        $enqueue = FunctionMocker::replace('wp_enqueue_script');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'setups' => [
                'Scripts\FontAwesome' => Stub::makeEmpty(
                    AbstractScript::class,
                    ['id' => 'fa']
                ),
            ],
        ]);

        $script = new FontAwesomeShim($jentil);

        $script->enqueue();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            $script->id,
            'https://use.fontawesome.com/releases/v5.0.10/js/v4-shims.js',
            ['fa'],
            '',
            true
        ]);
    }
}
