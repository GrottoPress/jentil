/// <reference path='./module.d.ts' />

import { Base } from './base'

export class SubmenuButton extends Base
{
    run(): void
    {
        this.handleClick()
    }

    private handleClick(): void
    {
        this._j(this._submenu_button_selector).on(
            'click',
            (event: JQuery.ClickEvent): void => {
                this.toggleSubMenu(event.currentTarget)

                event.preventDefault()
            }
        )
    }
}
