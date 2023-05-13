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
        const aunties = jlink.parent('li').siblings('li')
        const submenu = jlink.next('ul')
        const submenuChildren = submenu.find('ul')

        this.closeSubmenu(aunties.children('a'))
        this.closeSubmenu(submenuChildren.prev('a'))

        const hidden = 'none' === submenu.css('display')
        const icon = hidden ? 'up' : 'down'

        hidden ? jlink.addClass('open') : jlink.removeClass('open')

        jlink.children(this._submenu_button_selector)
            .html(this.renderSubmenuIcon(icon))

        submenu.slideToggle(this._fx_duration)
    }

    protected closeSubmenu(link: JQuery<EventTarget>): void {
        const jlink = this._j(link)

        jlink.removeClass('open')

        jlink.children(this._submenu_button_selector)
            .html(this.renderSubmenuIcon('down'))

        jlink.next('ul').slideUp(this._fx_duration)
    }

    protected renderSubmenuIcon(direction: 'up' | 'down'): string {
        return `<span class="fas fa-caret-${direction}" aria-hidden="true">
            </span>
            <span class="screen-reader-text">${this._l10n.submenu}</span>`
    }
}
