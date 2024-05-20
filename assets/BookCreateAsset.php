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
        'js/author/create/variables.js',
        'js/author/create/create-book.js',
        'js/author/create/helpers.js',
        'js/author/create/countdown.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\DashboardAsset'
    ];
}

// это класс, специально предназначенный для подключения cropper
class BookCreateCropperAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js',
    ];
    // обязательно должен быть перед скриптом, который его использует, то есть в начале страницы
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];
}