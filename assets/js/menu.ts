/// <reference path='./menu/module.d.ts' />

import { Base } from './menu/base'
import { MenuButton } from './menu/menu-button'
import { MenuLink } from './menu/menu-link'
import { ParentMenuIcon } from './menu/parent-menu-icon'
import { SidebarCurrentMenuItem } from './menu/sidebar-current-menu-item'
import { Submenu } from './menu/submenu'

const menus = [
    new ParentMenuIcon(jQuery, jentilMenuL10n),
    new Submenu(jQuery, jentilMenuL10n),
    new SidebarCurrentMenuItem(jQuery, jentilMenuL10n),
    new MenuButton(jQuery, jentilMenuL10n),
    new MenuLink(jQuery, jentilMenuL10n),
]

jQuery.each(menus, (_, menu: Base): void => menu.run())
