/*!
 * Jentil (c) 2017-present GrottoPress
 * License: https://opensource.org/licenses/MIT
 * Home: https://www.grottopress.com/jentil/
 */

/// <reference path='./module.d.ts' />

export abstract class Base
{
    constructor(protected readonly _j: JQueryStatic)
    {
    }

    abstract run(): void
}
