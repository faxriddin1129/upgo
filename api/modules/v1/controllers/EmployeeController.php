<?php

namespace api\modules\v1\controllers;

use api\models\form\EmployeeForm;
use api\models\search\UserSearch;
use common\components\CrudController;
use common\models\User;
use yii\web\NotFoundHttpException;

class EmployeeController extends CrudController
{

    public $modelClass = User::class;
    public $searchModel = UserSearch::class;

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['create']);
        unset($parent['update']);
        unset($parent['delete']);
        return $parent;
    }

    public function actionIndex()
    {
        $search = new UserSearch(['role' => User::ROLE_SUP_DILLER]);

        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER){
            $search = new UserSearch(['role' => User::ROLE_SUP_DILLER, 'parent_id' => \Yii::$app->user->id]);
        }

        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $search = new UserSearch(['role' => User::ROLE_SUP_DILLER, 'parent_id' => \Yii::$app->user->identity['parent_id']]);
        }

        $dataProvider = $search->search(\Yii::$app->request->queryParams);

        return $dataProvider;
    }

    public function actionCreate(){
        $queryParams = \Yii::$app->getRequest()->getBodyParams();
        $model = new EmployeeForm();
        $model->setAttributes($queryParams);
        $response = $model->save();
        if (!$response){
            return $model;
        }

        return $response;
    }

    public function actionUpdate($id){
        $queryParams = \Yii::$app->getRequest()->getBodyParams();
        $model = new EmployeeForm(['id' => $id]);
        $model->setAttributes($queryParams);
        $response = $model->update();
        if (!$response){
            return $model;
        }

        return $response;
    }

    public function actionDelete($id){
        $user = User::findOne(['id' => $id]);
        if (!$user){
            throw new NotFoundHttpException('User not found!');
        }

        $user->status = User::STATUS_DELETED;
        if ($user->save()){
            return true;
        }

        return false;
    }

}