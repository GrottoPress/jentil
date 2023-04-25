/// <reference path='./module.d.ts' />

import { Base } from './base'

export class MenuLink extends Base {
    run(): void {
        this.handleClick()
        // this.moveElement()
    }

    private moveElement(): void {
        this._j(this._submenu_selector).prev('a').filter((_, link) => {
            return (0 !== this._j(link).attr('href')?.indexOf('#'))
        }).each((_, link) => {
            const element = this._j(link).first()
            element.detach().appendTo(element.next())
        })
    }

    private handleClick(): void {
        this._j(this._submenu_selector).prev('a').on(
            'click',
            (event: JQuery.ClickEvent): void => {
                this.toggleSubMenu(event.currentTarget)
                event.preventDefault()
            }
        )
    }
}
