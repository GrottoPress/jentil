/// <reference path='./global.d.ts' />

namespace Jentil
{
    export class Customizer
    {
        public constructor(
            private readonly _j: JQueryStatic,
            private readonly _wp: WP,
            private readonly _shortTags: object,
            private readonly _colophonModId: string,
            private readonly _pageLayoutModId: string[],
            private readonly _pageTitleModId: string[],
            private readonly _relPostsHdModId: string[],
        ) {
        }

        public run(): void
        {
            this.updateColophon()
            this.updatePageTitle()
            this.updateRelatedPostsHeading()
            this.updatePageLayout()
        }

        private updateColophon(): void
        {
            this._wp.customize(
                this._colophonModId,
                (from: () => void): void => {
                    from.bind((to: string): void => {
                        this._j('#colophon small')
                            .html(this.replaceShortTags(to))
                    })
                }
            )
        }

        private updatePageTitle(): void
        {
            this._j.each(this._pageTitleModId, (_:number, id: string): void => {
                this._wp.customize(id, (from: () => void): void => {
                    from.bind((to: string): void => {
                        this._j('.page-title').html(this.replaceShortTags(to))
                    })
                })
            })
        }

        private updateRelatedPostsHeading(): void
        {
            this._j.each(this._relPostsHdModId, (_: number, id: string): void => {
                this._wp.customize(id, (from: () => void): void => {
                    from.bind((to: string): void => {
                        this._j('#related-posts-wrap .posts-heading').html(to)
                    })
                })
            })
        }

        private updatePageLayout(): void
        {
            this._j.each(
                this._pageLayoutModId, (_: number, id: string): void => {
                    this._wp.customize(id, (from: () => void): void => {
                        from.bind((to: string): void => {
                            this._j('body').attr(
                                'class',
                                (_: number, klass: string): string =>
                                    klass.replace(/(^|\s)layout\-\S+/g, '')
                            ).addClass(`layout-${to} layout-columns-${to
                                .split('-').length}`)
                        })
                    })
                }
            )
        }

        private replaceShortTags(content: string): string
        {
            this._j.each(
                this._shortTags,
                (tag: string, replace: string): void => {
                    content = content.split(tag).join(replace)
                }
            )

            return content
        }
    }
}

new Jentil.Customizer(
    jQuery,
    wp,
    jentilShortTags,
    jentilColophonModId,
    jentilPageLayoutModIds,
    jentilPageTitleModIds,
    jentilRelatedPostsHeadingModIds
).run()
