declare const jentilShortTags: object

declare const jentilColophonModId: string

declare const jentilPageTitleModIds: string[]

declare const jentilRelatedPostsHeadingModIds: string[]

declare const jentilPageLayoutModIds: string[]

declare const jentilMenuL10n: JentilMenuL10n

declare const wp: WP

interface JentilMenuL10n
{
    submenu: string
}

interface WP
{
    customize: {
        (name: string, callback: (value: () => void) => void): void
    }
}
