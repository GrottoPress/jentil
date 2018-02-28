<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Scripts;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Scripts\CustomizePreview;
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
    public function testRun()
    {
        $script = new CustomizePreview(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');

        $script->run();

        $add_action->wasCalledTimes(2);

        $add_action->wasCalledWithOnce([
            'customize_preview_init',
            [$script, 'enqueue'],
        ]);

        $add_action->wasCalledWithOnce([
            'customize_preview_init',
            [$script, 'addInlineScript'],
        ]);
    }

    public function testEnqueue()
    {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->fileSystem = Stub::make(FileSystem::class, [
            'dir' => 'http://my.site/dist/scripts/customizer.js',
        ]);

        $script = new CustomizePreview($jentil);

        $wp_enqueue_script = FunctionMocker::replace('wp_enqueue_script');

        $script->enqueue();

        $wp_enqueue_script->wasCalledOnce();
        $wp_enqueue_script->wasCalledWithOnce([
            'jentil-customize-preview',
            'http://my.site/dist/scripts/customizer.js',
            ['jquery', 'customize-preview'],
            '',
            true
        ]);
    }

    public function testAddInlineJS()
    {
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
                                                    ['name' => 'Related posts']
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
                                                    ['name' => 'Related pages']
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
                                            'name' => 'colophon',
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
                                            'name' => 'date_title',
                                        ]
                                    )],
                                ]
                            ),
                        ],
                    ]
                ),
            ],
        ]);

        $jentil->utilities->shortTags = Stub::makeEmpty(ShortTags::class, [
            'get' => ['{{short_tags}}'],
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

        $add_script = FunctionMocker::replace('wp_add_inline_script');

        $script->addInlineScript();

        $add_script->wasCalledOnce();
        $add_script->wasCalledWithOnce(['jentil-customize-preview']);
    }
}
