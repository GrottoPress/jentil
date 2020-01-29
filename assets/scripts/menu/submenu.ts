/// <reference path='./module.d.ts' />

import { Base } from './base'

export class Submenu extends Base
{
    run(): void
    {
        this.hide()
    }

    private hide(): void
    {
        this._j(this._submenu_button_selector).next('ul').hide()
    }
}
