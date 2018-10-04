<?php
declare (strict_types = 1);

namespace GrottoPress;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\Setups;
use GrottoPress\Jentil\Utilities;

final class Jentil extends AbstractTheme
{
    /**
     * @var Utilities
     */
    private $utilities;

    /**
     * @var string[string]
     */
    private $meta;

    protected function __construct()
    {
        $this->setUpMisc();
        $this->setUpTranslations();
        $this->setUpMetaBoxes();
        $this->setUpThumbnails();
        $this->setUpStyles();
        $this->setUpScripts();
        $this->setUpMenus();
        $this->setUpPostTypeTemplates();
        $this->setUpSidebars();
        $this->setUpViews();
        $this->setUpSupports();
    }

    protected function getUtilities(): Utilities
    {
        $this->utilities = $this->utilities ?: new Utilities($this);

        return $this->utilities;
    }

    /**
     * @return Setups\AbstractSetup[string]
     */
    protected function getSetups(): array
    {
        $setups = $this->setups;

        unset($setups['Loader']);

        return $setups;
    }

    /**
     * @return string[string]
     */
    protected function getMeta(): array
    {
        $this->meta = $this->meta ?: $this->meta();

        return $this->meta;
    }

    /**
     * Checks if installed as 'theme' or as 'package'
     */
    public function is(string $mode): bool
    {
        $rel_dir = $this->getUtilities()->fileSystem->relativeDir();

        return (
            ('package' === $mode && $rel_dir) ||
                ('theme' === $mode && !$rel_dir)
        );
    }

    private function setUpMisc()
    {
        $this->setups['Loader'] = new Setups\Loader($this);
        $this->setups['Customizer'] = new Setups\Customizer($this);
        $this->setups['FeaturedImage'] = new Setups\FeaturedImage($this);
        $this->setups['Feed'] = new Setups\Feed($this);
        $this->setups['HTML5'] = new Setups\HTML5($this);
        $this->setups['TitleTag'] = new Setups\TitleTag($this);
        $this->setups['Layout'] = new Setups\Layout($this);
        $this->setups['Mobile'] = new Setups\Mobile($this);
    }

    private function setUpTranslations()
    {
        $this->setups['Translations\Breadcrumbs'] =
            new Setups\Translations\Breadcrumbs($this);
        $this->setups['Translations\Field'] =
            new Setups\Translations\Field($this);
        $this->setups['Translations\Page'] =
            new Setups\Translations\Page($this);
        $this->setups['Translations\Posts'] =
            new Setups\Translations\Posts($this);
        $this->setups['Translations\Core'] =
            new Setups\Translations\Core($this);
    }

    private function setUpMetaBoxes()
    {
        $this->setups['MetaBoxes\Layout'] = new Setups\MetaBoxes\Layout($this);
    }

    private function setUpThumbnails()
    {
        $this->setups['Thumbnails\Nano'] = new Setups\Thumbnails\Nano($this);
        $this->setups['Thumbnails\Micro'] = new Setups\Thumbnails\Micro($this);
        $this->setups['Thumbnails\Mini'] = new Setups\Thumbnails\Mini($this);
    }

    private function setUpStyles()
    {
        $this->setups['Styles\Normalize'] = new Setups\Styles\Normalize($this);
        $this->setups['Styles\Posts'] = new Setups\Styles\Posts($this);
        $this->setups['Styles\Core'] = new Setups\Styles\Core($this);
        $this->setups['Styles\Gutenberg'] = new Setups\Styles\Gutenberg($this);
    }

    private function setUpScripts()
    {
        $this->setups['Scripts\FontAwesome'] =
            new Setups\Scripts\FontAwesome($this);
        $this->setups['Scripts\FontAwesomeShim'] =
            new Setups\Scripts\FontAwesomeShim($this);
        $this->setups['Scripts\WhatInput'] =
            new Setups\Scripts\WhatInput($this);
        $this->setups['Scripts\CommentReply'] =
            new Setups\Scripts\CommentReply($this);
        $this->setups['Scripts\Core'] = new Setups\Scripts\Core($this);
        $this->setups['Scripts\Menu'] = new Setups\Scripts\Menu($this);
        $this->setups['Scripts\CustomizePreview'] =
            new Setups\Scripts\CustomizePreview($this);
    }

    private function setUpMenus()
    {
        $this->setups['Menus\Primary'] = new Setups\Menus\Primary($this);
    }

    private function setUpPostTypeTemplates()
    {
        $this->setups['PostTypeTemplates\PageBuilder'] =
            new Setups\PostTypeTemplates\PageBuilder($this);
        $this->setups['PostTypeTemplates\PageBuilderBlank'] =
            new Setups\PostTypeTemplates\PageBuilderBlank($this);
    }

    private function setUpSidebars()
    {
        $this->setups['Sidebars\Primary'] =
            new Setups\Sidebars\Primary($this);
        $this->setups['Sidebars\Secondary'] =
            new Setups\Sidebars\Secondary($this);
        $this->setups['Sidebars\Footer'] = new Setups\Sidebars\Footer($this);
    }

    private function setUpViews()
    {
        $this->setups['Views\SearchForm'] = new Setups\Views\SearchForm($this);
        $this->setups['Views\Header'] = new Setups\Views\Header($this);
        $this->setups['Views\Breadcrumbs'] =
            new Setups\Views\Breadcrumbs($this);
        $this->setups['Views\Archive'] = new Setups\Views\Archive($this);
        $this->setups['Views\Author'] = new Setups\Views\Author($this);
        $this->setups['Views\Search'] = new Setups\Views\Search($this);
        $this->setups['Views\Singular'] = new Setups\Views\Singular($this);
        $this->setups['Views\Attachment'] = new Setups\Views\Attachment($this);
        $this->setups['Views\Sidebar'] = new Setups\Views\Sidebar($this);
        $this->setups['Views\Footer'] = new Setups\Views\Footer($this);
    }

    private function setUpSupports()
    {
        $this->setups['Supports\WooCommerce'] =
            new Setups\Supports\WooCommerce($this);
    }

    /**
     * @return string[string]
     */
    private function meta(): array
    {
        $meta = \array_map('sanitize_text_field', \get_file_data(
            $this->getUtilities()->fileSystem->dir('path', '/style.css'),
            [
                'name' => 'Theme Name',
                'theme_uri' => 'Theme URI',
                'description' => 'Description',
                'author' => 'Author',
                'author_uri' => 'Author URI',
                'version' => 'Version',
                'license' => 'License',
                'license_uri' => 'License URI',
                'tags' => 'Tags',
                'text_domain' => 'Text Domain',
                'domain_path' => 'Domain Path',
                'documents_uri' => 'Documents URI',
            ],
            'theme'
        ));

        $meta['slug'] = \sanitize_title($meta['name']);

        return $meta;
    }
}
