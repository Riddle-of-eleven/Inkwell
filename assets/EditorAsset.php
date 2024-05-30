<?php

namespace app\assets;

use yii\web\AssetBundle;

// класс нужен для подключения Editor.js
class EditorAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js',
    ];
    public $css = [
        'https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css',
        'css/dashboards/quill.css',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_END,
    ];
}