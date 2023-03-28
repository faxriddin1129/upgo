<?php

namespace api\modules\v1\controllers;

use api\models\form\DillerForm;
use api\models\search\UserSearch;
use common\components\ApiController;

use common\models\Client;
use common\models\User;
use yii\web\NotFoundHttpException;

class DillerController extends ApiController
{

    public $modelClass = User::class;
    public $searchModel = UserSearch::class;

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['view']);
        return $parent;
    }

    public function actionIndex()
    {
        $search = new UserSearch(['role' => User::ROLE_DILLER]);
        $dataProvider = $search->search(\Yii::$app->request->queryParams);

        return $dataProvider;
    }

    public function actionView($id)
    {
        $search = new UserSearch(['id' => $id]);
        $dataProvider = $search->search(\Yii::$app->request->queryParams);

        return $dataProvider;
    }

    public function actionCreate(){
        $requestParams = \Yii::$app->getRequest()->getBodyParams();
        $model = new DillerForm();
        $model->setAttributes($requestParams);
        $response = $model->save();
        if (!$response){
            return $model;
        }
        return $response;
    }

    public function actionUpdate($id){
        $requestParams = \Yii::$app->getRequest()->getBodyParams();
        $model = new DillerForm(['id' => $id]);
        $model->setAttributes($requestParams);
        $response = $model->update();
        if (!$response){
            return $model;
        }
        return $response;
    }

    public function actionStatus($id, $status){
        $user = User::findOne(['id' => $id]);
        if (!$user){
            throw new NotFoundHttpException('User not found!');
        }
        if ($user and $user->role != User::ROLE_DILLER){
            throw new NotFoundHttpException('User not found!');
        }
        if ($status != User::STATUS_ACTIVE and $status != User::STATUS_INACTIVE and $status != User::STATUS_DELETED){
            throw new NotFoundHttpException('The status value is incorrect');
        }

        $user->status = $status;
        if (!$user->save()){
            return false;
        }

        return true;
    }
}