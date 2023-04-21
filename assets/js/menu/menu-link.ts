/// <reference path='./module.d.ts' />

import { Base } from './base'

export class MenuLink extends Base {
    run(): void {
        this.handleClick()
    }

    private handleClick(): void {
        this._j(this._submenu_button_selector).prev('a').on(
            'click',
            (event: JQuery.ClickEvent): void => {
                if ('#' === this._j(event.currentTarget).attr('href')) {
                    this.toggleSubMenu(
                        this._j(event.currentTarget).next('button')
                    )

                    event.preventDefault()
                }
            }
        )
    }
}
