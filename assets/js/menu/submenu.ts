/// <reference path='./module.d.ts' />

import { Base } from './base'

export class Submenu extends Base {
    private readonly selector = '.menu li > ul'
    private timeKeeper: NodeJS.Timeout | undefined

    run(): void {
        this.hide()
        // this.handleFocusOut()
    }

    private hide(): void {
        this._j(this.selector).hide()
    }

    private handleFocusOut(): void {
        this._j(this.selector).parent('li').attr('tabindex', -1)

        this._j(this.selector).parent('li').on('focusout', () => {
            clearTimeout(this.timeKeeper)

            this.timeKeeper = setTimeout(() => {
                this._j(this.selector).slideUp(this._fx_duration)
            }, 150);
        })
    }
}
