<?php

namespace cms\modules\v1\models\failures;

use cms\modules\v1\models\base\PaymentProblemsSolved;
use cms\modules\v1\models\base\PaymentProblemsTypes;
use cms\modules\v1\models\base\Invoices;
use \yii\db\Expression;
use yii\web\ServerErrorHttpException;

class PaymentProblems
{
    const NOT_PAID = 0;
    const MIN_ATTEMPTS_COUNT = 2;
    const MIN_DATE_OF_PROBLEM = 200;

    /**
     * groupProblemByDate
     *
     * @return Invoices[]
     */
    public function groupProblemByDate()
    {
        return Invoices::find()
        ->select([
            'count(invoices.id) as attempts',
            'glonass.users.name',
            'glonass.users.login',
            'datecreate',
            'userIdCreate',
            'date(datecreate) as date'
        ])
        ->innerJoin('glonass.users', 'invoices.userIdCreate = glonass.users.id')
        ->leftJoin('zernovoz.payment_problems_solved', 'invoices.userIdCreate = zernovoz.payment_problems_solved.user_id AND date(invoices.datecreate) = zernovoz.payment_problems_solved.date_of_decision')
        ->where("`status`= :status and datecreate > now() - interval :min_date_of_problem day and zernovoz.payment_problems_solved.id is null", [
            ":status" => self::NOT_PAID,
            ':min_date_of_problem' => self::MIN_DATE_OF_PROBLEM
        ])
        ->groupBy(['userIdCreate', new Expression('date(datecreate)')])
        ->orderBy(['attempts' => SORT_DESC])
        ->having("`attempts` > :attempts", [":attempts" => self::MIN_ATTEMPTS_COUNT])
        ->asArray()->all();
    }

    /**
     * Решение проблемы
     *
     * @return bool
     */
    public function solved($params)
    {
        $model = new PaymentProblemsSolved;
        $model->type_id = (int)$params['type'];
        $model->description = $params['comment'];
        $model->user_id = (int)$params['userIdCreate'];
        $model->date_of_decision = date('Y-m-d', strtotime($params['datecreate']));
        $model->date_task_close = new Expression('NOW()');
        if( $model->save() ) {
            return [
                'userIdCreate' => $model->user_id,
                'date' => $model->date_of_decision
            ];
        } else {
            throw new ServerErrorHttpException($model->errors);
        }
    }

    /**
     * Список типов возможных проблем
     *
     * @return array
     */
    public function types()
    {
        return PaymentProblemsTypes::find()->all();
    }
}
