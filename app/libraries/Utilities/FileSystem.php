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
     * @var Utilities $utilities Utilities.
     */
    private $utilities;

    /**
     * Theme directory path
     *
     * @since 0.1.0
     * @access private
     *
     * @var string $dirPath Theme directory path.
     */
    private $dirPath;

    /**
     * Theme directory URI
     *
     * @since 0.1.0
     * @access private
     *
     * @var string $dirUrl Theme directory URI.
     */
    private $dirUrl;

    /**
     * Constructor
     *
     * @param Utilities $utilities Utilities.
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
     * Get theme directory
     *
     * @param string $type 'path' or 'url'.
     * @param string $append Filepath to append to URL.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Path or URL.
     */
    public function themeDir(string $type, string $append = ''): string
    {
        return $this->dir($type, $append);
    }

    /**
     * Get JavaScript directory
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
        return $this->dir($type, "/dist/assets/scripts{$append}", $form);
    }

    /**
     * Get CSS directory
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
        return $this->dir($type, "/dist/assets/styles{$append}", $form);
    }

    /**
     * Get partials directory
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
        return $this->dir($type, "/app/partials{$append}", $form);
    }

    /**
     * Get templates directory
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
        return $this->dir($type, "/app/templates{$append}", $form);
    }

    /**
     * Gap
     *
     * If installed as package rather than as a theme,
     * this would give us the location of this package
     * relative to the theme's directory.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string
     */
    public function gap(): string
    {
        $gap = \str_replace(\get_stylesheet_directory(), '', $this->dirPath);

        return \ltrim(\str_replace(\get_template_directory(), '', $gap), '/');
    }

    /**
     * Get directory URL/path
     *
     * @param string $type 'path' or 'url'.
     * @param string $append Filepath to append to URL/path.
     * @param string $form 'relative' or 'absolute'.
     *
     * NOTE: $relative is relative to theme directory.
     *
     * @since 0.1.0
     * @access private
     *
     * @return string Path or URL.
     */
    private function dir(
        string $type,
        string $append = '',
        string $form = ''
    ): string {
        if ('relative' == $form) {
            return \ltrim($append, '/');
        }

        return $this->{'dir'.\ucfirst($type)}.$append;
    }

    /**
     * Theme directory URL
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
     * Theme directory path
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
