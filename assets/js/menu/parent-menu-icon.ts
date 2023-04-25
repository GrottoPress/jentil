/// <reference path='./module.d.ts' />

import { Base } from './base'

export class ParentMenuIcon extends Base {
    run(): void {
        this.add()
    }

    private add(): void {
        this._j('.menu li > ul').prev('a').append(
            `<span class="${this._submenu_button_class_name}
                sub-menu-toggle">${this.renderCaret('down')}</span>`
        )
    }
}
