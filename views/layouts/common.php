<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;

$session = Yii::$app->session;
$theme = $session->get('theme');
if (!$theme) $this->registerCssFile('@web/css/themes/system.css');
else $this->registerCssFile('@web/css/themes/' . $theme . '.css');

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
<div class="side-menu guest-menu block">
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
<div class="side-menu block">
    <div class="sub-side-menu">
        <div class="ui button very-small-button" id="menu-button">
            <?= keyboard_double_arrow_left_icon ?>
        </div>
        <div class="small-profile-picture">
            <? $id = Yii::$app->user->identity->id;
                $user = \app\models\User::find()->select('avatar')->where(['id' => $id])->one(); ?>
            <?= Html::img('@web/'.$user->avatar) ?>
            <span class="menu-item hidden"><?= Yii::$app->user->identity->login ?></:></span>
        </div>

        <div class="side-buttons icon-accent">
            <?=Html::a(new_book_icon . '<span class="menu-item hidden">Новая книга</span>', Url::to(['author/create-book/create-main']))?>
            <a href=""><?= new_project_icon ?><span class="menu-item hidden">Новый проект</span></a>
        </div>

        <div class="line"></div>

        <div class="side-buttons">
            <?= Html::a(person_icon . '<span class="menu-item hidden">Профиль</span>', Url::to(['main/author', 'id' => $id])) ?>
            <a href=""><?= mail_icon ?><span class="menu-item hidden">Сообщения</span></a>
            <a href=""><?= notifications_icon ?><span class="menu-item hidden">Уведомления</span></a>
        </div>

        <div class="line"></div>

        <div class="side-buttons">
            <div class="to-hide"><?= history_edu_icon ?><span class="menu-item hidden">Кабинет автора</span></div>
            <details class="hidden">
                <summary>
                    <?= history_edu_icon ?>
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

            <div class="to-hide"><?= two_pager_icon ?><span class="menu-item hidden">Кабинет читателя</span></div>
            <details class="hidden">
                <summary>
                    <?= two_pager_icon ?>
                    <span class="menu-item hidden">Кабинет читателя</span>
                    <div class="expand-icon"><?= expand_more_icon ?></div>
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

            <? if (Yii::$app->user->getIdentity()->is_moderator == 1) : ?>
                <div class="to-hide"><?= shield_person_icon ?><span class="menu-item hidden">Кабинет модератора</span></div>
                <details class="hidden">
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


        </div>

        <div class="line"></div>

        <div class="side-buttons">
            <a href=""><?= tune_icon ?><span class="menu-item hidden">Настройки</span></a>
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
        <div class="ui search-field">
            <?= search_icon ?>
            <input type="text" placeholder="Ищите книги, фэндомы, авторов...">
        </div>
    </div>
    <div class="right-header">
        <a href="" class="ui button icon-button"><?= mystery_icon ?> Поиск по вкусу </a>
        <?= Html::a(shuffle_icon . 'Случайная книга', Url::to(['main/rand-book']), ['class' => 'ui button icon-button']) ?>

        <div class="main-menu-container">
            <div href="" class="ui button small-button" onclick="toggle_menu()"><?= menu_icon ?></div>
            <div class="main-menu-content block hidden">
                <a href=""><?= emoji_objects_icon ?> Ориджиналы </a>
                <a href=""><?= menu_book_icon ?> Фанфики </a>
                <a href=""><?= cognition_icon ?> Авторы </a>
                <a href=""><?= shelves_icon ?> Фэндомы </a>
                <a href=""><?= list_alt_icon ?> Подборки </a>

                <div class="line"></div>

                <a href=""><?= tag_icon ?> Жанры и теги </a>

                <div class="line"></div>

                <a href=""><?= brand_awareness_icon ?> Новости и публикации </a>
                <a href=""><?= news_icon ?> Правила сайта </a>

                <div class="line"></div>

                <button class="change-theme text-button ui"><?=palette_icon?>Сменить тему</button>
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