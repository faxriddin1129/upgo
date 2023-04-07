<?php

namespace api\modules\v1\controllers;

use api\models\search\OrderSearch;
use common\components\ApiController;
use common\models\Order;

class OrderController extends ApiController
{

    public $modelClass = Order::class;
    public $searchModel = OrderSearch::class;

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        return $parent;
    }

    public function actionIndex()
    {
        $search = new OrderSearch();
        $dataProvider = $search->search(\Yii::$app->request->queryParams);

        return $dataProvider;
    }


}