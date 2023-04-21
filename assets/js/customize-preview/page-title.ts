/// <reference path='./module.d.ts' />

import { Base } from './base'

export class PageTitle extends Base {
    constructor(
        j: JQueryStatic,
        wp: WP,
        mod_ids: string[],
        private readonly _short_tags: object,
    ) {
        super(j, wp, mod_ids)
    }

    protected update(): void {
        this._j.each(this._mod_ids, (_, id: string): void => {
            this._wp.customize(id, (from: () => void): void => {
                from.bind((to: string): void => {
                    this._j('.page-title').html(this.replaceShortTags(
                        this._short_tags,
                        to
                    ))
                })
            })
        })
    }
}
