<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Supports;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\Setups\Customizer\AbstractCustomizer;
use GrottoPress\Jentil\Setups\Customizer\AbstractPanel;
use GrottoPress\Jentil\Setups\Customizer\AbstractSection;
use GrottoPress\Jentil\Setups\Customizer\AbstractSetting;
use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\Utilities\Page;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class WooCommerceTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $woo_commerce = new WooCommerce(Stub::makeEmpty(AbstractTheme::class));

        $woo_commerce->run();

        $add_action->wasCalledTimes(3);

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$woo_commerce, 'loadComments']
        ]);

        $add_action->wasCalledWithOnce([
            'customize_register',
            [$woo_commerce, 'removeCustomizerItems'],
            20
        ]);

        $add_action->wasCalledWithOnce([
            'wp',
            [$woo_commerce, 'removeSingularViews']
        ]);
    }

    public function testLoadComments()
    {
        $this->getMockBuilder('WC_Template_Loader')->getMock();

        $add_filter = FunctionMocker::replace('add_filter');

        $woo_commerce = new WooCommerce(Stub::makeEmpty(AbstractTheme::class));

        $woo_commerce->loadComments();

        $add_filter->wasCalledOnce();
        $add_filter->wasCalledWithOnce([
            'comments_template',
            ['WC_Template_Loader', 'comments_template_loader']
        ]);
    }

    public function testRemoveCustomizerItems()
    {
        $this->getMockBuilder('WooCommerce')->getMock();

        $wp_customizer = $this->getMockBuilder('WP_Customize_Manager')
            ->getMock();

        FunctionMocker::replace('get_option');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'setups' => ['Customizer' => Stub::makeEmpty(
                AbstractCustomizer::class,
                [
                    'panels' => ['Posts' => Stub::makeEmpty(
                        AbstractPanel::class,
                        ['sections' => [
                            'Taxonomy_product_cat' => Stub::makeEmpty(
                                AbstractSection::class,
                                ['remove' => true]
                            ),
                            'Taxonomy_product_tag' => Stub::makeEmpty(
                                AbstractSection::class,
                                ['remove' => true]
                            ),
                            'Related_product' => Stub::makeEmpty(
                                AbstractSection::class,
                                ['remove' => true]
                            ),
                            'Singular_product' => Stub::makeEmpty(
                                AbstractSection::class,
                                ['remove' => true]
                            ),
                            'Related_page' => Stub::makeEmpty(
                                AbstractSection::class,
                                ['get' => function () {
                                    return new class {
                                        public $active_callback = true;
                                    };
                                }]
                            ),
                            'Singular_page' => Stub::makeEmpty(
                                AbstractSection::class,
                                ['get' => function () {
                                    return new class {
                                        public $active_callback = true;
                                    };
                                }]
                            ),
                        ]]
                    )],
                    'sections' => ['Title' => Stub::makeEmpty(
                        AbstractSection::class,
                        ['settings' => [
                            'Taxonomy_product_cat' => Stub::makeEmpty(
                                AbstractSetting::class,
                                ['remove' => true]
                            ),
                            'Taxonomy_product_tag' => Stub::makeEmpty(
                                AbstractSetting::class,
                                ['remove' => true]
                            ),
                        ]]
                    )],
                ]
            )]
        ]);

        $woo_commerce = new WooCommerce($jentil);

        $taxes = ['product_tag', 'product_cat'];

        foreach ($taxes as $tax) {
            $jentil->setups['Customizer']
                ->panels['Posts']->sections["Taxonomy_{$tax}"]
                ->expects($this->once())->method('remove')
                ->with($this->equalTo($wp_customizer));

            $jentil->setups['Customizer']
                ->sections['Title']->settings["Taxonomy_{$tax}"]
                ->expects($this->once())->method('remove')
                ->with($this->equalTo($wp_customizer));
        }

        $jentil->setups['Customizer']
            ->panels['Posts']->sections['Related_product']
            ->expects($this->once())->method('remove')
            ->with($this->equalTo($wp_customizer));

        $jentil->setups['Customizer']
            ->panels['Posts']->sections['Singular_product']
            ->expects($this->once())->method('remove')
            ->with($this->equalTo($wp_customizer));

        $woo_commerce->removeCustomizerItems($wp_customizer);
    }

    public function testRemoveSingularViews()
    {
        $this->getMockBuilder('WooCommerce')->getMock();

        $remove_action = FunctionMocker::replace('remove_action');
        $get_option = FunctionMocker::replace('get_option', 111);

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'setups' => ['Views\Singular' => true],
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->page = Stub::makeEmpty(Page::class, [
            'is' => function (string $type, string $subtype): bool {
                return ($type === 'singular' && $subtype === 'product') ||
                    ($type === 'page' && $subtype === 111);
            }
        ]);

        $woo_commerce = new WooCommerce($jentil);

        $woo_commerce->removeSingularViews();

        $remove_action->wasCalledTimes(4);

        $remove_action->wasCalledWithOnce([
            'jentil_before_title',
            [$jentil->setups['Views\Singular'], 'renderPostsBeforeTitle'],
        ]);

        $remove_action->wasCalledWithOnce([
            'jentil_after_title',
            [$jentil->setups['Views\Singular'], 'renderPostsAfterTitle'],
        ]);

        $remove_action->wasCalledWithOnce([
            'jentil_after_content',
            [$jentil->setups['Views\Singular'], 'renderPostsAfterContent'],
        ]);

        $remove_action->wasCalledWithOnce([
            'jentil_after_content',
            [$jentil->setups['Views\Singular'], 'renderRelatedPosts'],
        ]);
    }
}
