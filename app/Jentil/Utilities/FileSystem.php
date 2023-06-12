<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use GrottoPress\Jentil\Utilities;

class FileSystem
{
    /**
     * @var Utilities
     */
    private $utilities;

    /**
     * @var string
     */
    private $dirPath;

    /**
     * @var string
     */
    private $dirUrl;

    public function __construct(Utilities $utilities)
    {
        $this->utilities = $utilities;

        $this->dirPath = $this->dirPath();
        $this->dirUrl = $this->dirUrl();
    }

    /**
     * Get Jentil directory
     *
     * @param string $type 'path' or 'url'.
     */
    public function dir(string $type, string $append = ''): string
    {
        return $this->_dir($type, $append);
    }

    /**
     * Get Jentil partials directory
     *
     * @param string $type 'path' or 'url'.
     * @param string $form 'relative' or 'absolute'.
     */
    public function partialsDir(
        string $type,
        string $append = '',
        string $form = ''
    ): string {
        return $this->_dir($type, "/partials{$append}", $form);
    }

    /**
     * Get Jentil templates directory
     *
     * @param string $type 'path' or 'url'.
     * @param string $form 'relative' or 'absolute'.
     */
    public function templatesDir(
        string $type,
        string $append = '',
        string $form = ''
    ): string {
        return $this->_dir($type, "/templates{$append}", $form);
    }

    /**
     * Path of Jentil relative to theme's directory.
     *
     * @return string Path. Empty if Jentil is theme.
     */
    public function relativeDir(): string
    {
        return \ltrim(
            \str_replace($this->themeDir('path'), '', $this->dirPath),
            '/'
        );
    }

    /**
     * Get directory of theme under which Jentil is installed.
     *
     * @param string $type 'url' or 'path'
     *
     * @return string Path. Same as $this->dir() if Jentil is theme.
     */
    public function themeDir(string $type, string $append = ''): string
    {
        $stylesheet = $type === 'path'
            ? \get_stylesheet_directory()
            : \get_stylesheet_directory_uri();

        if (0 === strpos($this->{'dir'.\ucfirst($type)}, $stylesheet)) {
            return $stylesheet.$append;
        }

        $template = $type === 'path'
            ? \get_template_directory()
            : \get_template_directory_uri();

        return $template.$append;
    }

    /**
     * Helper to get Jentil directory URL/path
     *
     * @param string $type 'path' or 'url'.
     * @param string $form 'relative' (to Jentil directory) or 'absolute'.
     */
    private function _dir(
        string $type,
        string $append = '',
        string $form = ''
    ): string {
        if ('relative' === $form) {
            return \ltrim($append, '/');
        }

        return $this->{'dir'.\ucfirst($type)}.$append;
    }

    /**
     * Jentil directory URL
     */
    private function dirUrl(): string
    {
        $path = \str_replace(\get_theme_root(), '', $this->dirPath);

        return (\get_theme_root_uri().$path);
    }

    /**
     * Jentil directory path
     */
    private function dirPath(): string
    {
        return \dirname(__FILE__, 4);
    }
}
