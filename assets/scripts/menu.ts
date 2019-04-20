/*!
 * Jentil: Menu
 *
 * @author [GrottoPress](https://www.grottopress.com)
 * @author [N Atta Kusi Adusei](https://twitter.com/akadusei)
 */

/// <reference path='./global.d.ts' />

type Target = JQuery<EventTarget>
type JClickEvent = JQuery.ClickEvent

namespace Jentil
{
    export class Menu
    {
        private readonly _duration: number = 200
        private readonly _subMenuButtonClassName: string = 'js-sub-menu-button'

        private readonly _subMenuButtonSelector: string =
            `.${this._subMenuButtonClassName}`

        public constructor(
            private readonly _j: JQueryStatic,
            private readonly _l10n: JentilMenuL10n
        ) {
        }

        public run(): void
        {
            this.addIconToParentMenuItems()
            this.hideSubMenus()
            this.showSidebarCurrentMenuItem()

            this.handleMenuButtonClick()
            this.handleMenuLinkClick()
            this.handleSubMenuButtonClick()
        }

        private addIconToParentMenuItems(): void
        {
            this._j('.menu li > ul').before(
                `<button class="${this._subMenuButtonClassName} sub-menu-toggle">
                    ${this.renderCaret('down')}
                </button>`
            )
        }

        private hideSubMenus(): void
        {
            this._j(this._subMenuButtonSelector).next('ul').hide()
        }

        private showSidebarCurrentMenuItem(): void
        {
            this._j('.site-sidebar li.current-menu-ancestor > ul').show()
                .siblings(this._subMenuButtonSelector)
                .html(`${this.renderCaret('up')}`)
        }

        private handleMenuButtonClick(): void
        {
            this._j('.js-main-menu-button').attr('href', '#').on(
                'click',
                (event: JClickEvent): void => {
                    this._j('.js-main-menu').slideToggle(
                        this._duration,
                        (): void => {
                            this._j('.js-main-menu').toggleClass('show hide')
                                .css({display: ''})
                        }
                    )

                    event.preventDefault()
                }
            )
        }

        private handleMenuLinkClick(): void
        {
            this._j(this._subMenuButtonSelector).prev('a').on(
                'click',
                (event: JClickEvent): void => {
                    if ('#' === this._j(event.currentTarget).attr('href')) {
                        this.toggleSubMenu(this._j(event.currentTarget)
                            .next('button'))

                        event.preventDefault()
                    }
                }
            )
        }

        private handleSubMenuButtonClick(): void
        {
            this._j(this._subMenuButtonSelector).on(
                'click',
                (event: JClickEvent): void => {
                    this.toggleSubMenu(event.currentTarget)

                    event.preventDefault()
                }
            )
        }

        private toggleSubMenu(button: Target, fx = (target: Target): void => {
            this._j(target).slideToggle(this._duration)
        }): void {
            this._j(button).parent().siblings('li').children('ul')
                .slideUp(this._duration)

            this._j(button).parent().siblings('li').children('button')
                .html(this.renderCaret('down'))

            this.toggleCaret(button)

            fx(this._j(button).next('ul'))
        }

        private toggleCaret(button: Target): void
        {
            if ('none' === this._j(button).next('ul').css('display')) {
                this._j(button).html(this.renderCaret('up'))
            } else {
                this._j(button).html(this.renderCaret('down'))
            }
        }

        private renderCaret(direction: 'up' | 'down'): string
        {
            return `<span class="fas fa-caret-${direction} fa-sm" aria-hidden="true"></span>
            <span class="screen-reader-text">${this._l10n.submenu}</span>`
        }
    }
}

new Jentil.Menu(jQuery, jentilMenuL10n).run()
