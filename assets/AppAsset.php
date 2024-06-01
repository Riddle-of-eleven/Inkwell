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

        'css/menu/main.css',
        //'css/themes/standard',

        // адаптивность
        'css/adaptivity/main.css'
    ];
    public $js = [
        'js/common/helpers.js',
        'js/common/main-search.js',
        'js/ui/menu.js',
        'js/ui/tabs.js',
        'js/ui/notifications.js',
        'js/ui/themes.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap5\BootstrapAsset'
    ];
}
