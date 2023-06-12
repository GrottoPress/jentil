<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class CustomizerTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $customizer = new Customizer(Stub::makeEmpty(AbstractTheme::class));

        $customizer->run();

        $add_action->wasCalledWithOnce([
            'customize_register',
            [$customizer, 'register']
        ]);

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$customizer, 'enableSelectiveRefresh'],
        ]);
    }

    public function testRegister()
    {
        $this->markTestSkipped();
    }

    public function testEnableSelectiveRefresh()
    {
        $add_theme_support = FunctionMocker::replace('add_theme_support');

        $customizer = new Customizer(Stub::makeEmpty(AbstractTheme::class));

        $customizer->enableSelectiveRefresh();

        $add_theme_support->wasCalledOnce();
        $add_theme_support->wasCalledWithOnce([
            'customize-selective-refresh-widgets'
        ]);
    }
}
