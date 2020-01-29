/// <reference path='./module.d.ts' />

import { Base } from './base'

export class PageLayout extends Base
{
    update(): void
    {
        this._j.each(this._mod_ids, (_, id: string): void => {
            this._wp.customize(id, (from: () => void): void => {
                from.bind((to: string): void => {
                    this.updateBodyClass(to)
                })
            })
        })
    }

    private updateBodyClass(to: string)
    {
        this._j('body')
            .attr('class', (_, klass: string): string => klass.replace(
                /(^|\s)layout\-\S+/g,
                ''
            ))
            .addClass(`layout-${to} layout-columns-${to.split('-').length}`)
    }
}
