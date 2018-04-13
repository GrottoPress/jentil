<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\Utilities\ShortTags;
use GrottoPress\Jentil\Utilities\Page\Page;
use GrottoPress\Jentil\Utilities\Page\Posts\Posts;
use GrottoPress\Jentil\Setups\Customizer\AbstractCustomizer;
use GrottoPress\Jentil\Setups\Customizer\AbstractPanel;
use GrottoPress\Jentil\Setups\Customizer\AbstractSection;
use GrottoPress\Jentil\Setups\Customizer\AbstractSetting;
use GrottoPress\Jentil\AbstractTheme;
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

        $script = new CustomizePreview(Stub::makeEmpty(AbstractTheme::class));

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
            [$script, 'addInlineScript2'],
        ]);
    }

    public function testEnqueue()
    {
        $wp_enqueue_script = FunctionMocker::replace('wp_enqueue_script');
        $add_inline_script = FunctionMocker::replace('wp_add_inline_script');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => 'http://my.site/dist/scripts/customizer.js',
        ]);

        $script = new CustomizePreview($jentil);

        $script->enqueue();

        $wp_enqueue_script->wasCalledOnce();
        $wp_enqueue_script->wasCalledWithOnce([
            $script->id,
            'http://my.site/dist/scripts/customizer.js',
            ['jquery', 'customize-preview'],
            '',
            true
        ]);
    }

    public function testAddInlineScript()
    {
        $add_inline_script = FunctionMocker::replace('wp_add_inline_script');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
            'setups' => [
                'Customizer\Customizer' => Stub::makeEmpty(
                    AbstractCustomizer::class,
                    [
                        'panels' => [
                            'Posts\Posts' => Stub::makeEmpty(
                                AbstractPanel::class,
                                ['sections' => [
                                    'Related_post' => Stub::makeEmpty(
                                        AbstractSection::class,
                                        [
                                            'settings' => [
                                                'Heading' => Stub::makeEmpty(
                                                    AbstractSetting::class,
                                                    ['id' => 'Related posts']
                                                ),
                                            ],
                                        ]
                                    ),
                                    'Related_page' => Stub::makeEmpty(
                                        AbstractSection::class,
                                        [
                                            'settings' => [
                                                'Heading' => Stub::makeEmpty(
                                                    AbstractSetting::class,
                                                    ['id' => 'Related pages']
                                                ),
                                            ],
                                        ]
                                    ),
                                ]]
                            ),
                        ],
                        'sections' => [
                            'Colophon\Colophon' => Stub::makeEmpty(
                                AbstractSection::class,
                                [
                                    'settings' => ['Colophon' => Stub::makeEmpty(
                                        AbstractSetting::class,
                                        [
                                            'id' => 'colophon',
                                        ]
                                    )],
                                ]
                            ),
                            'Title\Title' => Stub::makeEmpty(
                                AbstractSection::class,
                                [
                                    'settings' => ['Date' => Stub::makeEmpty(
                                        AbstractSetting::class,
                                        [
                                            'id' => 'date_title',
                                        ]
                                    )],
                                ]
                            ),
                        ],
                    ]
                ),
            ],
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
        $add_inline_script->wasCalledWithOnce(['jentil-customize-preview']);
    }

    public function testAddInlineScript2()
    {
        $add_inline_script = FunctionMocker::replace('wp_add_inline_script');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->shortTags = Stub::makeEmpty(ShortTags::class, [
            'get' => ['{{short_tags}}'],
        ]);

        $script = new CustomizePreview($jentil);

        $script->addInlineScript2();

        $add_inline_script->wasCalledOnce();
        $add_inline_script->wasCalledWithOnce(['jentil-customize-preview']);
    }
}
