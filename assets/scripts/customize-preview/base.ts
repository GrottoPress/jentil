/*!
 * Jentil (c) 2017-present GrottoPress
 * License: https://opensource.org/licenses/MIT
 * Home: https://www.grottopress.com/jentil/
 */

/// <reference path='./module.d.ts' />

export abstract class Base
{
    constructor(
        protected readonly _j: JQueryStatic,
        protected readonly _wp: WP,
        protected readonly _mod_ids: string[],
    ) {
    }

    run(): void
    {
        this.update()
    }

    abstract update(): void

    protected replaceShortTags(tags: object, content: string): string
    {
        this._j.each(tags, (tag: string, replace: string): void => {
            content = content.split(tag).join(replace)
        })

        return content
    }
}
