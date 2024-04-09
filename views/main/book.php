<?php
$this->title = Yii::$app->name.' – все книги';

/* @var $book */

use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\helpers\Url;
use yii\i18n\Formatter;

$this->registerCssFile("@web/css/parts/book/book.css");

?>

<div class="book-header">
    <div class="book-card">

        <div class="block main-info">
            <div class="info-header">
                <div class="creators">
                    <div class="creator">
                        <div>Автор:</div>
                        <?= Html::a(Html::encode($book->author->login), Url::to(['#']))?>
                    </div>
                </div>
                <div class="metas">
                    <div class="main-meta"><?= Html::encode($book->relation->title) ?></div>
                    <div class="main-meta"><?= Html::encode($book->rating->title) ?></div>
                    <div class="main-meta"><?= Html::encode($book->completeness->title) ?></div>
                </div>
            </div>
            <div class="inner-line"></div>
            <h1><?= Html::encode($book->title)?></h1>
            <div class="info-pairs">
                <div class="info-pair">
                    <div class="info-key">Фэндом:</div>
                    <? if (isset($book->fandoms)) :
                        foreach ($book->fandoms as $fandom) {
                            echo '<div class="info-value">' . $fandom->title . '</div>';
                        }
                    endif; ?>
                </div>
                <div class="info-pair">
                    <div class="info-key">Первоисточник:</div>
                    <? if (isset($book->origins)) :
                        foreach ($book->origins as $origin) {
                            echo '<div class="info-value">' . $origin->title . ' (' . $origin->release_date .')'. '</div>';
                        }
                    endif; ?>
                </div>
                <div class="info-pair">
                    <div class="info-key">Персонажи:</div>
                    <? if (isset($book->characters)) :
                        $first = true;
                        foreach ($book->characters as $character) {
                            if ($first) $first= false;
                            else echo ', ';
                            echo '<div class="info-value">' . $character->full_name . '</div>';
                        }
                    endif; ?>
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
                    <? if (isset($book->genres)) :
                        foreach ($book->genres as $genre) {
                            echo '<div class="info-value">' . $genre->title . '</div>';
                        }
                    endif; ?>
                </div>
                <div class="info-pair">
                    <div class="info-key">Теги:</div>
                    <? if (isset($book->tags)) :
                        foreach ($book->tags as $tag) {
                            echo '<div class="info-value">' . $tag->title . '</div>';
                        }
                    endif; ?>
                </div>
            </div>
            <div class="small-inner-line"></div>
            <div class="info-pairs-vertical">
                <div class="info-pair-vertical">
                    <div class="info-key">Описание:</div>
                    <div class="info-value"><?= Html::encode($book->description)?></div>
                </div>
                <div class="info-pair-vertical">
                    <div class="info-key">Примечание:</div>
                    <div class="info-value"><?= Html::encode($book->remark)?>.</div>
                </div>
                <div class="info-pair-vertical">
                    <div class="info-key">Посвящение:</div>
                    <div class="info-value"><?= Html::encode($book->dedication)?></div>
                </div>
            </div>
            <div class="info-pair-vertical disclaimer">
                <div class="info-key key-disclaimer">Дисклеймер:</div>
                <div class="info-value"><?= Html::encode($book->disclaimer)?></div>
            </div>
            <div class="inner-line"></div>
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
                            echo $formatter->asDate($book->created_at, 'd MMMM yyyy');
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="block statistics">
            <div class="stats-pair">
                <?= visibility_icon ?>
                <div>Просмотры</div>
                <div>261</div>
            </div>
            <div class="stats-pair">
                <?= favorite_icon ?>
                <div>Лайки</div>
                <div>19</div>
            </div>
            <div class="stats-pair">
                <?= chat_bubble_icon ?>
                <div>Комментарии</div>
                <div>4</div>
            </div>
            <div class="stats-pair">
                <?= chat_icon ?>
                <div>Рецензии</div>
                <div>1</div>
            </div>
            <div class="stats-pair">
                <?= list_alt_icon ?>
                <div>Подборки</div>
                <div>45</div>
            </div>
        </div>

    </div>

    <div class="book-sidebar">

        <? if ($book->cover): ?>
            <div class="book-cover">
                <?= Html::img('@web/images/covers/' . $book->cover, ['alt' => 'обложка']) ?>
            </div>
        <? endif; ?>
        <div class="block book-actions">
            <div>
                <a href="" class="ui button button-left-align filled-button">
                    <?= favorite_icon ?>
                    Нравится
                </a>
                <a href="" class="ui button button-left-align filled-button">
                    <?= priority_icon ?>
                    Прочитано
                </a>
                <a href="" class="ui button button-left-align inactive-button">
                    <?= hourglass_icon ?>
                    Прочитать позже
                </a>
            </div>

            <div class="inner-line"></div>

            <div>
                <a href="" class="ui button button-left-align">
                    <?= download_icon ?>
                    Скачать работу
                </a>
                <a href="" class="ui button button-left-align">
                    <?= list_alt_icon ?>
                    Добавить в подборку
                </a>
                <div class="tip">Работа уже добавлена в 3 подборки.</div>
            </div>

            <div class="inner-line"></div>

            <div>
                <a href="" class="ui button button-left-align danger-button">
                    <?= visibility_off_icon ?>
                    Скрыть из ленты
                </a>
                <a href="" class="ui button button-left-align danger-button">
                    <?= flag_icon ?>
                    Пожаловаться
                </a>
            </div>
        </div>

    </div>
</div>

<div class="inner-line"></div>
<div class="interface-header header-with-element">
    <div class="header2">Оглавление</div>
    <a class="ui button icon-button">
        <?= resume_icon ?>
        Продолжить читать
    </a>
</div>

<div class="book-toc">
    <details class="toc-section" open>
        <summary class="block toc-section-title">
            <div class="expand-icon"><?= expand_more_icon ?></div>
            <div class="">Часть 1. Название первого раздела</div>
        </summary>
        <div class="toc-chapters">
            <div class="block toc-chapter">
                <div class="chapter-title">Часть 1. Ржится рожь</div>
                <div class="chapter-meta">
                    <div class="chapter-stats">
                        <div class="stats-pair">
                            <?= visibility_icon ?>
                            <div>Просмотры</div>
                            <div>261</div>
                        </div>
                        <div class="stats-pair">
                            <?= chat_bubble_icon ?>
                            <div>Комментарии</div>
                            <div>1</div>
                        </div>
                    </div>
                    <div class="chapter-date">
                        <div class="stats-pair">
                            <div>Дата публикации:</div>
                            <div>26 марта 2024</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block toc-chapter">
                <div class="chapter-title">Часть 2. Овёс овсится</div>
                <div class="chapter-meta">
                    <div class="chapter-stats">
                        <div class="stats-pair">
                            <?= visibility_icon ?>
                            <div>Просмотры</div>
                            <div>261</div>
                        </div>
                        <div class="stats-pair">
                            <?= chat_bubble_icon ?>
                            <div>Комментарии</div>
                            <div>1</div>
                        </div>
                    </div>
                    <div class="chapter-date">
                        <div class="stats-pair">
                            <div>Дата публикации:</div>
                            <div>26 марта 2024</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block toc-chapter">
                <div class="chapter-title">Часть 3. Чечевица чечевится</div>
                <div class="chapter-meta">
                    <div class="chapter-stats">
                        <div class="stats-pair">
                            <?= visibility_icon ?>
                            <div>Просмотры</div>
                            <div>261</div>
                        </div>
                        <div class="stats-pair">
                            <?= chat_bubble_icon ?>
                            <div>Комментарии</div>
                            <div>1</div>
                        </div>
                    </div>
                    <div class="chapter-date">
                        <div class="stats-pair">
                            <div>Дата публикации:</div>
                            <div>26 марта 2024</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </details>
    <details class="toc-section" open>
        <summary class="block toc-section-title">
            <?= expand_more_icon ?>
            <div class="">Часть 2. Название второго раздела</div>
        </summary>
        <div class="toc-chapters">
            <div class="block toc-chapter">
                <div class="chapter-title">Часть 1. Ржится рожь</div>
                <div class="chapter-meta">
                    <div class="chapter-stats">
                        <div class="stats-pair">
                            <?= visibility_icon ?>
                            <div>Просмотры</div>
                            <div>261</div>
                        </div>
                        <div class="stats-pair">
                            <?= chat_bubble_icon ?>
                            <div>Комментарии</div>
                            <div>1</div>
                        </div>
                    </div>
                    <div class="chapter-date">
                        <div class="stats-pair">
                            <div>Дата публикации:</div>
                            <div>26 марта 2024</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block toc-chapter">
                <div class="chapter-title">Часть 2. Овёс овсится</div>
                <div class="chapter-meta">
                    <div class="chapter-stats">
                        <div class="stats-pair">
                            <?= visibility_icon ?>
                            <div>Просмотры</div>
                            <div>261</div>
                        </div>
                        <div class="stats-pair">
                            <?= chat_bubble_icon ?>
                            <div>Комментарии</div>
                            <div>1</div>
                        </div>
                    </div>
                    <div class="chapter-date">
                        <div class="stats-pair">
                            <div>Дата публикации:</div>
                            <div>26 марта 2024</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block toc-chapter">
                <div class="chapter-title">Часть 3. Чечевица чечевится</div>
                <div class="chapter-meta">
                    <div class="chapter-stats">
                        <div class="stats-pair">
                            <?= visibility_icon ?>
                            <div>Просмотры</div>
                            <div>261</div>
                        </div>
                        <div class="stats-pair">
                            <?= chat_bubble_icon ?>
                            <div>Комментарии</div>
                            <div>1</div>
                        </div>
                    </div>
                    <div class="chapter-date">
                        <div class="stats-pair">
                            <div>Дата публикации:</div>
                            <div>26 марта 2024</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </details>
</div>