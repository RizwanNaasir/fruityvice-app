const mix = require('laravel-mix');
require('mix-env-file');


mix.ts('web/app/app.ts', 'web/app.js')
    .setPublicPath('web')
    .vue({ version: 3 }).env(process.env.ENV_FILE);