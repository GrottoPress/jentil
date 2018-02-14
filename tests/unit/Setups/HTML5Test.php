<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\HTML5;
use GrottoPress\Jentil\Utilities\Page\Page;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\WordPress\SUV\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class HTML5Test extends TestCase
{
    public function testRun()
    {
        $html5 = new HTML5(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');
        $add_filter = FunctionMocker::replace('add_filter');

        $html5->run();

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$html5, 'addSupport']
        ]);

        $add_filter->wasCalledTimes(2);
        $add_filter->wasCalledWithOnce([
            'language_attributes',
            [$html5, 'addMicrodata']
        ]);
        $add_filter->wasCalledWithOnce([
            'wp_kses_allowed_html',
            [$html5, 'ksesWhitelist'],
            10,
            2
        ]);
    }

    public function testAddSupport()
    {
        $html5 = new HTML5(Stub::makeEmpty(AbstractTheme::class));

        $add_theme_support = FunctionMocker::replace('add_theme_support');

        $html5->addSupport();

        $add_theme_support->wasCalledOnce();
        $add_theme_support->wasCalledWithOnce([
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'widgets',
            ],
        ]);
    }

    /**
     * @param string $page Page to check
     * @param string $itemtype Schema.org itemtype
     *
     * @dataProvider addMicrodataProvider
     */
    public function testAddMicrodata(
        string $page,
        string $subPage,
        string $itemtype
    ) {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->page = Stub::makeEmpty(Page::class, [
            'is' => function (
                string $type,
                string $subtype = null
            ) use (
                $page,
                $subPage
            ): bool {
                if ($subtype) {
                    return ($page === $type && $subPage === $subtype);
                }

                return ($page === $type);
            }
        ]);

        $html5 = new HTML5($jentil);

        $expected = "<html itemscope itemtype=\"http://schema.org/{$itemtype}\"";
        $actual = $html5->addMicrodata('<html');

        $this->assertSame($expected, $actual);
    }

    /**
     * @param array $in Existing tags
     * @param string $out Output tag to check
     *
     * @dataProvider ksesWhitelistProvider
     */
    public function testKsesWhitelist(string $out, array $in = [])
    {
        $html5 = new HTML5(Stub::makeEmpty(AbstractTheme::class));

        $allowed = $html5->ksesWhitelist($in, '');

        $this->assertTrue($allowed[$out]['itemprop']);
        $this->assertTrue($allowed[$out]['itemscope']);
        $this->assertTrue($allowed[$out]['itemtype']);
        $this->assertTrue($allowed[$out]['itemref']);
        $this->assertTrue($allowed[$out]['itemid']);
    }

    public function addMicrodataProvider(): array
    {
        return [
            'home (posts archive)' => ['home', '', 'Blog'],
            'author archive' => ['author', '', 'ProfilePage'],
            'single post' => ['singular', 'post', 'BlogPosting'],
            'search archive' => ['search', '', 'SearchResultsPage'],
            'attachment' => ['attachment', '', 'MediaObject'],
            'all other pages' => ['non-existent', '', 'WebPage'],
        ];
    }

    public function ksesWhitelistProvider(): array
    {
        return [
            'html5 attributes on existing tags' => [
                'a',
                ['a' => ['href' => true]]
            ],
            'html5 attributes on `span` tags' => ['span'],
        ];
    }
}
