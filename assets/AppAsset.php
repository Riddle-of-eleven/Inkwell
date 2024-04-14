<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'fonts/font.css',
        'css/common/common.css',
        'css/common/header.css',
        'css/common/main.css',
        'css/common/ui.css',
        'css/common/variables.css',
        'css/common/side.css',
    ];
    public $js = [
        'js/common/menu.js',
        'js/common/handlers.js',
        'js/ui/tabs.js',
        'js/ui/notifications.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap5\BootstrapAsset'
    ];
}
