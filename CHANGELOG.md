# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html)

## [0.12.1] - 2023-04-21

### Changed
- Change theme screenshot

### Fixed
- Fix wrong paths in translations template

## [0.12.0] - 2023-04-21

### Changed
- Replace SCSS with [Tailwind CSS](https://tailwindcss.com)
- Replace gulp with [Laravel Mix](https://laravel-mix.com)

## [0.11.3] - 2023-04-19

### Changed
- Replace Travis CI with GitHub actions
- Upgrade dependencies

## [0.11.2] - 2020-03-26

### Changed
- Update `grottopress/wordpress-suv` to version 0.7
- Update `lucatume/wp-browser` package to version 2.2

### Fixed
- Remove top margin from sidebars on large screens

## [0.11.1] - 2020-02-14

### Fixed
- Fix theme deleted in container during WordPress installation

## [0.11.0] - 2020-02-08

### Added
- Add support for PHP 7.4
- Set up JS module bundling with [rollup js](https://rollupjs.org)
- Add `Procfile`

### Changed
- Remove `theme_` prefix from theme meta keys

### Removed
- Remove HTML microdata

## 0.10.2 - 2019-04-30

### Added
- Set up automated builds for docker cloud
- Introduce method to get a given theme's data from its `style.css`

## 0.10.1 - 2019-04-22

### Fixed
- Minify all vendor assets for distribution

## 0.10.0 - 2019-04-18

### Added
- Add `Dockerfile`
- Add `.gitattributes`
- Add `tsconfig.json`. Move typescript config from `gulpfile.js`.
- Add PHP `7.3` to travis-ci build matrix
- Add jQuery version 3 (with Migrate plugin)
- Add support for [`wp_body_open`](https://make.wordpress.org/themes/2019/03/29/addition-of-new-wp_body_open-hook/) hook, introduced in WordPress 5.2
- Set up [browser-sync](https://www.browsersync.io)

### Changed
- Replace hard-coded domain path in core translation setup with one grabbed from `style.css`
- Upgrade gulp to version 4
- Update scripts to use typescript namespaces and classes
- Move sourcemaps into their own `.map` files.
- Update gallery grid break points to ensure bigger thumbnails

### Removed
- Remove jQuery version shipped with WordPress core

### Fixed
- Fix editor (Gutenberg) styling not applied

## 0.9.2 - 2018-10-08

### Changed
- Update vendor paths after package upgrades

## 0.9.1 - 2018-10-04

### Changed
- Rename `LICENSE.md` to `LICENSE`

### Fixed
- Replace `Jentil::$theme` with `Jentil::$meta`, since `wp_get_theme()` does not work if Jentil installed as package.

## 0.9.0 - 2018-09-27

### Added
- Add method to get composer's vendor directory to filesystem utility
- Setup translations for vendor packages
- Add `Jentil::$theme` attribute that returns `WP_Theme` instance of this theme.
- Add Gutenberg editor styles

### Changed
- Change posts more text customizer control label to 'More link text'
- Rename `languages/` directory to `lang/`
- Move reusable methods in `Setups\MetaBoxes\Layout` to `Setups\MetaBoxes\AbstractMetaBox`
- Prefix registered thumbnail sizes, widget and sidebar ids with `jentil-`
- Prefix global constant names with `JENTIL_`
- Append enqueued assets URL with last modified time for cache busting
- Split up thumbnail setup into separate setups

### Fixed
- Fix incorrectly closing a `<div>` with a `</nav>` element

## 0.8.0 - 2018-08-24

### Added
- Deactivate theme if minimum required WordPress and PHP versions not met.
- `.editorconfig`

### Changed
- Move `isPagelike()` from posts utility to layout utility.
- Explicitly mark layout meta box as compatible with Gutenberg.
- Replace `<?php echo` in templates/partials with `<?=`
- Refactor customizer components' `add_*` methods to accept object in place of id.
- Set cursor to `not-allowed` for disabled form fields.
- Render header search via `wp_nav_menu` filter.
- Strip `.php` extension from slugs passed to template loader
- Move `wp_footer()` outside page wrapper div, to immediately before `</body>`
- Load sidebar and comment templates via view setups
- Use flexbox for page layout
- Accessibility: Undo unsetting outlines when elements receive a focus
- Accessibility: Use [what-input](https://ten1seven.github.io/what-input/) to detect mouse, keyboard and touch events
- Set `$content_width` to `1000`
- Rename CSS grid classes
- Rename CSS toggle classes
- Move composing classes one level up for shorter namespaces
- Rename colophon customizer section to 'Footer'

### Removed
- Automatic updates feature

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
