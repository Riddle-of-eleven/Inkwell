<?php

namespace app\assets;

use yii\web\AssetBundle;

class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/dashboards/common.css',
    ];
    public $js = [
        'js/ui/tabs.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}