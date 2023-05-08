
## Fruity-vice Project (Yii2 + Vue.js in TypeScript)

This is a project to learn Yii2 and Vue.js in TypeScript. It is a simple web application to manage a list of fruits.

### Requirements
 - PHP `8.1`
 - Node.js `18.10` or higher

## installation steps

1. Clone this repository
2. Run `cd fruityvice-app && composer install`
3. make database named (optional name) `yii2table` and configure it in `config/db.php`
4. Run `php yii migrate` to create tables
5. Run `php yii serve` to start the application and access it at `http://localhost:8080`

## Usage

1. run `php yii fruits/fetch` to fetch fruits from `https://www.fruityvice.com/api/fruit/all`
2. vue.js code is in `web/app` folder
