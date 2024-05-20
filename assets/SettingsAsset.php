<?php

namespace app\assets;

use yii\web\AssetBundle;

class SettingsAsset extends  AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/user/settings/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}