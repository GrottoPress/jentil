/// <reference path='./module.d.ts' />

import { Base } from './base'

export class Submenu extends Base {
    run(): void {
        this.handleClickOutside()
        this.hide()
    }

    private hide(): void {
        this._j(this._submenu_selector).hide()
    }

    private handleClickOutside(): void {
        this._j(document).on('click', (event: JQuery.ClickEvent) => {
            if (event.isDefaultPrevented()) return

            const submenu = this._j(this._submenu_selector)
            if (0 !== submenu.parent('li').find(event.target).length) return

            this.closeSubmenu(submenu.prev('a'))
        })
    }
}
