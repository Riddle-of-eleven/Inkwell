<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;

$session = Yii::$app->session;
$theme = $session->get('theme');
if (!$theme) {
    $this->registerCssFile('@web/css/themes/system.css');
    $session->set('theme', 'system');
}
else $this->registerCssFile('@web/css/themes/' . $theme . '.css');

$is_open = $session->get('is_open');
if ($is_open == 'open') $this->registerCssFile('@web/css/menu/active.css');

$author_open = $session->has('details.author') ? 'open' : '';
$reader_open = $session->has('details.reader') ? 'open' : '';
$moderator_open = $session->has('details.moderator') ? 'open' : '';
$admin_open = $session->has('details.admin') ? 'open' : '';

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

?>

<?php $this->beginPage() ?>
<!doctype html>
<html lang="<?=Yii::$app->language?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?=Html::csrfMetaTags()?>
    <title><?=Html::encode($this->title)?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<? if (Yii::$app->user->isGuest) : ?>
<div class="side-menu guest-menu block active">
    <div class="sub-side-menu">
        <div class="ui button very-small-button" id="menu-button">
            <?=keyboard_double_arrow_left_icon?>
        </div>

        <div class="side-buttons">
            <?=Html::a(person_icon . '<span class="menu-item hidden">Вход</span>', Url::to(['site/login']), ['class'=> 'ui button small-button', 'id' => 'link-login'])?>
            <?=Html::a(key_vertical_icon . '<span class="menu-item hidden">Регистрация</span>', Url::to(['site/signup']), ['class'=> 'ui button small-button', 'id' => 'link-register'])?>
        </div>
    </div>
</div>

<? else :?>
<div class="side-menu block active">
    <div class="sub-side-menu">
        <div class="ui button very-small-button" id="menu-button">
            <?= keyboard_double_arrow_left_icon ?>
        </div>

        <? $avatar = Yii::$app->user->identity->avatar ? Html::img('@web/images/avatar/uploads/' . Yii::$app->user->identity->avatar . '.png') : 'blank_avatar';
        echo Html::a(
            $avatar . '<span class="menu-item hidden">' . Yii::$app->user->identity->login . '</span>',
            Url::to(['main/author', 'id' => Yii::$app->user->identity->id]),
            ['class' => 'small-profile-picture']
        );?>

        <div class="side-buttons icon-accent">
            <?=Html::a(new_book_icon . '<span class="menu-item hidden">Новая книга</span>', Url::to(['author/create/new-book']))?>
            <a href=""><?= new_project_icon ?><span class="menu-item hidden">Новый проект</span></a>
        </div>

        <div class="line"></div>

        <div class="side-buttons">
            <?= Html::a(person_icon . '<span class="menu-item hidden">Профиль</span>', Url::to(['main/author', 'id' => Yii::$app->user->identity->id])) ?>
            <a href=""><?= mail_icon ?><span class="menu-item hidden">Сообщения</span></a>
            <?= Html::a(notifications_icon . '<span class="menu-item hidden">Уведомления</span>', Url::to(['user/notifications/all'])) ?>
        </div>

        <div class="line"></div>

        <div class="side-buttons">
            <!-- КАБИНЕТ АВТОРА -->
            <div class="to-hide extendable-menu-item" id="extendable-author">
                <?=history_edu_icon?>
                <div class="vertical-expand-line"></div>
                <div class="closed-menu-tooltip block hidden">
                    <div class="menu-tooltip-header"><?=history_edu_icon?>Кабинет автора</div>
                    <div class="menu-tooltip-content">
                        <?= Html::a(book_2_icon . 'Книги', Url::to(['author/author-panel/books-dashboard'])) ?>
                        <?= Html::a(shelves_icon . 'Фэндомы', Url::to(['author/author-panel/fandoms-dashboard'])) ?>
                        <a><?=deployed_code_icon?>Проекты</a>
                        <a><?=bar_chart_icon?>Аналитика</a>
                        <a><?=error_icon?>Сообщения об ошибках</a>
                        <a><?=delete_icon?>Корзина</a>
                    </div>
                </div>
            </div>
            <details class="hidden" id="author-details" <?=$author_open?>>
                <summary>
                    <?=history_edu_icon?>
                    <span class="menu-item hidden">Кабинет автора</span>
                    <div class="expand-icon"><?= expand_more_icon ?></div>
                </summary>
                <div class="side-buttons">
                    <?= Html::a(book_2_icon . '<span class="menu-item hidden">Книги</span>', Url::to(['author/author-panel/books-dashboard'])) ?>
                    <?= Html::a(shelves_icon . '<span class="menu-item hidden">Фэндомы</span>', Url::to(['author/author-panel/fandoms-dashboard'])) ?>
                    <a href=""><?= deployed_code_icon ?><span class="menu-item hidden">Проекты</span></a>
                    <a href=""><?= bar_chart_icon ?><span class="menu-item hidden">Аналитика</span></a>
                    <a href=""><?= error_icon ?><span class="menu-item hidden">Сообщения об ошибках</span></a>
                    <a href=""><?= delete_icon ?><span class="menu-item hidden">Корзина</span></a>
                </div>
            </details>


            <!-- КАБИНЕТ ЧИТАТЕЛЯ -->
            <div class="to-hide extendable-menu-item" id="extendable-reader">
                <?=two_pager_icon?>
                <div class="vertical-expand-line"></div>
                <div class="closed-menu-tooltip block hidden">
                    <div class="menu-tooltip-header"><?=two_pager_icon?>Кабинет читателя</div>
                    <div class="menu-tooltip-content">
                        <?= Html::a(bookmark_icon . 'Библиотека', Url::to(['reader-panel/library'])) ?>
                        <a href=""><?= list_alt_icon ?>Подборки</a>
                        <!--<a href=""><?= chat_icon ?><span class="menu-item hidden">Комментарии и рецензии</span></a>-->
                        <?= Html::a(switch_account_icon . 'Подписки на авторов', Url::to(['reader-panel/followed-authors'])) ?>
                        <?= Html::a(device_reset_icon . 'История просмотра', Url::to(['reader-panel/view-history'])) ?>
                    </div>
                </div>
            </div>
            <details class="hidden" id="reader-details" <?=$reader_open?>>
                <summary>
                    <?=two_pager_icon?>
                    <span class="menu-item hidden">Кабинет читателя</span>
                    <div class="expand-icon"><?=expand_more_icon?></div>
                </summary>
                <div class="side-buttons">
                    <?= Html::a(bookmark_icon . '<span class="menu-item hidden">Библиотека</span>', Url::to(['reader-panel/library'])) ?>
                    <a href=""><?= list_alt_icon ?><span class="menu-item hidden">Подборки</span></a>
                    <!--<a href=""><?= chat_icon ?><span class="menu-item hidden">Комментарии и рецензии</span></a>-->
                    <?= Html::a(switch_account_icon . '<span class="menu-item hidden">Подписки на авторов</span>', Url::to(['reader-panel/followed-authors'])) ?>
                    <?= Html::a(device_reset_icon . '<span class="menu-item hidden">История просмотра</span>', Url::to(['reader-panel/view-history'])) ?>
                </div>
            </details>

            <!--<div class="to-hide"><?= ink_highlighter_icon ?><span class="menu-item hidden">Кабинет помощника</span></div>
            <details class="hidden">
                <summary>
                    <?= ink_highlighter_icon ?>
                    <span class="menu-item hidden">Кабинет помощника</span>
                    <div class="expand-icon"><?= expand_more_icon ?></div>
                </summary>
                <div class="side-buttons">
                    <a href=""><?= book_2_icon ?><span class="menu-item hidden">Редактируемые книги</span></a>
                    <a href=""><?= group_icon ?><span class="menu-item hidden">Книги в соавторстве</span></a>
                </div>
            </details>-->

            <? if (Yii::$app->user->identity->is_moderator == 1) : ?>
                <!-- КАБИНЕТ МОДЕРАТОРА -->
                <div class="to-hide extendable-menu-item" id="extendable-moderator">
                    <?=shield_person_icon?>
                    <div class="vertical-expand-line"></div>
                    <div class="closed-menu-tooltip block hidden">
                        <div class="menu-tooltip-header"><?=shield_person_icon?>Кабинет модератора</div>
                        <div class="menu-tooltip-content">
                            <?= Html::a(lock_open_icon . 'Панель действий', Url::to([''])) ?>
                            <?= Html::a(tag_icon . 'Жанры и теги', Url::to(['moderator/moderator-panel/tags-dashboard'])) ?>
                            <a href=""><?= flag_icon ?>Жалобы и обращения</a>
                            <a href=""><?= block_icon ?>Блокировка пользователей</a>
                        </div>
                    </div>
                </div>
                <details class="hidden" id="moderator-details" <?=$moderator_open?>>
                    <summary>
                        <?= shield_person_icon ?>
                        <span class="menu-item hidden">Кабинет модератора</span>
                        <div class="expand-icon"><?= expand_more_icon ?></div>
                    </summary>
                    <div class="side-buttons">
                        <?= Html::a(lock_open_icon . '<span class="menu-item hidden">Панель действий</span>', Url::to([''])) ?>
                        <?= Html::a(tag_icon . '<span class="menu-item hidden">Жанры и теги</span>', Url::to(['moderator/moderator-panel/tags-dashboard'])) ?>
                        <a href=""><?= flag_icon ?><span class="menu-item hidden">Жалобы и обращения</span></a>
                        <a href=""><?= block_icon ?><span class="menu-item hidden">Блокировка пользователей</span></a>
                    </div>
                </details>
            <? endif; ?>

            <? if (Yii::$app->user->identity->is_admin == 1) : ?>
                <!-- КАБИНЕТ АДМИНИСТРАТОРА -->
                <div class="to-hide extendable-menu-item" id="extendable-admin">
                    <?=passkey_icon?>
                    <div class="vertical-expand-line"></div>
                    <div class="closed-menu-tooltip block hidden">
                        <div class="menu-tooltip-header"><?=passkey_icon?>Кабинет администратора</div>
                        <div class="menu-tooltip-content">
                            <a href=""><?= apartment_icon ?>Издательства</a>
                            <a href=""><?= shield_person_icon ?>Модераторы</a>
                        </div>
                    </div>
                </div>
                <details class="hidden" id="admin-details" <?=$admin_open?>>
                    <summary>
                        <?= passkey_icon ?>
                        <span class="menu-item hidden">Кабинет администратора</span>
                        <div class="expand-icon"><?= expand_more_icon ?></div>
                    </summary>
                    <div class="side-buttons">
                        <a href=""><?= apartment_icon ?><span class="menu-item hidden">Издательства</span></a>
                        <a href=""><?= shield_person_icon ?><span class="menu-item hidden">Модераторы</span></a>
                    </div>
                </details>
            <? endif; ?>


        </div>

        <div class="line"></div>

        <div class="side-buttons">
            <?= Html::a(tune_icon . '<span class="menu-item hidden">Настройки</span>', Url::to(['user/settings/show'])) ?>
        </div>

        <div class="line"></div>

        <div class="side-buttons">
            <a href=""><?= assignment_icon ?><span class="menu-item hidden">Мои обращения</span></a>
        </div>
    </div>

    <div class="sub-side-menu">
        <div class="line"></div>
        <div class="side-buttons logout">
            <?= Html::a(logout_icon . '<span class="menu-item hidden">Выйти</span>', Url::to(['site/logout'], ['data' => ['method' => 'post']])) ?>
        </div>
    </div>
</div>
<? endif; ?>

<header>
    <div class="left-header">
        <?= Html::a('<div class="main-logo">Ink.<span style="color: var(--color-accent)">well</span></div>', Url::to(['site/index']), ['class' => 'no-underline']); ?>


        <label class="ui search-field">
            <?= search_icon ?>
            <input type="text" placeholder="Ищите книги, фэндомы, авторов..." id="main-search">
        </label>
    </div>
    <div class="right-header">
        <a href="" class="ui button icon-button"><?= mystery_icon ?> Поиск по вкусу </a>
        <?= Html::a(shuffle_icon . 'Случайная книга', Url::to(['main/rand-book']), ['class' => 'ui button icon-button']) ?>

        <div class="main-menu-container">
            <div href="" class="ui button small-button" onclick="toggle_menu()"><?= menu_icon ?></div>
            <div class="main-menu-content block hidden">
                <?= Html::a(emoji_objects_icon . 'Ориджиналы', Url::to(['main/originals'])) ?>
                <?= Html::a(menu_book_icon . 'Фанфики', Url::to(['main/fanfics'])) ?>
                <?= Html::a(cognition_icon . 'Авторы', Url::to(['main/authors'])) ?>
                <?= Html::a(shelves_icon . 'Фэндомы', Url::to(['main/fandoms'])) ?>
                <a href=""><?= list_alt_icon ?> Подборки </a>

                <div class="line"></div>

                <a href=""><?= tag_icon ?> Жанры и теги </a>

                <div class="line"></div>

                <a href=""><?= brand_awareness_icon ?> Новости и публикации </a>
                <a href=""><?= news_icon ?> Правила сайта </a>

                <div class="line"></div>

                <?= Html::button(palette_icon . 'Сменить тему', ['class' => 'change-theme text-button ui'])?>
            </div>
        </div>
    </div>
</header>


<dialog class="change-theme-modal block modal">
    <div class="close-button" id="close-theme-change"><?=close_icon?></div>
    <div class="modal-container" id="regular-modal">
        <div class="header3">Выберите одну из предложенных тем</div>
        <div class="themes-container"></div>
    </div>
    <div class="modal-container" id="change-theme-modal"></div>
</dialog>


<div class="line"></div>


<? if (!Yii::$app->user->isGuest) {
    echo Breadcrumbs::widget([
        'homeLink' => [
            'label' => Yii::t('yii', Yii::$app->user->identity->login),
            'url' => Yii::$app->homeUrl,
        ],
        'links' => $this->params['breadcrumbs'] ?? [],
    ]);
} ?>


<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>