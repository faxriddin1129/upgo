<?php

namespace api\modules\v1\controllers;


use api\models\form\LoginForm;
use api\models\form\SettingsForm;
use common\components\ApiController;
use common\models\User;
use Yii;

class UserController extends ApiController
{

    public $modelClass = User::class;

    public function actionSignIn(){
        $queryParams = Yii::$app->getRequest()->getBodyParams();
        $model = new LoginForm();
        $model->setAttributes($queryParams);
        $res = $model->login();
        if (!$res){
            return $model;
        }

        return User::sendUser(true);
    }

    public function actionGetMe(){
        return User::sendUser(false);
    }


    public function actionSettings(){
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        $form = new SettingsForm();
        $form->setAttributes($requestParams);
        $response = $form->save();
        if (!$response){
            return $form;
        }
        return $response;
    }



}