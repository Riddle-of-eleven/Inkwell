<?php

namespace app\controllers;

use app\models\Book;
use app\models\FormSignup;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\FormLogin;
use yii\db\Expression;
use app\models\_BookData;


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
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new FormLogin();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }

        /*if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            VarDumper::dump(Yii::$app->request->post(), 10, true);
            VarDumper::dump($model->attributes, 10, true);
            die;
        }*/

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
            //$user->password = Yii::$app->security->generatePasswordHash($model->password);
            $user->password = $model->password;
            $user->email = $model->email;
            $user->registered_at = new Expression('NOW()');

            if ($user->save()) return $this->goHome();
        }
        return $this->render('signup', [
            'model' => $model
        ]);
    }
}
