<?php

/**
 * File System
 *
 * @package GrottoPress\Jentil\Utilities
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

/**
 * File System
 *
 * @since 0.1.0
 */
final class FileSystem
{
    /**
     * Utilities
     *
     * @since 0.1.0
     * @access private
     *
     * @var Utilities
     */
    private $utilities;

    /**
     * Jentil directory path
     *
     * @since 0.1.0
     * @access private
     *
     * @var string
     */
    private $dirPath;

    /**
     * Jentil directory URI
     *
     * @since 0.1.0
     * @access private
     *
     * @var string
     */
    private $dirUrl;

    /**
     * Constructor
     *
     * @param Utilities $utilities
     *
     * @since 0.1.0
     * @access public
     */
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
     * @param string $append Filepath to append to URL.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function dir(string $type, string $append = ''): string
    {
        return $this->getDir($type, $append);
    }

    /**
     * Get Jentil JavaScript directory
     *
     * @param string $type 'path' or 'url'.
     * @param string $append Filepath to append to URL.
     * @param string $form 'relative' or 'absolute'.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function scriptsDir(
        string $type,
        string $append = '',
        string $form = ''
    ): string {
        return $this->getDir($type, "/dist/scripts{$append}", $form);
    }

    /**
     * Get Jentil CSS directory
     *
     * @param string $type 'path' or 'url'.
     * @param string $append Filepath to append to URL.
     * @param string $form 'relative' or 'absolute'.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function stylesDir(
        string $type,
        string $append = '',
        string $form = ''
    ): string {
        return $this->getDir($type, "/dist/styles{$append}", $form);
    }

    /**
     * Get Jentil partials directory
     *
     * @param string $type 'path' or 'url'.
     * @param string $append Filepath to append to URL.
     * @param string $form 'relative' or 'absolute'.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function partialsDir(
        string $type,
        string $append = '',
        string $form = ''
    ): string {
        return $this->getDir($type, "/app/partials{$append}", $form);
    }

    /**
     * Get Jentil templates directory
     *
     * @param string $type 'path' or 'url'.
     * @param string $append Filepath to append to URL.
     * @param string $form 'relative' or 'absolute'.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function templatesDir(
        string $type,
        string $append = '',
        string $form = ''
    ): string {
        return $this->getDir($type, "/app/templates{$append}", $form);
    }

    /**
     * Path of Jentil relative to theme's directory.
     *
     * @since 0.1.0
     * @access public
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
     * @param string $append
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
     * @param string $append Filepath to append to URL/path.
     * @param string $form 'relative' (to Jentil directory) or 'absolute'.
     *
     * @since 0.1.0
     * @access private
     *
     * @return string Path or URL.
     */
    private function getDir(
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
     *
     * @since 0.1.0
     * @access private
     *
     * @return string
     */
    private function dirUrl(): string
    {
        $path = \str_replace(\get_theme_root(), '', $this->dirPath);

        return (\get_theme_root_uri().$path);
    }

    /**
     * Jentil directory path
     *
     * @since 0.1.0
     * @access private
     *
     * @return string
     */
    private function dirPath(): string
    {
        return \dirname(__FILE__, 4);
    }
}
