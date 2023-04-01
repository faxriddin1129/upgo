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
        $model = new Client(['user_id' => \Yii::$app->user->id, 'status' => Client::STATUS_ACTIVE]);
        $model->setAttributes($requestParams);
        $model->save();
        return $model;
    }

    public function actionIndex()
    {
        $search = new ClientSearch(['user_id' => \Yii::$app->user->id]);
        $dataProvider = $search->search(\Yii::$app->request->queryParams);

        return $dataProvider;
    }

    /**
     * @throws NotFoundHttpException
     */
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