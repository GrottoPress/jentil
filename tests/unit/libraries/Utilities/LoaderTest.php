<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Utilities;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\Loader;
use GrottoPress\Jentil\Utilities\FileSystem;
use tad\FunctionMocker\FunctionMocker;

class LoaderTest extends AbstractTestCase
{
    public function _before()
    {
        FunctionMocker::replace('locate_template', function (
            array $templates
        ): string {
            return \join(', ', $templates);
        });
    }

    /**
     * @dataProvider loadPartialProvider
     */
    public function testLoadPartial(
        string $slug,
        string $name = '',
        string $relativeDir = '',
        array $expected = []
    ) {
        $loader = new Loader($this->makeUtilities($relativeDir));

        $this->assertSame(
            \join(', ', $expected),
            $loader->loadPartial($slug, $name)
        );
    }

    /**
     * @dataProvider loadTemplateProvider
     */
    public function testLoadTemplate(
        string $slug,
        string $name = '',
        string $relativeDir = '',
        array $expected = []
    ) {
        $loader = new Loader($this->makeUtilities($relativeDir));

        $this->assertSame(
            \join(', ', $expected),
            $loader->loadTemplate($slug, $name)
        );
    }

    /**
     * @dataProvider loadCommentsProvider
     */
    public function testLoadComments(
        string $relativeDir,
        bool $templateDirReadable,
        bool $stylesheetDirReadable,
        string $expected
    ) {
        FunctionMocker::replace('comments_template', function (
            string $file
        ): string {
            return $file;
        });

        FunctionMocker::replace('get_template_directory', '/var/www/jentil');
        FunctionMocker::replace('get_stylesheet_directory', '/var/www/mytheme');

        FunctionMocker::replace('is_readable', function (
            string $file
        ) use ($templateDirReadable, $stylesheetDirReadable): bool {
            if ('/var/www/jentil/comments.php' === $file) {
                return $templateDirReadable;
            }

            return $stylesheetDirReadable;
        });

        $loader = new Loader($this->makeUtilities($relativeDir));

        $this->assertSame($expected, $loader->loadComments());
    }

    public function loadPartialProvider(): array
    {
        return [
            'slug without name, jentil is theme' => [
                'header',
                '',
                '',
                ['app/partials/header.php'],
            ],
            'slug with name, jentil is theme' => [
                'single',
                'book',
                '',
                ['app/partials/single-book.php', 'app/partials/single.php'],
            ],
            'slug without name, jentil is package' => [
                'category',
                '',
                'vendor/grottopress/jentil',
                [
                    'app/partials/category.php',
                    'vendor/grottopress/jentil/app/partials/category.php',
                ],
            ],
            'slug with name, jentil is package' => [
                'footer',
                'mini',
                'vendor/grottopress/jentil',
                [
                    'app/partials/footer-mini.php',
                    'vendor/grottopress/jentil/app/partials/footer-mini.php',
                    'app/partials/footer.php',
                    'vendor/grottopress/jentil/app/partials/footer.php',
                ],
            ],
        ];
    }

    public function loadTemplateProvider(): array
    {
        return [
            'slug without name, jentil is theme' => [
                'header',
                '',
                '',
                ['app/templates/header.php'],
            ],
            'slug with name, jentil is theme' => [
                'single',
                'book',
                '',
                ['app/templates/single-book.php', 'app/templates/single.php'],
            ],
            'slug without name, jentil is package' => [
                'category',
                '',
                'vendor/grottopress/jentil',
                [
                    'app/templates/category.php', 'vendor/grottopress/jentil/app/templates/category.php',
                ],
            ],
            'slug with name, jentil is package' => [
                'footer',
                'mini',
                'vendor/grottopress/jentil',
                [
                    'app/templates/footer-mini.php',
                    'vendor/grottopress/jentil/app/templates/footer-mini.php',
                    'app/templates/footer.php',
                    'vendor/grottopress/jentil/app/templates/footer.php',
                ],
            ],
        ];
    }

    public function loadCommentsProvider(): array
    {
        return [
            'jentil is theme' => [
                '',
                true,
                true,
                '/app/partials/comments.php',
            ],
            'jentil is package' => [
                'vendor/jentil',
                false,
                false,
                '/vendor/jentil/app/partials/comments.php',
            ],
        ];
    }

    private function makeUtilities(string $relativeDir): Utilities
    {
        $utilities = Stub::makeEmpty(Utilities::class);
        $utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'partialsDir' => function (
                string $type,
                string $cont,
                string $form
            ): string {
                return "app/partials{$cont}";
            },
            'templatesDir' => function (
                string $type,
                string $cont,
                string $form
            ): string {
                return "app/templates{$cont}";
            },
            'relativeDir' => $relativeDir,
        ]);

        return $utilities;
    }
}
