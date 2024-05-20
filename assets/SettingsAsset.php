<?php

namespace app\assets;

use yii\web\AssetBundle;

class SettingsAsset extends  AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/parts/user/settings.css',
    ];
    public $js = [
        'js/user/settings/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}

class SettingsCropperAsset extends AssetBundle {
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