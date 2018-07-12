# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## Unreleased 0.8.0 - 

### Added
- Deactivate theme if minimum required WordPress and PHP versions not met.

### Changed
- Move `isPagelike()` from posts utility to layout utility.
- Explicitly mark layout meta box as compatible with Gutenberg.
- Replace `<?php echo` in templates/partials with `<?=`

## 0.7.1 - 2018-06-24

### Fixed
- `front-page.php` not loading when in `app/templates` directory.

### Changed
- Style search input field as search form wrapper

## 0.7.0 - 2018-06-08

### Added
- `.show` and `.hide` CSS classes
- Aliases for CSS grid classes
- Posts customizer sections for singular posts

### Changed
- Refactor customizer to allow easily adding settings to sections other than this theme's.
- Separate out customizer controls into their own classes
- Live preview page layout changes in the customizer without full page refresh.
- Allow overriding theme mod defaults.
- Convert image size customizer setting to dropdown.
- Sidebar menus (accordion) open current menu pane on page load.
- Reduce number of columns in footer widget area to 3

### Fixed
- Page layout metabox not showing on posts page, if no longer using static front page.
- Posts image margin customizer setting not applied.

### Removed
- WooCommerce: Singular post views
- WooCommerce: Posts customizer sections

## 0.6.0 - 2018-04-13

### Added
- Unit tests
- Related posts
- Set up [travis-ci](https://travis-ci.org)
- `.security.txt`
- `jentil_before_sidebar` and `jentil_after_sidebar` template hooks
- Author avatar on author archive
- WooCommerce support

### Changed
- Undo require search input filled on search submit
- Replaced zero font size inline-block whitespace fix with letter spacing fix
- Redirect `/?s={query}` search URLs to `/search/{query}` if using permalinks
- Use WordPress SUV package for this theme.
- Reorganise directory structure of setup classes into groups.
- Add ability to remove customizer components.
- Ensure layout customizer settings do not show for page builder pages.
- Ensure layout metabox do not show on pages using page builder template
- Replace GrottoPress logo with Jentil's as theme screenshot
- Rename page layout custom field key to '_jentil-layout'
- Prefix asset ids with 'jentil' to avoid potential name collision
- Upgrade font awesome to v5

### Removed
- Redundant doc blocks, comments.
- README section: "Install Jentil without using the `jentil-theme` starter"

### Fixed
- 404 errors on pagination when using `$wp_rewrite->pagination_base` as pagination key

## 0.5.0 - 2017-12-16

### Added
- Development binaries in a new `bin` directory
- Page builder page templates

### Changed
- Overhauled theme to make it seamless with child themes that use Object Oriented design.
- You may now use this theme as package instead of as (parent) theme.
- Various enhancements to menu styles and scripts.
- Live preview page title updates in customizer without preview pane refreshing.

### Removed
- Removed version compatibility checks. Will develop a plugin for that.

## 0.4.0 - 2017-11-17

### Added
- Added sourcemaps for minified CSS and JS
- Added responsive grid layout styles

### Changed
- Used a getter package to get object attributes directly, without calling getter methods.

## 0.2.0 - 2017-10-23

### Changed
- Improved menu JS to close all open submenus before opening current submenu (the accordion effect)
- Used shorter copyright notice for default colophon.
- Renamed SCSS variables to more generic names.
- Removed charset declaration from SCSS as it's already defined in HTML
- Updated `.screen-reader-text` style to match [updates in WordPress 4.9](https://make.wordpress.org/core/2017/10/22/changes-to-the-screen-reader-text-css-class-in-wordpress-4-9/)
- Set width of submit buttons to auto (instead of 100%)

## 0.1.1 - 2017-10-06

### Changed
- Used [GrottoPress](https://www.grottopress.com) logo as theme's screenshot.

### Fixed
- Fixed wrong method name that led to a fatal error.

## 0.1.0 - 2017-10-05

### Added
- Initial public release
