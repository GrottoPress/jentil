/// <reference path='./module.d.ts' />

import { Base } from './base'

export class MenuLink extends Base {
    run(): void {
        this.handleClick()
        this.cloneParents()
    }

    // If a menu item has submenu, clone this menu item to the first
    // item of its submenu, and change the original menu item to an
    // anchor that opens the submenu.
    private cloneParents(): void {
        const links = this._j(this._submenu_selector)
            .prev('a')
            .filter((_, link) => 0 !== this._j(link).attr('href')?.indexOf('#'))

        const clones = links.clone()

        links.attr('href', '#')
        clones.children(this._submenu_button_selector).remove()
        clones.prependTo(links.next('ul')).wrap('<li class="menu-item"></li>')
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
