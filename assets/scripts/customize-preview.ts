/// <reference path='./customize-preview/module.d.ts' />

import { Base } from './customize-preview/base'

import { Colophon } from './customize-preview/colophon'
import { PageLayout } from './customize-preview/page-layout'
import { PageTitle } from './customize-preview/page-title'
import { RelatedPostsHeading } from './customize-preview/related-posts-heading'

const previews = [
    new Colophon(jQuery, wp, jentilColophonModId, jentilShortTags),
    new PageLayout(jQuery, wp, jentilPageLayoutModIds),
    new PageTitle(jQuery, wp, jentilPageTitleModIds, jentilShortTags),
    new RelatedPostsHeading(jQuery, wp, jentilRelatedPostsHeadingModIds)
]

jQuery.each(previews, (_, preview: Base): void => preview.run())
