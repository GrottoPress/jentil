/// <reference path='./global.d.ts' />

namespace Jentil
{
    export class App
    {
        public constructor(private readonly _j: JQueryStatic)
        {
        }

        public run(): void
        {
            this.addBodyClasses()
        }

        private addBodyClasses(): void
        {
            this._j('body').removeClass('no-js').addClass('has-js')
        }
    }
}

new Jentil.App(jQuery).run()
