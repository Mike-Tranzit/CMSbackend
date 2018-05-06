<?php

namespace cms\modules\v1\controllers;

use Yii;
use cms\modules\v1\models\Information;
use cms\modules\v1\models\Profile;
use cms\modules\v1\models\UserDocs;
use cms\modules\v1\models\InvoicePay;

class ZernovozamController extends Controller
{
    public
        $publicActions = ['options'],
        $collectionOptions = ['GET', 'PUT', 'OPTIONS'],
        $modelClass = '';


    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['searchbylogin'] = ['GET'];
        $verbs['saveprofile'] = ['PUT'];
        $verbs['invoicesconfirm'] = ['PUT'];
        $verbs['userdocslist'] = ['GET'];
        return $verbs;
    }

    public function actionInvoicesconfirm($id){
        $model = new InvoicePay((int)$id);
        $model->Enlistment();
        $model->EnlistmentOfTime();
        return $model->successPay();
    }

    public function actionSaveprofile($id){
        $params = Yii::$app->request->getBodyParams();
        $profile = new Profile($id,$params);
        $profile->save();
        return $profile->information;
    }

    public function actionUserdocslist(){
        $model = new UserDocs();
        $model->loadList();
        return $model->list;
    }

    public function actionSearchbylogin($login){
        $information = new Information($login);
        $information->getUserInformation();
        $information->getInvoices();
        $information->getActiveRequest();
        $information->mobileRegistration();
        return $information->concatDataAndReturn();
    }
}
