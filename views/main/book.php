<?php
$this->title = Yii::$app->name.' – все книги';

/* @var \app\models\_BookData $book */
/* @var \app\models\_ContentData $content */
/* @var $like */
/* @var $read */
/* @var $read_later */
/* @var $favorite */
/* @var $model */

use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\helpers\Url;
use yii\i18n\Formatter;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->registerCssFile("@web/css/parts/book/book.css");
$this->registerJsFile('@web/js/ajax/interaction.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$formatter = new Formatter();


// взаимодействия
if (!Yii::$app->user->isGuest) {
    $like_class = $like ? 'filled-button' : '';
    $read_class = $read ? 'filled-button' : '';
    $read_later_class = $read_later ? 'filled-button' : '';

    if ($read) {
        $read_later_disabled = 'disabled';
        $read_later_disabled_class = 'inactive-button';
    } else {
        $read_later_disabled = '';
        $read_later_disabled_class = '';
    }

    if ($read_later) {
        $read_disabled = 'disabled';
        $read_disabled_class = 'inactive-button';
    } else {
        $read_disabled = '';
        $read_disabled_class = '';
    }

    $favorite_class = $favorite ? 'filled-button' : '';
    $favorite_text = $favorite ? 'В избранном' : 'Добавить в избранное';
}

?>

<?
$this->registerJs(<<<'js'
let modal = $('.to-collection');
let open = $('#collection-interaction'); 
let close = $('.close-button');
    
open.click(function () { 
    modal[0].showModal(); 
    $('#add-modal').addClass('hidden');
    $('#regular-modal').removeClass('hidden');
    $.ajax({
        type: 'post',
        url: 'index.php?r=interaction/get-collections',
        success: function(response) {
            if (response.data) {
                let content = '';
                response.data.forEach(function(element) {
                    content += `<button class="ui button collection-item block" id="collection-${element.collection.id}" click="addHandler()">
                                    <div>${element.collection.title}</div>
                                    <div class="tip-color">${element.count}</div>
                                </button>`;
                });
                $('.collections-container').html(content);
            }
        },
        error: function(error) {
            
        }
    });
});
close.click(() => { modal[0].close(); });
    
$('.collections-container').on('click', '.collection-item', function() {
    $.ajax({
        type: 'post',
        url: 'index.php?r=interaction/add-to-collection',
        data: {
            book_id: (new URL(document.location)).searchParams.get("id"),
            collection_id: $(this).attr('id') 
        },
        success: function(response) {
            if (response.success) {
                modal[0].close(); modal.removeClass('showed');
                if (response.is_already) showMessage('Книга уже добавлена в эту подборку', 'warning');
                else {
                    if (response.is_added) showMessage('Книга успешно добавлена в подборку', 'success');
                    else showMessage('Что-то пошло не так, кажется, книга не была добавлена в подборку', 'error');
                }
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
});

$('.collection-create').click(function(e) {
    let add = $('#add-modal');
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: 'index.php?r=interaction/render-create-collection',
        success: function(response) {
            $('#regular-modal').addClass('hidden');
            add.removeClass('hidden');
            add.html(response);
        }
    });
});
js, View::POS_LOAD)


?>


<dialog class="to-collection block modal">
    <div class="close-button"><?=close_icon?></div>
    <div class="modal-container" id="regular-modal">
        <div class="header3">Добавить в существующую подборку</div>
        <div class="collections-container"></div>
        <div class="line-centered-text">
            <div class="line"></div>
            <div class="line-text">или</div>
            <div class="line"></div>
        </div>
        <button class="ui button icon-button collection-create"><?=list_alt_add_icon?>Создать новую подборку</button>
    </div>

    <div class="modal-container" id="add-modal">
    </div>
</dialog>


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
                        <?= $formatter->asDate($book->created_at, 'd MMMM yyyy'); ?>
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

        <? if (!Yii::$app->user->isGuest) : ?>
        <div class="block book-actions">
            <div>
                <button class="ui button button-left-align <?=@$like_class?>" id="like-interaction"><?= favorite_icon ?>Нравится</button>
                <button class="ui button button-left-align <?=@$read_class?> <?=@$read_disabled_class?>" id="read-interaction" <?=$read_disabled?>><?= priority_icon ?>Прочитано</button>
                <button class="ui button button-left-align <?=@$read_later_class?> <?=@$read_later_disabled_class?>" id="read-later-interaction" <?=$read_later_disabled?>><?= hourglass_icon ?>Прочитать позже</button>
                <button class="ui button button-left-align <?=@$favorite_class?>" id="favorite-book-interaction"><?= bookmarks_icon ?><div class="button-text"><?=$favorite_text?></div></button>
            </div>

            <div class="inner-line"></div>

            <div>
                <a href="" class="ui button button-left-align"><?= download_icon ?>Скачать работу</a>
                <button class="ui button button-left-align" id="collection-interaction"><?= list_alt_icon ?>Добавить в подборку</button>
                <!--<div class="tip">Работа уже добавлена в 3 подборки.</div>-->
            </div>

            <div class="inner-line"></div>

            <div>
                <a href="" class="ui button button-left-align danger-button"><?= visibility_off_icon ?>Скрыть из ленты</a>
                <a href="" class="ui button button-left-align danger-button"><?= flag_icon ?>Пожаловаться</a>
            </div>
        </div>
        <? else : ?>
        <div class="block book-actions">
            <div>
                <a href="" class="ui button button-left-align"><?=download_icon?>Скачать работу</a>
            </div>

            <div class="inner-line"></div>

            <div>
                <a href="" class="ui button button-left-align danger-button"><?=flag_icon?>Пожаловаться</a>
            </div>
        </div>
        <? endif; ?>

    </div>
</div>

<div class="inner-line"></div>
<div class="interface-header header-with-element">
    <div class="header2">Оглавление</div>
    <?= Html::a(resume_icon . 'Читать', Url::to(['main/read-book', 'id' => $book->id]), ['class' => 'ui button icon-button'])?>
</div>

<div class="book-toc">
    <? foreach ($content->root as $r) {
        if ($r->is_section) :
    ?>
    <details class="toc-section" open>
        <summary class="block toc-section-title">
            <div class="expand-icon"><?= expand_more_icon ?></div>
            <div class=""><?= $r->title ?></div>
        </summary>
        <? if (array_key_exists($r->id, $content->offspring)) : ?>
        <div class="toc-chapters">
            <? foreach ($content->offspring[$r->id] as $o) { ?>
                <div class="block toc-chapter">
                    <div class="chapter-title"><?= $o->title ?></div>
                    <div class="chapter-meta">
                        <div class="chapter-stats">
                            <div class="stats-pair"><?= visibility_icon ?><div>Просмотры</div><div>261</div></div>
                            <div class="stats-pair"><?= chat_bubble_icon ?><div>Комментарии</div><div>1</div></div>
                        </div>
                        <div class="chapter-date">
                            <div class="stats-pair"><div>Дата публикации:</div><div><?= $formatter->asDate($o->created_at, 'd MMMM yyyy'); ?></div></div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
            <? endif; ?>
    </details>

    <? else : ?>
            <div class="block toc-chapter">
                <div class="chapter-title"><?= $r->title ?></div>
                <div class="chapter-meta">
                    <div class="chapter-stats">
                        <div class="stats-pair"><?= visibility_icon ?><div>Просмотры</div><div>261</div></div>
                        <div class="stats-pair"><?= chat_bubble_icon ?><div>Комментарии</div><div>1</div></div>
                    </div>
                    <div class="chapter-date">
                        <div class="stats-pair"><div>Дата публикации:</div><div><?= $formatter->asDate($r->created_at, 'd MMMM yyyy'); ?></div></div>
                    </div>
                </div>
            </div>
    <? endif;
    } ?>

</div>
