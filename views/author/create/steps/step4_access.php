<?php
/** @var yii\web\View $this */

/* @var $create_public_editing int */
/* @var $create_coauthor User */
/* @var $create_beta User */
/* @var $create_gamma User */

/* @var $public_editing PublicEditing[] */

use app\models\Tables\PublicEditing;
use app\models\Tables\User;
use yii\helpers\VarDumper;
use yii\helpers\Html;

$session = Yii::$app->session;
//VarDumper::dump($session->get('create.coauthor'), 10, true);
//$session->remove('create.coauthor');
//$session->remove('create.beta');
//$session->remove('create.gamma');

$coauthor_field_hidden = $create_coauthor ? 'hidden' : '';
$beta_field_hidden = $create_beta ? 'hidden' : '';
$gamma_field_hidden = $create_gamma ? 'hidden' : '';

$coauthor_hidden = $create_coauthor ? '' : 'hidden';
$beta_hidden = $create_beta ? '' : 'hidden';
$gamma_hidden = $create_gamma ? '' : 'hidden';

?>

<div class="header2">Общие параметры</div>

<!-- ПУБЛИЧНОЕ РЕДАКТИРОВАНИЕ -->
<div class="metadata-item direct-to-session">
    <div class="header3 metadata-item-title" id="step-meta-public_editing">
        <div>Публичное редактирование <span class="required-symbol">*</span></div>
    </div>
    <div class="input-block-list" id="step-meta-public_editing">
        <? foreach ($public_editing as $editing) {
            $editing_checked = $editing->id == $create_public_editing ? 'checked' : ''; ?>
            <label class="ui choice-input-block">
                <input type="radio" name="rating" value="<?=$editing->id?>" <?=$editing_checked?>>
                <span>
                    <div class="title-description">
                        <?=$editing->title?>
                        <div class="tip"><?=$editing->description?></div>
                    </div>
                </span>
            </label>
        <?}?>
    </div>
    <div class="input-error"></div>
</div>



<div class="header2">Соавтор</div>
<div class="head-article">На данный момент вы можете добавить только одного соавтора</div>

<!-- СОАВТОР -->
<div class="metadata-item chosen-items-to-session coauthor-item user-item">
    <div class="field-with-dropdown <?=$coauthor_field_hidden?>">
        <div class="ui field"><input type="text" name="step-meta-coauthor" id="step-meta-coauthor" placeholder="Введите первые несколько символов" maxlength="150"></div>
    </div>
    <div class="metadata-item-selected metadata-user-selected <?=$coauthor_hidden?>">
        <? if ($create_coauthor) : ?>
            <div class="metadata-item-selected-unit metadata-user-item-selected block select-header" meta="<?=$create_coauthor->id?>">
                <div class="select-header-expand">
                    <div class="small-profile-picture"><?= !$create_coauthor->avatar ? blank_avatar : Html::img('@web/images/avatar/uploads/' . $create_coauthor->avatar . '.png') ?></div>
                    <div class="metadata-title"><?=$create_coauthor->login?></div>
                </div>
                <div class="ui button small-button danger-accent-button remove-user"><?=delete_icon_class?></div>
            </div>
        <? endif; ?>
    </div>
    <div class="input-error"></div>
</div>


<div class="header2">Редакторы</div>
<div class="head-article">На данный момент вы можете добавить одну бету и одну гамму</div>

<!-- БЕТА -->
<div class="metadata-item chosen-items-to-session beta-item user-item">
    <div class="header3 metadata-item-title">Бета</div>
    <div class="field-with-dropdown <?=$beta_field_hidden?>">
        <div class="ui field"><input type="text" name="step-meta-beta" id="step-meta-beta" placeholder="Введите первые несколько символов" maxlength="150"></div>
    </div>
    <div class="metadata-item-selected metadata-user-selected <?=$beta_hidden?>">
        <? if ($create_beta) : ?>
            <div class="metadata-item-selected-unit metadata-user-item-selected block select-header" meta="<?=$create_beta->id?>">
                <div class="select-header-expand">
                    <div class="small-profile-picture"><?= !$create_beta->avatar ? blank_avatar : Html::img('@web/images/avatar/uploads/' . $create_beta->avatar . '.png') ?></div>
                    <div class="metadata-title"><?=$create_beta->login?></div>
                </div>
                <div class="ui button small-button danger-accent-button remove-user"><?=delete_icon_class?></div>
            </div>
        <? endif; ?>
    </div>
    <div class="input-error"></div>
</div>

<!-- ГАММА -->
<div class="metadata-item chosen-items-to-session gamma-item user-item">
    <div class="header3 metadata-item-title">Гамма</div>
    <div class="field-with-dropdown <?=$gamma_field_hidden?>">
        <div class="ui field"><input type="text" name="step-meta-gamma" id="step-meta-gamma" placeholder="Введите первые несколько символов" maxlength="150"></div>
    </div>
    <div class="metadata-item-selected metadata-user-selected <?=$gamma_hidden?>">
        <? if ($create_gamma) : ?>
            <div class="metadata-item-selected-unit metadata-user-item-selected block select-header" meta="<?=$create_gamma->id?>">
                <div class="select-header-expand">
                    <div class="small-profile-picture"><?= !$create_gamma->avatar ? blank_avatar : Html::img('@web/images/avatar/uploads/' . $create_gamma->avatar . '.png') ?></div>
                    <div class="metadata-title"><?=$create_gamma->login?></div>
                </div>
                <div class="ui button small-button danger-accent-button remove-user"><?=delete_icon_class?></div>
            </div>
        <? endif; ?>
    </div>
    <div class="input-error"></div>
</div>