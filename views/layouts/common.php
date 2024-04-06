<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;


AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>

<?php $this->beginPage() ?>
<!doctype html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header>
    <div class="left-header">
        <?= Html::a('<div class="main-logo">Ink.<span style="color: var(--color-accent)">well</span></div>', Url::to(['site/index']), ['class' => 'no-underline']); ?>
        <div class="ui search-field">
            <?= search_icon ?>
            <input type="text" placeholder="Ищите книги, фэндомы, авторов...">
        </div>
    </div>
    <div class="right-header">
        <a href="" class="ui button icon-button">
            <?= mystery_icon ?>
            Поиск по вкусу
        </a>
        <a href="" class="ui button icon-button">
            <?= shuffle_icon ?>
            Случайная книга
        </a>
        <a href="" class="ui button small-button">
            <?= menu_icon ?>
        </a>
    </div>
</header>

<div class="line"></div>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>