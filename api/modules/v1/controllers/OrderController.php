<?php

namespace api\modules\v1\controllers;

use api\models\form\OrderForm;
use api\models\search\OrderSearch;
use common\components\CrudController;
use common\models\Order;
use common\models\User;
use yii\web\NotFoundHttpException;

class OrderController extends CrudController
{

    public $modelClass = Order::class;
    public $searchModel = OrderSearch::class;

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['update']);
        unset($parent['create']);
        return $parent;
    }

    public function actionIndex()
    {
        $dataProvider = [];
        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER){
            $search = new OrderSearch(['diller_id' => \Yii::$app->user->id]);
            $dataProvider = $search->search(\Yii::$app->request->queryParams);
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $search = new OrderSearch(['user_id' => \Yii::$app->user->id]);
            $dataProvider = $search->search(\Yii::$app->request->queryParams);
        }
        return $dataProvider;
    }

    public function actionCreate()
    {
        $queryParams = \Yii::$app->getRequest()->getBodyParams();
        $model = new OrderForm();
        $model->setAttributes($queryParams);
        $response = $model->save();
        if (!$response){
            return $model;
        }

        return $response;
    }

    public function actionUpdate($id)
    {
        $queryParams = \Yii::$app->getRequest()->getBodyParams();
        $model = new OrderForm(['order_id' => $id]);
        $model->setAttributes($queryParams);
        $response = $model->update();
        if (!$response){
            return $model;
        }

        return $response;
    }

    public function actionPending($id){
        $model = Order::findOne(['id' => $id]);
        if (!$model){
            throw new NotFoundHttpException('Order not found!');
        }

        $model->updateAttributes(['status' => Order::STATUS_PENDING]);
        return true;
    }


}