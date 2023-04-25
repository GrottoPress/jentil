/// <reference path='./module.d.ts' />

import { Base } from './base'

export class Submenu extends Base {
    run(): void {
        this.hide()
        this.handleClickOutside()
    }

    private hide(): void {
        this._j(this._submenu_selector).hide()
    }

    private handleClickOutside(): void {
        this._j(document).on('click', (event: JQuery.ClickEvent) => {
            if (event.isDefaultPrevented()) return

            const submenu = this._j(this._submenu_selector)

            const parent = submenu.parent('li').get(0)
            if (parent && this._j.contains(parent, event.target)) return

            submenu.prev('a')
                .children(this._submenu_button_selector)
                .html(this.renderIcon('down'))

            submenu.slideUp(this._fx_duration)
        })
    }
}
