<?php

namespace api\modules\v1\controllers;

use api\models\form\EmployeeForm;
use api\models\search\ClientSearch;
use api\models\search\UserSearch;
use common\components\CrudController;
use common\models\Client;
use common\models\Order;
use common\models\User;
use common\models\UserDetail;
use common\models\WorkingDays;
use yii\web\BadRequestHttpException;
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

    public function actionOrders()
    {

        $data = [];
        $i = 0;
        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER){
            $search = User::find()->andWhere(['role' => User::ROLE_SUP_DILLER, 'parent_id' => \Yii::$app->user->id])->all();
        }

        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $search = User::find()->andWhere(['role' => User::ROLE_SUP_DILLER, 'parent_id' => \Yii::$app->user->identity['parent_id']])->all();
        }


        foreach ($search as $user){

            if (Order::findOne(['user_id' => $user['id']])){
                $data[$i++] = $user;
            }

        }

        if (Order::findOne(['user_id' => \Yii::$app->user->id])){
            $data[$i++] = \Yii::$app->user->identity;
        }


        return $data;
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

    public function actionStatistics($id,$start,$end){

        return Order::find()
            ->andWhere(['user_id' => $id])
            ->andWhere(['>=', 'created_at', $start])
            ->andWhere(['<', 'created_at', $end])
            ->all();
    }

    public function actionSalary($id,$start,$end){

        $user = UserDetail::findOne(['user_id' => $id]);
        if (!$user){
            throw new NotFoundHttpException('User not found!');
        }

        $approved_total_price = Order::find()
            ->andWhere(['user_id' => $id])
            ->andWhere(['status' => Order::STATUS_APPROVED])
            ->andWhere(['>=', 'created_at', $start])
            ->andWhere(['<', 'created_at', $end])
            ->sum('update_total_price');

        $salary = $user->salary_int;
        $salary_percent = $user->salary_percent;

        return [
            'total_sales' => (int)$approved_total_price,
            'salary_percent' => $salary_percent,
            'salary' => $salary,
            'total_salary' => ($salary + ( ((int)$approved_total_price) * ($salary_percent/100) )),
        ];
    }


    public function actionWorkDays($id){
        $user = UserDetail::findOne(['user_id' => $id]);
        if (!$user){
            throw new NotFoundHttpException('User not found!');
        }

        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER){
            $clients = Client::find()
                ->leftJoin('working_days wd','client.id=wd.client_id')
                ->andWhere(['client.user_id' => \Yii::$app->user->id])
                ->andWhere(['wd.client_id' => null])
                ->andWhere(['status' => Client::STATUS_ACTIVE])
                ->all();
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $clients = Client::find()
                ->leftJoin('working_days wd','client.id=wd.client_id')
                ->andWhere(['client.user_id' => \Yii::$app->user->identity['parent_id']])
                ->andWhere(['wd.client_id' => null])
                ->andWhere(['status' => Client::STATUS_ACTIVE])
                ->all();
        }

        return $clients;
    }

    public function actionWorkDaysAll($id,$day_id){
        $user = UserDetail::findOne(['user_id' => $id]);
        if (!$user){
            throw new NotFoundHttpException('User not found!');
        }

        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER){
            $clients = Client::find()
                ->leftJoin('working_days wd','client.id=wd.client_id')
                ->andWhere(['wd.user_id' => $id])
                ->andWhere(['status' => Client::STATUS_ACTIVE])
                ->all();
            if ($day_id){
                $clients = Client::find()
                    ->leftJoin('working_days wd','client.id=wd.client_id')
                    ->andWhere(['wd.user_id' => $id])
                    ->andWhere(['wd.day_id' => $day_id])
                    ->andWhere(['status' => Client::STATUS_ACTIVE])
                    ->all();
            }
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $clients = Client::find()
                ->leftJoin('working_days wd','client.id=wd.client_id')
                ->andWhere(['wd.user_id' => $id])
                ->all();
            if ($day_id){
                $clients = Client::find()
                    ->leftJoin('working_days wd','client.id=wd.client_id')
                    ->andWhere(['wd.user_id' => $id])
                    ->andWhere(['wd.day_id' => $day_id])
                    ->all();
            }
        }

        return $clients;
    }

    public function actionWorkCreate($id,$client_id,$day_id){
        $workingCheck = WorkingDays::findOne(['client_id' => $client_id, 'day_id' => $day_id]);
        if ($workingCheck){
            throw new BadRequestHttpException('Already another employee busy!');
        }

        if (!User::findOne(['id' => $id])){
            throw new BadRequestHttpException('Employee not found!');
        }

        if (!Client::findOne(['id' => $client_id])){
            throw new BadRequestHttpException('Client not found!');
        }

        $workingDays = new WorkingDays();
        $workingDays->client_id = $client_id;
        $workingDays->user_id = $id;
        $workingDays->day_id = $day_id;
        if (!$workingDays->save()){
            return $workingDays->getErrors();
        }

        return true;
    }

    public function actionWorkDelete($id,$client_id,$day_id){
        if (!User::findOne(['id' => $id])){
            throw new BadRequestHttpException('Employee not found!');
        }

        if (!Client::findOne(['id' => $client_id])){
            throw new BadRequestHttpException('Client not found!');
        }

        $workingCheck = WorkingDays::findOne(['client_id' => $client_id, 'day_id' => $day_id, 'user_id' => $id]);
        if (!$workingCheck){
            throw new BadRequestHttpException('Working days not found!');
        }

        return $workingCheck->delete();
    }

}