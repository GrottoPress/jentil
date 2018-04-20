declare const jentilShortTags: any
declare const jentilColophonModId: string
declare const jentilTitleModIds: string[]
declare const jentilRelatedPostsHeadingModIds: string[]

declare const jentilMenuL10n: {
    submenu: string
}

declare const wp: {
    customize(name: string, callback: (value: () => void) => void): void
}
