<?php

namespace api\modules\v1\controllers;

use api\models\form\ProductForm;
use api\models\search\ProductSearch;
use common\components\CrudController;
use common\models\Product;
use common\models\User;

class ProductController extends CrudController
{

    public $modelClass = Product::class;
    public $searchModel = ProductSearch::class;

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['create']);
        unset($parent['update']);
        return $parent;
    }

    public function actionIndex()
    {
        $dataProvider = [];
        if (\Yii::$app->user->identity['role'] == User::ROLE_DILLER){
            $search = new ProductSearch(['user_id' => \Yii::$app->user->id]);
            $dataProvider = $search->search(\Yii::$app->request->queryParams);
        }
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $search = new ProductSearch(['user_id' => \Yii::$app->user->identity['parent_id']]);
            $dataProvider = $search->search(\Yii::$app->request->queryParams);
        }

        return $dataProvider;
    }

    public function actionCreate(){
        $queryParams = \Yii::$app->getRequest()->getBodyParams();
        $model = new ProductForm();
        $model->setAttributes($queryParams);
        $response = $model->save();
        if (!$response){
            return $model;
        }

        return $response;
    }

    public function actionUpdate($id){
        $queryParams = \Yii::$app->getRequest()->getBodyParams();
        $model = new ProductForm(['id' => $id]);
        $model->setAttributes($queryParams);
        $response = $model->update();
        if (!$response){
            return $model;
        }

        return $response;
    }


}