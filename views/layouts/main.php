<?php

/** @var yii\web\View $this */
/* @var $content string */

use app\assets\AppAsset;
use yii\bootstrap4\Html;

AppAsset::register($this);
/**
 * @throws Exception
 */
function asset($asset_name)
{
    $basePath = (new AppAsset())->basePath;
    $manifest = file_get_contents("$basePath/build/manifest.json");
    if($manifest === false) {
        throw new Exception("Manifest file not found, Please Run `npm run prod`");
    }
    $manifest = json_decode($manifest, true); //decode json string to php associative array
    if (!isset($manifest[$asset_name])) {
        return $manifest[array_key_first($manifest)]['file'];
    }
//    $live = file_get_contents("$basePath/hot");
//    if($live){
//        return "$live".'/'.$manifest[$asset_name]['file'];
//    }

    return 'build/'.$manifest[$asset_name]['file'];
}
?>
<?php
$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
    $this->registerCsrfMetaTags() ?>
    <title>Vue Library App</title>
    <?php
    $this->head() ?>
    <script type="module" src="<?php echo asset('web/app/app.ts')?>"></script>
</head>
<body>
<?php
$this->beginBody() ?>
<div id="app">

</div>
<?php
$this->endBody() ?>
</body>
</html>
<?php
$this->endPage() ?>
