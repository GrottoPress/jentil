<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Loader;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\WordPress\SUV\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class LoaderTest extends TestCase
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
        $loader = new Loader(Stub::makeEmpty(AbstractTheme::class));

        $add_filter = FunctionMocker::replace('add_filter');

        $loader->run();

        $add_filter->wasCalledTimes(\count($this->templates));

        \array_walk(
            $this->templates,
            function (string $template) use ($loader, $add_filter) {
                $add_filter->wasCalledWithOnce([
                    "{$template}_template_hierarchy",
                    [$loader, 'loadTemplates']
                ]);
            }
        );
    }

    /**
     * @param string $relativeDir
     * @param string[] $expected
     *
     * @dataProvider loadTemplatesProvider
     */
    public function testLoadTemplates(string $relativeDir, array $expected)
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
                'relativeDir' => $relativeDir,
            ]
        );

        $loader = new Loader($jentil);

        $this->assertSame(
            $expected,
            $loader->loadTemplates(['template-1', 'template-2'])
        );
    }

    public function loadTemplatesProvider(): array
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
            'index',
            '404',
            'archive',
            'author',
            'category',
            'tag',
            'taxonomy',
            'date',
            'embed',
            'home',
            'front_page',
            'page',
            'paged',
            'search',
            'single',
            'singular',
            'attachment',
        ];
    }
}
