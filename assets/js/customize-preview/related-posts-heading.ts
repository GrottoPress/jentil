/// <reference path='./module.d.ts' />

import { Base } from './base'

export class RelatedPostsHeading extends Base {
    protected update(): void {
        this._j.each(this._mod_ids, (_, id: string): void => {
            this._wp.customize(id, (from: () => void): void => {
                from.bind((to: string): void => {
                    this._j('#related-posts-wrap .posts-heading').html(to)
                })
            })
        })
    }
}
