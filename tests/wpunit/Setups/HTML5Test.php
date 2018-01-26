<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use Codeception\TestCase\WPTestCase;
use GrottoPress\WordPress\Page\Page;
use GrottoPress\WordPress\SUV\AbstractTheme;

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
            [$this->html5, 'addSupport']
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
        $page = $this->createMock(Page::class);
        $page->method('is')->will($this->returnValueMap([
            ['admin', false],
            ['login', false],
            ['register', false],
            ['home', true]
        ]));

        $utilities = new class {};
        $utilities->page = $page;

        $jentil = $this->createMock(AbstractTheme::class);
        $jentil->utilities = $utilities;

        $html5 = new HTML5($jentil);

        $expected = '<html itemscope itemtype="http://schema.org/Blog"';
        $actual = $html5->addMicrodata('<html');

        $this->assertSame($expected, $actual);
    }

    public function testAddMicrodataWorksOnAuthorArchive()
    {
        $page = $this->createMock(Page::class);
        $page->method('is')->will($this->returnValueMap([
            ['admin', false],
            ['login', false],
            ['register', false],
            ['home', false],
            ['author', true]
        ]));

        $utilities = new class {};
        $utilities->page = $page;

        $jentil = $this->createMock(AbstractTheme::class);
        $jentil->utilities = $utilities;

        $html5 = new HTML5($jentil);

        $expected = '<html itemscope itemtype="http://schema.org/ProfilePage"';
        $actual = $html5->addMicrodata('<html');

        $this->assertSame($expected, $actual);
    }

    public function testAddMicrodataWorksOnSearchArchive()
    {
        $page = $this->createMock(Page::class);
        $page->method('is')->will($this->returnValueMap([
            ['admin', false],
            ['login', false],
            ['register', false],
            ['home', false],
            ['author', false],
            ['search', true]
        ]));

        $utilities = new class {};
        $utilities->page = $page;

        $jentil = $this->createMock(AbstractTheme::class);
        $jentil->utilities = $utilities;

        $html5 = new HTML5($jentil);

        $expected = '<html itemscope itemtype="http://schema.org/SearchResultsPage"';
        $actual = $html5->addMicrodata('<html');

        $this->assertSame($expected, $actual);
    }

    public function testAddMicrodataWorksOnSinglePost()
    {
        $page = $this->createMock(Page::class);
        $page->method('is')->will($this->returnValueMap([
            ['admin', false],
            ['login', false],
            ['register', false],
            ['home', false],
            ['author', false],
            ['search', false],
            ['singular', 'post', true]
        ]));

        $utilities = new class {};
        $utilities->page = $page;

        $jentil = $this->createMock(AbstractTheme::class);
        $jentil->utilities = $utilities;

        $html5 = new HTML5($jentil);

        $expected = '<html itemscope itemtype="http://schema.org/BlogPosting"';
        $actual = $html5->addMicrodata('<html');

        $this->assertSame($expected, $actual);
    }
    
    public function testAddMicrodataWorksOnAllOtherPages()
    {
        $page = $this->createMock(Page::class);
        $page->method('is')->will($this->returnValueMap([
            ['admin', false],
            ['login', false],
            ['register', false],
            ['home', false],
            ['author', false],
            ['search', false],
            ['singular', 'post', false]
        ]));

        $utilities = new class {};
        $utilities->page = $page;

        $jentil = $this->createMock(AbstractTheme::class);
        $jentil->utilities = $utilities;

        $html5 = new HTML5($jentil);

        $expected = '<html itemscope itemtype="http://schema.org/WebPage"';
        $actual = $html5->addMicrodata('<html');

        $this->assertSame($expected, $actual);
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
        $tags = [
            'a' => ['href' => true]
        ];

        $html5 = new HTML5($this->createMock(AbstractTheme::class));

        $allowed = $html5->ksesWhitelist($tags, '');

        $this->assertTrue($allowed['a']['href']);
        $this->assertTrue($allowed['a']['itemprop']);
        $this->assertTrue($allowed['a']['itemscope']);
        $this->assertTrue($allowed['a']['itemtype']);
        $this->assertTrue($allowed['a']['itemref']);
        $this->assertTrue($allowed['a']['itemid']);
    }

    public function testKsesWhitelistAddsNewSpanTagWithHTML5Attributes()
    {
        $html5 = new HTML5($this->createMock(AbstractTheme::class));

        $allowed = $html5->ksesWhitelist([], '');

        $this->assertTrue($allowed['span']['itemprop']);
        $this->assertTrue($allowed['span']['itemscope']);
        $this->assertTrue($allowed['span']['itemtype']);
        $this->assertTrue($allowed['span']['itemref']);
        $this->assertTrue($allowed['span']['itemid']);
    }
}
