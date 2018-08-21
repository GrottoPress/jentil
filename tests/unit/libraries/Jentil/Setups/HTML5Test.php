<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use GrottoPress\Jentil\Utilities\Page;
use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class HTML5Test extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');
        $add_filter = FunctionMocker::replace('add_filter');

        $html5 = new HTML5(Stub::makeEmpty(AbstractTheme::class));

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
        $add_theme_support = FunctionMocker::replace('add_theme_support');

        $html5 = new HTML5(Stub::makeEmpty(AbstractTheme::class));

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
        string $subpage,
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
                $subpage
            ): bool {
                if ($subtype) {
                    return ($page === $type && $subpage === $subtype);
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
