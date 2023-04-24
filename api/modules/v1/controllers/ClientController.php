<?php

namespace api\modules\v1\controllers;

use api\models\search\ClientSearch;
use common\components\CrudController;
use common\models\Client;
use common\models\Permission;
use common\models\PermissionUser;
use common\models\User;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ClientController extends CrudController
{

    public $modelClass = Client::class;
    public $searchModel = ClientSearch::class;

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['create']);
        unset($parent['delete']);
        return $parent;
    }

    public function beforeAction($action)
    {
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            if ($action->id == 'create'){
                $permission = Permission::findOne(['action_id' => 'client/create']);
                if ($permission){
                    $permissionUser = PermissionUser::findOne(['permission_id' => $permission->id, 'user_id' => \Yii::$app->user->id]);
                    if ($permissionUser){
                        if ($permissionUser->permission == PermissionUser::ACTIVE){
                            return true;
                        }
                    }
                }
                throw new BadRequestHttpException('Permission denied!');
            }
        }
        return true;
    }

    public function actionCreate(){
        $requestParams = \Yii::$app->getRequest()->getBodyParams();
        $user_id = \Yii::$app->user->id;
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $user_id = \Yii::$app->user->identity['parent_id'];
        }
        $model = new Client(['user_id' => $user_id, 'status' => Client::STATUS_ACTIVE]);
        $model->setAttributes($requestParams);
        $model->save();
        return $model;
    }

    public function actionIndex()
    {
        $dataProvider = [];

        $search = new ClientSearch(['user_id' => \Yii::$app->user->id]);
        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER){
            $search = new ClientSearch(['user_id' => \Yii::$app->user->id]);
        }
        $search = new ClientSearch(['user_id' => \Yii::$app->user->id]);
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $search = new ClientSearch(['user_id' => \Yii::$app->user->identity['parent_id']]);
        }


        $dataProvider = $search->search(\Yii::$app->request->queryParams);
        return $dataProvider;
    }


    public function actionDeleted()
    {
        $data = [];
        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER){
            $data = Client::find()->andWhere(['user_id' => \Yii::$app->user->id])->andWhere(['status' => Client::STATUS_DELETED])->all();
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $data = Client::find()->andWhere(['user_id' => \Yii::$app->user->identity['parent_id']])->andWhere(['status' => Client::STATUS_DELETED])->all();
        }
        return $data;
    }

    public function actionDelete($id, $text){
        $model  = Client::findOne(['id' => $id, 'status' => Client::STATUS_ACTIVE]);
        if (!$model){
            throw new NotFoundHttpException('Client not found!');
        }

        $model->status = Client::STATUS_DELETED;
        $model->deleted_description = $text;
        if (!$model->save()){
            return $model;
        }

        return true;
    }
}