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

    protected toggleSubMenu(button: Target, fx = (target: Target): void => {
        this._j(target).slideToggle(this._fx_duration)
    }): void {
        this._j(button).parent().siblings('li').children('ul')
            .slideUp(this._fx_duration)

        this._j(button).parent().siblings('li').children('button')
            .html(this.renderCaret('down'))

        this.toggleCaret(button)

        fx(this._j(button).next('ul'))
    }

    protected toggleCaret(button: Target): void {
        if ('none' === this._j(button).next('ul').css('display')) {
            this._j(button).html(this.renderCaret('up'))
        } else {
            this._j(button).html(this.renderCaret('down'))
        }
    }

    protected renderCaret(direction: 'up' | 'down'): string {
        return `<span class="fas fa-caret-${direction}" aria-hidden="true">
            </span>
            <span class="screen-reader-text">${this._l10n.submenu}</span>`
    }
}
