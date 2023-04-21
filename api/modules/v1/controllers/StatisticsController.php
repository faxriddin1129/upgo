<?php

namespace api\modules\v1\controllers;

use api\models\search\OrderSearch;
use common\components\ApiController;
use common\models\Order;
use common\models\User;

class StatisticsController extends ApiController
{

    public $modelClass = Order::class;
    public $searchModel = OrderSearch::class;

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['view']);
        return $parent;
    }

    public function actionIndex($start,$end)
    {
        $id = 0;
        $date = [];
        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER){
            $id = \Yii::$app->user->id;
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $id = \Yii::$app->user->identity['parent_id'];
        }

        $orderSalesSum = Order::find()
            ->andWhere(['diller_id' => $id])
            ->andWhere(['status' => Order::STATUS_APPROVED])
            ->andWhere(['>=', 'created_at', $start])
            ->andWhere(['<=', 'created_at', $end])
            ->sum('update_total_price');
        $orderGetSum = Order::find()
            ->andWhere(['diller_id' => $id])
            ->andWhere(['status' => Order::STATUS_APPROVED])
            ->andWhere(['>=', 'created_at', $start])
            ->andWhere(['<=', 'created_at', $end])
            ->sum('get_price');


        $i = 0;
        while ($start <= $end){
            $moment = date('Y-m-d',$start);
            $date[$i]['date'] = $moment;
            $sale = Order::find()
                ->andWhere(['diller_id' => $id])
                ->andWhere(['status' => Order::STATUS_APPROVED])
                ->andWhere(['date' => $moment])
                ->sum('update_total_price');
            $get = Order::find()
                ->andWhere(['diller_id' => $id])
                ->andWhere(['status' => Order::STATUS_APPROVED])
                ->andWhere(['date' => $moment])
                ->sum('get_price');
            $date[$i]['get_price'] = $get;
            $date[$i]['sale_price'] = $sale;
            $date[$i]['benefit_price'] = ($sale - $get);

            $start += 86400;
            $i++;
        }


        return [
            'sale_price' => (int)$orderSalesSum,
            'get_price' => (int)$orderGetSum,
            'benefit_price' => ($orderSalesSum - $orderGetSum),
            'date' => $date
        ];
    }

}