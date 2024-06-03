<?php
/* @var yii\web\View $this*/
/* @var $book Book */

/* @var $public_editing PublicEditing[] */
/* @var $statuses Completeness[] */

/* @var $this_public_editing int */
/* @var $this_status int */

use app\models\Tables\Book;
use app\models\Tables\Completeness;
use app\models\Tables\PublicEditing;

\app\assets\BookCreateAsset::register($this);
$this->registerJsFile('@web/js/user/book/manage-access.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$draft_checked = $book->is_draft ? 'checked' : '';

?>


<div class="header2">Видимость книги</div>
<div class="metadata-item direct-to-session">
    <label class="ui choice-input-block">
        <input type="checkbox" name="draft" value="1" <?=$draft_checked?>>
        <span>
            <div class="title-description">
                Черновик
                <div class="tip">Книга не будет видна на сайте</div>
            </div>
        </span>
    </label>
</div>

<div class="header2">Статус завершённости книги</div>
<div class="metadata-item direct-to-session">
    <? foreach ($statuses as $status) {
        $checked = $this_status == $status->id ? 'checked' : ''; ?>
        <label class="ui choice-input-block">
            <input type="radio" name="status" value="<?=$status->id?>" <?=$checked?>>
            <span>
                <div class="title-description">
                    <?=$status->title?>
                    <div class="tip"><?=$status->description?></div>
                </div>
            </span>
        </label>
    <?}?>
</div>



<div class="header2">Публичное редактирование</div>
<div class="metadata-item direct-to-session">
    <? foreach ($public_editing as $editing) {
        $checked = $this_public_editing == $editing->id ? 'checked' : ''; ?>
        <label class="ui choice-input-block">
            <input type="radio" name="editing" value="<?=$editing->id?>" <?=$checked?>>
            <span>
                <div class="title-description">
                    <?=$editing->title?>
                    <div class="tip"><?=$editing->description?></div>
                </div>
            </span>
        </label>
    <?}?>
</div>

<div class="ui button icon-button" id="save-access"><?=save_icon?>Сохранить изменения</div>
