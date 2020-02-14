/// <reference path='./module.d.ts' />

import { Base } from './base'

export class Colophon extends Base
{
    constructor(
        j: JQueryStatic,
        wp: WP,
        mod_id: string,
        private readonly _short_tags: object,
    ) {
        super(j, wp, [mod_id])
    }

    protected update(): void
    {
        this._wp.customize(this._mod_ids[0], (from: () => void): void => {
                from.bind((to: string): void => {
                    this._j('#colophon small').html(this.replaceShortTags(
                        this._short_tags,
                        to
                    ))
                })
            }
        )
    }
}
