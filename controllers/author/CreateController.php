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

        return $this->render('new-book', [
            'step' => $step,
        ]);
    }




    // вспомогательные функции
    public function actionLoadStepMain() {
        /*$session = Yii::$app->session;
        $session->set('step', $step);*/

        $relations = Relation::find()->all();
        $ratings = Rating::find()->all();
        $plan_sizes = Size::find()->all();

        $genre_types = GenreType::find()->all();
        $tag_types = TagType::find()->all();


        return $this->renderPartial('steps/step1_main', [
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

        return $this->renderPartial('steps/step2_fandom', [
            'book_types' => $book_types,
        ]);
    }
    public function actionLoadStepCover() {
        /*$session = Yii::$app->session;
        $session->set('step', $step);*/
        return $this->renderPartial('steps/step3_cover');
    }
    public function actionLoadStepAccess() {
        /*$session = Yii::$app->session;
        $session->set('step', $step);*/
        return $this->renderPartial('steps/step4_access');
    }

    public function actionRememberStep() {
        $session = Yii::$app->session;
        $session->set('step', Yii::$app->request->post('step'));
    }
}