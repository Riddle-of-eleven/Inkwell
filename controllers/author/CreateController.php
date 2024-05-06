<?php

namespace app\controllers\author;

use app\models\Tables\Genre;
use app\models\Tables\GenreType;
use app\models\Tables\Rating;
use app\models\Tables\Relation;
use app\models\Tables\Size;
use app\models\Tables\TagType;
use app\models\Tables\Type;
use Yii;
use yii\web\Controller;

class CreateController extends Controller
{
    public function actionNewBook() {
        $session = Yii::$app->session;
        $step = $session->has('step') ? $session->get('step') : 'main';
        $session['create.aaa'] = 'aaa';


        return $this->render('new-book', [
            'step' => $step,
        ]);
    }




    // вспомогательные функции
    public function actionLoadStepMain() {
        $session = Yii::$app->session;

        $create_title = $session->get('create.title');
        $create_description = $session->get('create.description');
        $create_remark = $session->get('create.remark');
        $create_disclaimer = $session->get('create.disclaimer');
        $create_dedication = $session->get('create.dedication');

        $create_relation = $session->get('create.relation');
        $create_rating = $session->get('create.rating');
        $create_plan_size = $session->get('create.plan_size');


        $relations = Relation::find()->all();
        $ratings = Rating::find()->all();
        $plan_sizes = Size::find()->all();

        $genre_types = GenreType::find()->all();
        $tag_types = TagType::find()->all();


        return $this->renderAjax('steps/step1_main', [
            // данные как из формы
            'create_title' => $create_title,
            'create_description' => $create_description,
            'create_remark' => $create_remark,
            'create_disclaimer' => $create_disclaimer,
            'create_dedication' => $create_dedication,

            'create_relation' => $create_relation,
            'create_rating' => $create_rating,
            'create_plan_size' => $create_plan_size,

            // прочие данные
            'relations' => $relations,
            'ratings' => $ratings,
            'plan_sizes' => $plan_sizes,

            'genre_types' => $genre_types,
            'tag_types' => $tag_types,
        ]);
    }
    public function actionLoadStepFandom() {
        /*$session = Yii::$app->session;
        $session->set('step', $step);*/

        $book_types = Type::find()->all();

        return $this->renderAjax('steps/step2_fandom', [
            'book_types' => $book_types,
        ]);
    }
    public function actionLoadStepCover() {
        /*$session = Yii::$app->session;
        $session->set('step', $step);*/
        return $this->renderAjax('steps/step3_cover');
    }
    public function actionLoadStepAccess() {
        /*$session = Yii::$app->session;
        $session->set('step', $step);*/
        return $this->renderAjax('steps/step4_access');
    }

    public function actionRememberStep() {
        $session = Yii::$app->session;
        $session->set('step', Yii::$app->request->post('step'));
    }


    public function actionSaveData() {
        $session = Yii::$app->session;
        $session_key = Yii::$app->request->post('session_key');
        $data = Yii::$app->request->post('data');
        $session->set('create.' . $session_key, $data);
    }
}