declare const shortTags: any
declare const colophonModName: string
declare const titleModNames: string[]
declare const relatedPostsHeadingModNames: string[]

declare const wp: {
    customize(name: string, callback: (value: () => void) => void): void

    i18n: {
        __(text: string, domain: string): string
    }
}

declare const jentilMenuL10n: {
    submenu: string
    kkk: string
}
