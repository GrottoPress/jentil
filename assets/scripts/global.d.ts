/**
 * Declarations
 *
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

/**
 * @var shortTags
 */
declare const shortTags: any

/**
 * @var colophonModName
 */
declare const colophonModName: string

/**
 * @var titleModNames
 */
declare const titleModNames: string[]

/**
 * @var relatedPostsHeadingModNames
 */
declare const relatedPostsHeadingModNames: string[]

/**
 * @var wp
 */
declare const wp: {
    customize(name: string, callback: (value: any) => void): void
}
