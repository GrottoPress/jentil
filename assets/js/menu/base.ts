/*!
 * Jentil (c) 2017-present GrottoPress
 * License: https://opensource.org/licenses/MIT
 * Home: https://www.grottopress.com/jentil/
 */

/// <reference path='./module.d.ts' />

type Target = JQuery<EventTarget>

export abstract class Base {
    protected readonly _fx_duration: number = 200
    protected readonly _submenu_button_class_name: string = 'js-sub-menu-button'
    protected readonly _submenu_button_selector: string =
        `.${this._submenu_button_class_name}`

    constructor(
        protected readonly _j: JQueryStatic,
        protected readonly _l10n: JentilMenuL10n
    ) {
    }

    abstract run(): void

    protected toggleSubMenu(link: Target): void {
        this._j(link)
            .parent('li')
            .siblings('li')
            .children('ul')
            .slideUp(this._fx_duration)

        this._j(link)
            .parent('li')
            .siblings('li')
            .children('a')
            .children(this._submenu_button_selector)
            .html(this.renderCaret('down'))

        this.toggleCaret(link)

        this._j(link).next('ul').slideToggle(this._fx_duration)
    }

    protected toggleCaret(link: Target): void {
        const direction = ('none' === this._j(link).next('ul').css('display')) ?
            'up' :
            'down'

        this._j(link)
            .children(this._submenu_button_selector)
            .html(this.renderCaret(direction))
    }

    protected renderCaret(direction: 'up' | 'down'): string {
        return `<span class="fas fa-caret-${direction}" aria-hidden="true">
            </span>
            <span class="screen-reader-text">${this._l10n.submenu}</span>`
    }
}
