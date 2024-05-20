<?php

namespace app\controllers;

use app\models\_BookData;
use app\models\Forms\FormLogin;
use app\models\Forms\FormSignup;
use app\models\Tables\Book;
use app\models\Tables\User;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $ids = Book::find()->select('id')->where(['<>', 'is_draft', '1'])->andWhere(['<>', 'is_process', '1'])->all();
        $books = [];
        foreach ($ids as $id) {
            $books[$id->id] = new _BookData($id->id);
        }
        return $this->render('index', [
            'books' => $books
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) return $this->goHome();

        $model = new FormLogin();
        /*if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }*/

        if ($model->load(Yii::$app->request->post())) {
            $user = User::findByUsername($model->login);
            $security = Yii::$app->security;
            $salt = $user->salt;
            if ($security->validatePassword($model->password . $salt, $user->password)) {
                Yii::$app->user->login($user);
                return $this->goHome();
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new FormSignup();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->login = $model->login;

            $security = Yii::$app->security;
            $salt = $security->generateRandomString();
            $user->password = $security->generatePasswordHash($model->password . $salt);
            $user->salt = $salt;

            $user->email = $model->email;
            $user->registered_at = new Expression('NOW()');
            //$user->avatar = '';

            if ($user->save()) {
                $url = Url::toRoute('login');
                Yii::$app->getResponse()->redirect($url);
            }
        }
        return $this->render('signup', [
            'model' => $model
        ]);
    }
}
