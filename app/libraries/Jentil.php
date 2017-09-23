<?php

/**
 * Jentil
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil;

use GrottoPress\Jentil\Setup;
use GrottoPress\Jentil\Utilities\Utilities;
use FlorianWolters\Component\Util\Singleton\SingletonTrait;

/**
 * Jentil
 *
 * @since 0.1.0
 */
final class Jentil
{
    /**
     * Import traits
     *
     * @since 0.1.0 Added SingletonTrait.
     */
    use SingletonTrait;

    /**
     * Theme setups
     *
     * @since 0.1.0
     * @access private
     *
     * @var array $setup Setups.
     */
    private $setup = [];

    /**
     * Theme utilities
     *
     * @since 0.1.0
     * @access private
     *
     * @var Utilities $utilities Utilities.
     */
    private $utilities = null;

    /**
     * Theme Name
     *
     * @since 0.1.0
     */
    const NAME = 'Jentil';

    /**
     * Theme website URL
     *
     * @since 0.1.0
     */
    const WEBSITE = 'https://jentil.grottopress.com';

    /**
     * Theme documentation URL
     *
     * @since 0.1.0
     */
    const DOCUMENTATION = 'https://www.grottopress.com/docs/themes/jentil/';

    /**
     * Constructor
     *
     * @since 0.1.0
     * @access protected
     */
    protected function __construct()
    {
        $this->setup['loader'] = new Setup\Loader($this);
        $this->setup['updater'] = new Setup\Updater($this);
        $this->setup['language'] = new Setup\Language($this);
        $this->setup['styles'] = new Setup\Styles($this);
        $this->setup['scripts'] = new Setup\Scripts($this);
        $this->setup['thumbnails'] = new Setup\Thumbnails($this);
        $this->setup['feeds'] = new Setup\Feeds($this);
        $this->setup['html5'] = new Setup\HTML5($this);
        $this->setup['title'] = new Setup\Title($this);
        $this->setup['layout'] = new Setup\Layout($this);
        $this->setup['archives'] = new Setup\Archives($this);
        $this->setup['search'] = new Setup\Search($this);
        $this->setup['menus'] = new Setup\Menus($this);
        $this->setup['breadcrumbs'] = new Setup\Breadcrumbs($this);
        $this->setup['singular'] = new Setup\Singular($this);
        $this->setup['comments'] = new Setup\Comments($this);
        $this->setup['widgets'] = new Setup\Widgets($this);
        $this->setup['colophon'] = new Setup\Colophon($this);
        $this->setup['customizer'] = new Setup\Customizer\Customizer($this);
        $this->setup['metaboxes'] = new Setup\Metaboxes($this);
        $this->setup['mobile'] = new Setup\Mobile($this);
    }

    /**
     * Utilities
     *
     * @since 0.1.0
     * @access public
     *
     * @return Utilities Utilities.
     */
    public function utilities(): Utilities
    {
        if (null === $this->utilities) {
            $this->utilities = new Utilities($this);
        }

        return $this->utilities;
    }

    /**
     * Setup
     *
     * @param string $setup Setup type
     *
     * @since 0.1.0
     * @access public
     *
     * @return AbstractSetup
     */
    public function setup(string $setup): Setup\AbstractSetup
    {
        $setups = $this->setup;

        unset($setups['loader']);
        unset($setups['updater']);

        return $setups[$setup];
    }

    /**
     * Run theme
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        if (!$this->setup) {
            return;
        }

        foreach ($this->setup as $setup) {
            $setup->run();
        }
    }
}
