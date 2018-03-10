declare const shortTags: any
declare const colophonModName: string
declare const titleModNames: string[]
declare const relatedPostsHeadingModNames: string[]
declare const wp: {
    customize(name: string, callback: (value: () => void) => void): void
}
