<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\Utilities\ShortTags;
use GrottoPress\Jentil\Utilities\Page;
use GrottoPress\Jentil\Utilities\Page\Posts;
use GrottoPress\Jentil\Setups\Customizer\AbstractCustomizer;
use GrottoPress\Jentil\Setups\Customizer\AbstractPanel;
use GrottoPress\Jentil\Setups\Customizer\AbstractSection;
use GrottoPress\Jentil\Setups\Customizer\AbstractSetting;
use GrottoPress\Jentil\Setups\Customizer\Title\Settings\AbstractSetting
    as TitleSetting;
use GrottoPress\Jentil\Setups\Customizer\Layout\Settings\AbstractSetting
    as LayoutSetting;
use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class CustomizePreviewTest extends AbstractTestCase
{
    public function _before()
    {
        FunctionMocker::replace('wp_json_encode', function ($content): string {
            return \json_encode($content);
        });
    }

    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $script = new CustomizePreview(Stub::makeEmpty(AbstractTheme::class, [
            'theme' => new class {
                public $stylesheet;
            }
        ]));

        $script->run();

        $add_action->wasCalledTimes(3);

        $add_action->wasCalledWithOnce([
            'customize_preview_init',
            [$script, 'enqueue'],
        ]);

        $add_action->wasCalledWithOnce([
            'customize_preview_init',
            [$script, 'addInlineScript'],
        ]);

        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$script, 'addFrontEndInlineScript'],
        ]);
    }

    public function testEnqueue()
    {
        $wp_enqueue_script = FunctionMocker::replace('wp_enqueue_script');
        $add_inline_script = FunctionMocker::replace('wp_add_inline_script');

        $test_js = \codecept_data_dir('scripts/test.js');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
            'theme' => new class {
                public $stylesheet;
            }
        ]);

        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => function (
                string $type,
                string $append
            ) use ($test_js): string {
                return 'path' === $type ? $test_js : "http://my.url/test.js";
            },
        ]);

        $script = new CustomizePreview($jentil);

        $script->enqueue();

        $wp_enqueue_script->wasCalledOnce();
        $wp_enqueue_script->wasCalledWithOnce([
            $script->id,
            'http://my.url/test.js',
            ['customize-preview'],
            \filemtime($test_js),
            true
        ]);
    }

    public function testAddInlineScript()
    {
        $add_inline_script = FunctionMocker::replace('wp_add_inline_script');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
            'theme' => new class {
                public $stylesheet;
            },
            'setups' => ['Customizer' => Stub::makeEmpty(
                AbstractCustomizer::class,
                [
                    'panels' => ['Posts' => Stub::makeEmpty(
                        AbstractPanel::class,
                        ['sections' => [
                            'Related_post' => Stub::makeEmpty(
                                AbstractSection::class,
                                ['settings' => [
                                    'Heading' => Stub::makeEmpty(
                                        AbstractSetting::class,
                                        ['id' => 'Related posts']
                                    ),
                                ]]
                            ),
                            'Related_page' => Stub::makeEmpty(
                                AbstractSection::class,
                                ['settings' => [
                                    'Heading' => Stub::makeEmpty(
                                        AbstractSetting::class,
                                        ['id' => 'Related pages']
                                    ),
                                ]]
                            ),
                        ]]
                    )],
                    'sections' => [
                        'Footer' => Stub::makeEmpty(
                            AbstractSection::class,
                            ['settings' => ['Colophon' => Stub::makeEmpty(
                                AbstractSetting::class,
                                ['id' => 'colophon']
                            )]]
                        ),
                        'Title' => Stub::makeEmpty(
                            AbstractSection::class,
                            ['settings' => ['Date' => Stub::makeEmpty(
                                TitleSetting::class,
                                ['id' => 'date_title']
                            )]]
                        ),
                        'Layout' => Stub::makeEmpty(
                            AbstractSection::class,
                            ['settings' => ['Date' => Stub::makeEmpty(
                                LayoutSetting::class,
                                ['id' => 'date_title']
                            )]]
                        ),
                    ],
                ]
            )],
        ]);

        $jentil->utilities->page = Stub::makeEmpty(Page::class);
        $jentil->utilities->page->posts = Stub::makeEmpty(Posts::class, [
            'postTypes' => [
                new class {
                    public $name = 'page';
                },
                new class {
                    public $name = 'post';
                },
            ],
        ]);

        $script = new CustomizePreview($jentil);

        $script->addInlineScript();

        $add_inline_script->wasCalledOnce();
        $add_inline_script->wasCalledWithOnce([$script->id]);
    }

    public function testAddFrontEndInlineScript()
    {
        $add_inline_script = FunctionMocker::replace('wp_add_inline_script');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
            'theme' => new class {
                public $stylesheet;
            }
        ]);

        $jentil->utilities->shortTags = Stub::makeEmpty(ShortTags::class, [
            'get' => ['{{short_tags}}'],
        ]);

        $script = new CustomizePreview($jentil);

        $script->addFrontEndInlineScript();

        $add_inline_script->wasCalledOnce();
        $add_inline_script->wasCalledWithOnce([$script->id]);
    }
}
