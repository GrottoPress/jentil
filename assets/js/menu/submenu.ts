/// <reference path='./module.d.ts' />

import { Base } from './base'

export class Submenu extends Base {
    private timeKeeper: NodeJS.Timeout | undefined

    run(): void {
        this.hide()
        // this.handleFocusOut()
    }

    private hide(): void {
        this._j(this._submenu_selector).hide()
    }

    private handleFocusOut(): void {
        this._j(this._submenu_selector).parent('li').attr('tabindex', -1)

        this._j(this._submenu_selector).parent('li').on('focusout', () => {
            clearTimeout(this.timeKeeper)

            this.timeKeeper = setTimeout(() => {
                this._j(this._submenu_selector).slideUp(this._fx_duration)
            }, 150);
        })
    }
}
