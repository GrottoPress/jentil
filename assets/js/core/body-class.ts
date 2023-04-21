/// <reference path='./module.d.ts' />

import { Base } from './base'

export class BodyClass extends Base {
    run(): void {
        this.update()
    }

    private update(): void {
        this._j('body').removeClass('no-js').addClass('has-js')
    }
}
