<?

namespace cms\modules\v1\controllers;

use cms\modules\v1\models\failures\PaymentProblems;
use Yii;

class FailuresController extends Controller
{

    public
        $publicActions = ['options'],
        $collectionOptions = ['GET', 'POST', 'OPTIONS'],
        $modelClass = '';


    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['gettypes'] = ['GET'];
        $verbs['solved'] = ['POST'];
        $verbs['getlist'] = ['GET'];
        return $verbs;
    }

    /**
     * Список типов возможных проблем пользователей при оплате
     *
     * @return array
     */
    public function actionGettypes()
    {
        $model = new PaymentProblems();
        return $model->types();
    }

    /**
     * Список проблемных пользователей
     *
     * @return array
     */
    public function actionGetlist()
    {
        $model = new PaymentProblems();
        return $model->groupProblemByDate();
    }

    /**
     * Задача решена
     *
     * @return array
     */
    public function actionSolved()
    {
        $params = Yii::$app->request->getBodyParams();
        $model = new PaymentProblems();
        return $model->solved($params);
    }
}