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

                jmenu.slideToggle(this._fx_duration, (): void => {
                    jmenu.toggleClass('show hide').css({display: ''})
                })

                event.preventDefault()
            }
        )
    }
}
