<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Customizer;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Customizer\Customizer;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\Utilities\ShortTags;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class CustomizerTest extends AbstractTestCase
{
    public function testRun()
    {
        $customizer = new Customizer(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');

        $customizer->run();

        $add_action->wasCalledTimes('>=3');

        $add_action->wasCalledWithOnce([
            'customize_preview_init',
            [$customizer, 'enqueueScript'],
        ]);

        $add_action->wasCalledWithOnce([
            'customize_preview_init',
            [$customizer, 'enqueueInlineScript'],
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

    public function testEnqueueScript()
    {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->fileSystem = Stub::make(FileSystem::class, [
            'dir' => 'http://my.site/dist/scripts/customizer.js',
        ]);
        
        $customizer = new Customizer($jentil);

        $wp_enqueue_script = FunctionMocker::replace('wp_enqueue_script');
        
        $customizer->enqueueScript($customizer);

        $wp_enqueue_script->wasCalledOnce();
        $wp_enqueue_script->wasCalledWithOnce([
            'jentil-customizer',
            'http://my.site/dist/scripts/customizer.js',
            ['jquery', 'customize-preview'],
            '',
            true
        ]);
    }

    public function testEnqueueInlineJS()
    {
        $this->markTestSkipped('We may need a Customizer stub for this');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->shortTags = Stub::make(ShortTags::class, [
            'get' => ['{{short_tags}}'],
        ]);

        $customizer = new Customizer($jentil);

        $add_script = FunctionMocker::replace('wp_add_inline_script');

        $customizer->enqueueInlineScript();

        $add_script->wasCalledOnce();
    }

    public function testEnableSelectiveRefresh()
    {
        $customizer = new Customizer(Stub::makeEmpty(AbstractTheme::class));

        $add_theme_support = FunctionMocker::replace('add_theme_support');

        $customizer->enableSelectiveRefresh();

        $add_theme_support->wasCalledOnce();
        $add_theme_support->wasCalledWithOnce([
            'customize-selective-refresh-widgets'
        ]);
    }
}
