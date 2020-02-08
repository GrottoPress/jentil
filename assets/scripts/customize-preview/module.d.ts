declare const jentilShortTags: object

declare const jentilColophonModId: string

declare const jentilPageTitleModIds: string[]

declare const jentilRelatedPostsHeadingModIds: string[]

declare const jentilPageLayoutModIds: string[]

declare const wp: WP

interface WP
{
    customize: {
        (name: string, callback: (value: () => void) => void): void
    }
}
