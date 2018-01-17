# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## Unreleased 0.6.0 - 

### Added
- Introduced the `AbstractChildTheme` class
- Added ability to remove customizer components

### Changed
- Undo require search input filled on search submit
- Replaced zero font size inline-block whitespace fix with letter spacing fix
- Redirect `/?s={query}` search URLs to `/search/{query}` if using permalinks
- Using the `grottopress/wordpress-suv` package for this theme.
- Reorganised directory structure of setup classes into groups.
- Autoload script is now included only if exists. (Credit: [@XedinUnknown](https://github.com/XedinUnknown))

### Fixed
- Fixed 404 errors on pagination when using `$wp_rewrite->pagination_base` as pagination key 

## 0.5.0 - 2017-12-16

### Added
- Added development binaries in a new `bin` directory
- Added page builder page templates

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
