<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use Codeception\TestCase\WPTestCase;
use GrottoPress\WordPress\Page\Page;
use GrottoPress\WordPress\SUV\AbstractTheme;
use Codeception\Util\Stub;

class HTML5Test extends WPTestCase
{
    private $html5;

    public function _before()
    {
        $this->html5 = \Jentil()->setups['HTML5'];
        $this->html5->run();
    }

    public function testHTML5SupportAdded()
    {
        $this->assertSame(10, \has_action(
            'after_setup_theme',
            [$this->html5, 'addSuppor']
        ));
    }

    public function testMicrodataAddedToHtmlTag()
    {
        $this->assertSame(10, \has_filter(
            'language_attributes',
            [$this->html5, 'addMicrodata']
        ));
    }

    public function testAddMicrodataWorksOnHome()
    {
        $this->assertMicrodataValidFor('home', 'Blog');
    }

    public function testAddMicrodataWorksOnAuthorArchive()
    {
        $this->assertMicrodataValidFor('author', 'ProfilePage');
    }

    public function testAddMicrodataWorksOnSearchArchive()
    {
        $this->assertMicrodataValidFor('search', 'SearchResultsPage');
    }

    public function testAddMicrodataWorksOnSinglePost()
    {
        $this->assertMicrodataValidFor('single', 'BlogPosting');
    }
    
    public function testAddMicrodataWorksOnAllOtherPages()
    {
        $this->assertMicrodataValidFor('nonExistent', 'WebPage');
    }

    public function testHTML5AttributesWhitelistedInKses()
    {
        $this->assertSame(10, \has_filter(
            'wp_kses_allowed_html',
            [$this->html5, 'ksesWhitelist']
        ));
    }

    public function testKsesWhitelistAddsHTML5AttributesToExistingTags()
    {
        $this->assertHTML5AttributesExist('a', ['a' => ['href' => true]]);
    }

    public function testKsesWhitelistAddsNewSpanTagWithHTML5Attributes()
    {
        $this->assertHTML5AttributesExist('span');
    }

    /**
     * @param string $page Page to check
     * @param string $itemtype Schema.org itemtype
     */
    private function assertMicrodataValidFor(string $page, string $itemtype)
    {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => new class($page) {
                public $page;

                public function __construct($page)
                {
                    $this->page = Stub::makeEmpty(Page::class, [
                        'is' => function (string $type) use ($page): bool {
                            if ($page === $type) {
                                return true;
                            }
            
                            return false;
                        }
                    ]);
                }
            }
        ]);

        $html5 = new HTML5($jentil);

        $expected = "<html itemscope itemtype=\"http://schema.org/{$itemtype}\"";
        $actual = $html5->addMicrodata('<html');

        $this->assertSame($expected, $actual);
    }

    /**
     * @param array $in Existing tags passed in
     * @param string $out Output tag to check
     */
    private function assertHTML5AttributesExist(string $out, array $in = [])
    {
        $html5 = new HTML5($this->createMock(AbstractTheme::class));

        $allowed = $html5->ksesWhitelist($in, '');

        $this->assertTrue($allowed[$out]['itemprop']);
        $this->assertTrue($allowed[$out]['itemscope']);
        $this->assertTrue($allowed[$out]['itemtype']);
        $this->assertTrue($allowed[$out]['itemref']);
        $this->assertTrue($allowed[$out]['itemid']);
    }
}
