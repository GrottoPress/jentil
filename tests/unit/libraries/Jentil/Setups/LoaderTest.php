<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class LoaderTest extends AbstractTestCase
{
    /**
     * @var array
     */
    private $templates;

    public function _before()
    {
        $this->templates = $this->templates();
    }

    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $loader = new Loader(Stub::makeEmpty(AbstractTheme::class));

        $loader->run();

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$loader, 'loadTemplates']
        ]);
    }

    public function testLoadTemplates()
    {
        $add_filter = FunctionMocker::replace('add_filter');

        $loader = new Loader(Stub::makeEmpty(AbstractTheme::class));

        $loader->loadTemplates();

        $add_filter->wasCalledTimes(\count($this->templates));

        foreach ($this->templates as $template) {
            $add_filter->wasCalledWithOnce([
                "{$template}_template_hierarchy",
                [$loader, 'templateHierarchy']
            ]);
        }
    }

    /**
     * @param string $relative_dir
     * @param string[] $expected
     *
     * @dataProvider templateHierarchyProvider
     */
    public function testTemplateHierarchy(string $relative_dir, array $expected)
    {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->fileSystem = Stub::makeEmpty(
            FileSystem::class,
            [
                'templatesDir' => function (
                    string $type,
                    string $template,
                    string $form
                ): string {
                    return "app/templates{$template}";
                },
                'relativeDir' => $relative_dir,
            ]
        );

        $loader = new Loader($jentil);

        $this->assertSame(
            $expected,
            $loader->templateHierarchy(['template-1', 'template-2'])
        );
    }

    public function templateHierarchyProvider(): array
    {
        return [
            'jentil is parent theme' => ['', [
                'app/templates/template-1',
                'app/templates/template-2',
            ]],
            'jentil is package' => ['vendor/grottopress/jentil', [
                'app/templates/template-1',
                'vendor/grottopress/jentil/app/templates/template-1',
                'app/templates/template-2',
                'vendor/grottopress/jentil/app/templates/template-2',
            ]],
        ];
    }

    private function templates(): array
    {
        return [
            '404',
            'archive',
            'attachment',
            'author',
            'category',
            'date',
            'embed',
            'home',
            'index',
            'frontpage',
            'page',
            'paged',
            'privacypolicy',
            'search',
            'single',
            'singular',
            'tag',
            'taxonomy',
        ];
    }
}
