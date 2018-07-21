<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\Setups\Menus\AbstractMenu;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class HeaderTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');
        $add_filter = FunctionMocker::replace('add_filter');

        $header = new Header(Stub::makeEmpty(AbstractTheme::class));

        $header->run();

        $add_action->wasCalledTimes(3);

        $add_action->wasCalledWithOnce([
            'jentil_before_header',
            [$header, 'openWrapTag']
        ]);

        $add_action->wasCalledWithOnce([
            'jentil_inside_header',
            [$header, 'renderMenuToggle']
        ]);

        $add_action->wasCalledWithOnce([
            'jentil_inside_header',
            [$header, 'renderMenu']
        ]);

        $add_filter->wasCalledWithOnce([
            'wp_nav_menu',
            [$header, 'renderSearchForm']
        ]);
    }

    public function testRenderMenu()
    {
        $esc_html = FunctionMocker::replace('esc_html__', 'some string');
        $wp_nav_menu = FunctionMocker::replace('wp_nav_menu');
        $sanitize_title = FunctionMocker::replace('sanitize_title');
        $sanitize_text_field = FunctionMocker::replace('sanitize_text_field');

        $header = new Header(Stub::makeEmpty(AbstractTheme::class, [
            'setups' => ['Menus\Primary' => Stub::makeEmpty(
                AbstractMenu::class,
                ['id' => 'primary']
            )],
        ]));

        $header->renderMenu();

        $esc_html->wasCalledOnce();
        $wp_nav_menu->wasCalledOnce();
        $wp_nav_menu->wasCalledWithOnce([[
            'theme_location' => 'primary',
            'fallback_cb' => false,
        ]]);
    }

    public function testRenderSearchForm()
    {
        FunctionMocker::replace('get_search_form', 'search_form');

        $header = new Header(Stub::makeEmpty(AbstractTheme::class, [
            'setups' => ['Menus\Primary' => Stub::makeEmpty(
                AbstractMenu::class,
                ['id' => 'primary']
            )],
        ]));

        $this->assertSame(
            'search_form_menu',
            $header->renderSearchForm(
                '_menu',
                (object)['theme_location' => 'primary']
            )
        );

        $this->assertSame(
            'menu',
            $header->renderSearchForm(
                'menu',
                (object)['theme_location' => 'secondary']
            )
        );
    }
}
