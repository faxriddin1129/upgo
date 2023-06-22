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

    public function actionIndex($start, $end)
    {
        $id = 0;
        $date = [];
        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER) {
            $id = \Yii::$app->user->id;
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER) {
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

        $f =  Order::STATUS_APPROVED;
        $sql = "SELECT client_id,c.full_name, sum(update_total_price) as amount, c.legal_name, c.location, f.url as url, c.name as name FROM `order`
        LEFT JOIN client c on `order`.client_id = c.id
        LEFT JOIN file f on f.id = c.file_id
        WHERE diller_id = {$id} AND `order`.status={$f} AND `order`.created_at >= {$start} AND `order`.created_at <= {$end}
        group by client_id";
        $activeClients = \Yii::$app->db->createCommand($sql)->queryAll();

        $orders = Order::find()
            ->andWhere(['diller_id' => $id])
            ->andWhere(['status' => Order::STATUS_APPROVED])
            ->andWhere(['>=', 'created_at', $start])
            ->andWhere(['<=', 'created_at', $end])
            ->all();



        $_sql = "SELECT SUM(op.count) as count, sum(op.product_price) as price, op.product_id as product_id, p.name FROM order_product as op
LEFT JOIN `order` o on o.id = op.order_id
LEFT JOIN product p on op.product_id = p.id
WHERE  o.diller_id = {$id} AND o.status={$f}  AND o.created_at >= {$start} AND o.created_at <= {$end}
GROUP BY op.product_id";

        $expen = \Yii::$app->db->createCommand($_sql)->queryAll();
        $newExpen = [];
        $jk = 0;
        $allCount = 0;
        foreach ($expen as $item){
            $allCount += $item['count'];
        }
        foreach ($expen as $item){
            $newExpen[$jk]['count'] = $item['count'];
            $newExpen[$jk]['price'] = $item['price'];
            $newExpen[$jk]['name'] = $item['name'];
            $newExpen[$jk]['expen'] = round(( (100* $item['count']) / ($allCount)  ),3).' %';
            $jk++;
        }







        $i = 0;
        while ($start <= $end) {
            $moment = date('Y-m-d', $start);
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
            'activeClients' => $activeClients,
            'date' => $date,
            'expen' => $newExpen,
            'orders' => $orders,
        ];
    }

}