import { Base } from './core/base'

import { BodyClass } from './core/body-class'

const cores = [new BodyClass(jQuery)]

jQuery.each(cores, (_, core: Base): void => core.run())
