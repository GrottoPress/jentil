<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
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
        string $relative_dir = '',
        array $expected = []
    ) {
        $do_action = FunctionMocker::replace('do_action');

        $loader = new Loader($this->makeUtilities($relative_dir));

        $this->assertSame(
            \join(', ', $expected),
            $loader->loadPartial($slug, $name)
        );

        $do_action->wasCalledOnce();
    }

    /**
     * @dataProvider loadTemplateProvider
     */
    public function testLoadTemplate(
        string $slug,
        string $name = '',
        string $relative_dir = '',
        array $expected = []
    ) {
        $loader = new Loader($this->makeUtilities($relative_dir));

        $this->assertSame(
            \join(', ', $expected),
            $loader->loadTemplate($slug, $name)
        );
    }

    /**
     * @dataProvider loadCommentsProvider
     */
    public function testLoadComments(
        string $relative_dir,
        bool $template_dir_readable,
        bool $stylesheet_dir_readable,
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
        ) use (
            $template_dir_readable,
            $stylesheet_dir_readable
        ): bool {
            if ('/var/www/jentil/comments.php' === $file) {
                return $template_dir_readable;
            }

            return $stylesheet_dir_readable;
        });

        $loader = new Loader($this->makeUtilities($relative_dir));

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

    private function makeUtilities(string $relative_dir): Utilities
    {
        $utilities = Stub::makeEmpty(Utilities::class);
        $utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'partialsDir' => function (
                string $type,
                string $append,
                string $form
            ): string {
                return "app/partials{$append}";
            },
            'templatesDir' => function (
                string $type,
                string $append,
                string $form
            ): string {
                return "app/templates{$append}";
            },
            'relativeDir' => $relative_dir,
        ]);

        return $utilities;
    }
}
