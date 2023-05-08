const mix = require('laravel-mix');
require('mix-env-file');


mix.ts('web/app/app.ts', 'web/app.js')
    .setPublicPath('web')
    .webpackConfig({
        output:{
            chunkFilename:'js/vuejs_code_split/[name].js',
        }
    })
    .vue({ version: 3 }).env(process.env.ENV_FILE);