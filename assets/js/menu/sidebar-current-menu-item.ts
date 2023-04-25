/// <reference path='./module.d.ts' />

import { Base } from './base'

export class SidebarCurrentMenuItem extends Base {
    run(): void {
        this.show()
    }

    private show(): void {
        this._j('.widget_nav_menu li.current-menu-ancestor > ul')
            .show()
            .prev('a')
            .children(this._submenu_button_selector)
            .html(this.renderIcon('up'))
    }
}
