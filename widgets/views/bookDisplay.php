<?php

/* @var $this yii\web\View */
/* @var $data _BookData*/

use app\models\_BookData;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\i18n\Formatter;



?>


<div class="block book-preview">
    <div class="book-preview-sidebar">
        <div class="side-buttons">
            <div class="ui button very-small-button"><?= favorite_icon ?></div>
            <div class="ui button very-small-button"><?= priority_icon ?></div>
            <div class="ui button very-small-button"><?= hourglass_icon ?></div>
            <div class="ui button very-small-button"><?= list_alt_icon ?></div>
        </div>
        <div class="line"></div>
        <div class="side-buttons">
            <div class="ui button very-small-button danger-button"><?= visibility_off_icon ?></div>
            <div class="ui button very-small-button danger-button"><?= flag_icon ?></div>
        </div>
    </div>
    <div class="vertical-line"></div>
    <div class="book-preview-content">
        <div class="book-preview-main-meta">
            <div class="creators">
                <div class="creator">
                    <div class="creator-title">Автор:</div>
                    <div class="creator-name"><?= Html::encode($data->author->login)?></div>
                </div>
                <div class="creator">
                    <div class="creator-title">Редакторы:</div>
                    <div class="creator-name">Silmaril, Cactus</div>
                </div>
            </div>
            <div class="accent-metas">
                <div class="accent-meta">Джен</div>
                <div class="accent-meta">PG-13</div>
                <div class="accent-meta">Завершено</div>
            </div>
        </div>
        <div class="line"></div>


        <div class="book-preview-info-cover">
            <div class="book-preview-info">
                <div class="book-preview-title header1"><?= Html::encode($data->title)?></div>
                <div class="small-inner-line"></div>
                <div class="info-pairs">
                    <div class="info-pair">
                        <div class="info-key">Фэндом:</div>
                        <div class="info-value">Sounds of Yesterday</div>
                    </div>
                    <div class="info-pair">
                        <div class="info-key">Первоисточник:</div>
                        <div class="info-value">They don't care about us</div>
                    </div>
                    <div class="info-pair">
                        <div class="info-key">Персонажи:</div>
                        <div class="info-value">Ада, Михаил</div>
                    </div>
                    <div class="info-pair">
                        <div class="info-key">Пейринг:</div>
                        <div class="info-value">Ада / Михаил</div>
                    </div>
                </div>
                <div class="small-inner-line"></div>
                <div class="info-pairs">
                    <div class="info-pair">
                        <div class="info-key">Жанры:</div>
                        <div class="info-value">романтика</div>
                    </div>
                    <div class="info-pair">
                        <div class="info-key">Теги:</div>
                        <div class="info-value">hurt/comfort, повседневность</div>
                    </div>
                </div>
            </div>
            <div class="book-preview-cover">
                <img src="<?= Html::encode($data->cover) ?>" alt="">
            </div>
        </div>

        <div class="line"></div>

        <div class="book-preview-description"><?= Html::encode($data->description)?></div>

        <div class="line"></div>


        <div class="publication-stats">
            <div class="book-size">
                <div class="tip-key">Размер:</div>
                <div class="tip-value">
                    <div class="size-value">Миди</div>
                    <div class="vertical-line"></div>
                    <div class="size-value">3 части</div>
                    <div class="vertical-line"></div>
                    <div class="size-value">24 страницы</div>
                    <div class="vertical-line"></div>
                    <div class="size-value">43 тыс. знаков</div>
                </div>
            </div>
            <div class="book-date">
                <div class="tip-key">Дата публикации:</div>
                <div class="tip-value">
                    <?  $formatter = new Formatter();
                        echo $formatter->asDate($data->created_at, 'dd.MM.yyyy');
                    ?>
                </div>
            </div>


            <div class="book-evaluation">
                <div class="evaluation-pair"><?= favorite_icon ?> 144</div>
                <div class="evaluation-pair"><?= chat_bubble_icon ?> 32</div>
            </div>
        </div>

    </div>
</div>