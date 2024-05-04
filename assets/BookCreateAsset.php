<?php

namespace app\assets;

use yii\web\AssetBundle;

class BookCreateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/dashboards/steps.css',
    ];
    public $js = [
        //'js/ui/tabs.js',
        'js/author/create/create-book.js',
        'js/author/create/helpers.js',
        'js/author/create/countdown.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\DashboardAsset'
    ];
}