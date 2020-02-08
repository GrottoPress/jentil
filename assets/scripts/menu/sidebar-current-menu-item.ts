/// <reference path='./module.d.ts' />

import { Base } from './base'

export class SidebarCurrentMenuItem extends Base
{
    run(): void
    {
        this.show()
    }

    private show(): void
    {
        this._j('.site-sidebar li.current-menu-ancestor > ul')
            .show()
            .siblings(this._submenu_button_selector)
            .html(this.renderCaret('up'))
    }
}
