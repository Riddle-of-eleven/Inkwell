<?php

/* @var $this yii\web\View */
/* @var $data _BookData*/

use app\models\_BookData;
use yii\helpers\Html;
use yii\helpers\Url;
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
                    <?= Html::a(Html::encode($data->author->login), Url::to(['main/author', 'id' => $data->author->id]), ['class' => 'creator-name'])?>
                </div>
                <!--<div class="creator">
                    <div class="creator-title">Редакторы:</div>
                    <div class="creator-name">Silmaril, Cactus</div>
                </div>-->
            </div>
            <div class="accent-metas">
                <div class="accent-meta"><?= Html::encode($data->relation->title) ?></div>
                <div class="accent-meta"><?= Html::encode($data->rating->title) ?></div>
                <div class="accent-meta"><?= Html::encode($data->completeness->title) ?></div>
            </div>
        </div>
        <div class="line"></div>


        <div class="book-preview-info-cover">
            <div class="book-preview-info">
                <div class="book-preview-title header1"><?=Html::a($data->title, Url::to(['main/book', 'id' => $data->id]))?></div>
                <div class="small-inner-line"></div>
                <div class="info-pairs">
                    <div class="info-pair">
                        <div class="info-key">Фэндом:</div>
                        <? if (isset($data->fandoms)) :
                        foreach ($data->fandoms as $fandom) {
                            echo '<div class="info-value">' . $fandom->title . '</div>';
                        }
                        endif; ?>
                    </div>
                    <div class="info-pair">
                        <div class="info-key">Первоисточник:</div>
                        <? if (isset($data->origins)) :
                            foreach ($data->origins as $origin) {
                                echo '<div class="info-value">' . $origin->title . ' (' . $origin->release_date .')'. '</div>';
                            }
                        endif; ?>
                    </div>
                    <div class="info-pair">
                        <div class="info-key">Персонажи:</div>
                        <? if (isset($data->characters)) :
                            $first = true;
                            foreach ($data->characters as $character) {
                                if ($first) $first= false;
                                else echo ', ';
                                echo '<div class="info-value">' . $character->full_name . '</div>';
                            }
                        endif; ?>
                    </div>
                    <!--<div class="info-pair">
                        <div class="info-key">Пейринг:</div>
                        <div class="info-value">Ада / Михаил</div>
                    </div>-->
                </div>
                <div class="small-inner-line"></div>
                <div class="info-pairs">
                    <div class="info-pair">
                        <div class="info-key">Жанры:</div>
                        <? if (isset($data->genres)) :
                            foreach ($data->genres as $genre) {
                                echo '<div class="info-value">' . $genre->title . '</div>';
                            }
                        endif; ?>
                    </div>
                    <!--<div class="info-pair">
                        <div class="info-key">Теги:</div>
                        <? if (isset($data->tags)) :
                            foreach ($data->tags as $tag) {
                                echo '<div class="info-value">' . $tag->title . '</div>';
                            }
                        endif; ?>
                    </div>-->
                </div>
            </div>
            <div class="book-preview-cover">
                <?= Html::img($data->cover) ?>
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