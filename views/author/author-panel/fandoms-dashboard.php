<?php
$this->title = 'Фэндомы';

/* @var \app\models\Tables\Fandom[] $fandoms */

use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\DashboardAsset::register($this);
$this->registerCssFile('@web/css/dashboards/book.css');
$this->registerCssFile('@web/css/parts/user/author-panel.css');

$this->registerJs(<<<'js'
let fandom_id;
let modal_delete = $('.delete-fandom-confirm')[0];
$('.delete-fandom').click(function () {
    modal_delete.showModal();
    fandom_id = $(this).attr('fandom');
});

$('#reject-delete').click(function () {
    modal_delete.close();
});

$('#accept-delete').click(function () {
    $.ajax({
        type: 'post',
        url: 'index.php?r=author/delete/delete-fandom',
        data: {fandom_id: fandom_id},
        success: function (response) {
            if (response.success) {
                if (!response.exists) {
                    $(`.fandom-item[fandom=${fandom_id}]`).remove();
                    modal_delete.close();
                }
                else modal_delete.close();
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
})
js);

?>

<dialog class="delete-fandom-confirm block modal">
    <div class="modal-container" id="delete-modal">
        <div class="header3">Вы точно хотите удалить этот фэндом?</div>
        <div class="modal-buttons">
            <div class="ui button button-center-align" id="reject-delete">Нет, оставьте его</div>

            <div class="ui button button-center-align danger-accent-button" id="accept-delete">Да, удалите его навсегда</div>
        </div>
    </div>
</dialog>

<div class="dashboard-header">
    <div>
        <h1>Фэндомы</h1>
        <div class="tip-color">Здесь видны все фэндомы, которые вы создали</div>
    </div>
    <?= Html::a(new_book_icon . 'Добавить фэндом', Url::to(['author/create-fandom/create-fandom']), ['class' => 'ui button icon-button accent-button']) ?>
</div>

<? foreach ($fandoms as $fandom) { ?>
    <div class="fandom-item block" fandom="<?=@$fandom->id?>">
        <div class="fandom-info">
            <div class="fandom-title"><?=$fandom->title?></div>
            <div class="fandom-description tip-color"><?=$fandom->description?></div>
        </div>
        <div class="right-sidebar">
            <?= Html::a(edit_icon, Url::to(['author/author-panel/change-fandom', 'id' => $fandom->id]), ['class' => 'ui button icon-button small-button', 'fandom' => $fandom->id]) ?>
            <div class="ui button small-button danger-accent-button delete-fandom" fandom="<?=@$fandom->id?>"><?=delete_icon?></div>
        </div>
    </div>

<?}?>