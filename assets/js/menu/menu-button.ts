/// <reference path='./module.d.ts' />

import { Base } from './base'

export class MenuButton extends Base {
    run(): void {
        this.handleClick()
    }

    private handleClick(): void {
        this._j('.js-main-menu-button').attr('href', '#').on(
            'click',
            (event: JQuery.ClickEvent): void => {
                const jmenu = this._j('.js-main-menu')

                this.toggleIcon(jmenu)
                this.toggleMenu(jmenu)
                event.preventDefault()
            }
        )
    }

    private toggleIcon(menu: JQuery<EventTarget>): void {
        const icon = menu.hasClass('hide') ? 'fas fa-times' : 'fas fa-bars'

        this._j('.js-menu-button-icon')
            .html(`<span class="${icon}" aria-hidden="true"></span>`)
    }

    private toggleMenu(menu: JQuery<EventTarget>) {
        menu.slideToggle(this._fx_duration, (): void => {
            menu.toggleClass('show hide').css({display: ''})
        })
    }
}
