/*!
 * Jentil (c) 2017-present GrottoPress
 * License: https://opensource.org/licenses/MIT
 * Home: https://www.grottopress.com/jentil/
 */

/// <reference path='./module.d.ts' />

export abstract class Base {
    protected readonly _fx_duration = 200
    protected readonly _submenu_button_class_name = 'js-sub-menu-button'
    protected _submenu_selector = '#primary-menu .menu li > ul'

    protected readonly _submenu_button_selector =
        `.${this._submenu_button_class_name}`

    constructor(
        protected readonly _j: JQueryStatic,
        protected readonly _l10n: JentilMenuL10n
    ) {
    }

    abstract run(): void

    protected toggleSubMenu(link: JQuery<EventTarget>): void {
        const jlink = this._j(link)
        const siblings = jlink.parent('li').siblings('li')
        const submenu = jlink.next('ul')

        siblings.children('ul').slideUp(this._fx_duration)

        siblings.children('a')
            .children(this._submenu_button_selector)
            .html(this.renderIcon('down'))

        this.toggleIcon(link)

        submenu.find('ul')
            .prev('a')
            .children(this._submenu_button_selector)
            .html(this.renderIcon('down'))

        submenu.find('ul').slideUp(this._fx_duration)
        submenu.slideToggle(this._fx_duration)
    }

    protected toggleIcon(link: JQuery<EventTarget>): void {
        const jlink = this._j(link)

        const direction = ('none' === jlink.next('ul').css('display')) ?
            'up' :
            'down'

        jlink.children(this._submenu_button_selector)
            .html(this.renderIcon(direction))
    }

    protected renderIcon(direction: 'up' | 'down'): string {
        return `<span class="fas fa-caret-${direction}" aria-hidden="true">
            </span>
            <span class="screen-reader-text">${this._l10n.submenu}</span>`
    }
}
