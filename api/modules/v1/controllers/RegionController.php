<?php

namespace api\modules\v1\controllers;

use api\models\search\RegionSearch;
use common\components\CrudController;
use common\models\Category;
use common\models\Region;
use common\models\User;

class RegionController extends CrudController
{

    public $modelClass = Region::class;
    public $searchModel = RegionSearch::class;

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['delete']);
        unset($parent['create']);
        return $parent;
    }

    public function actionIndex()
    {
        $diller_id = \Yii::$app->user->id;
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $diller_id = \Yii::$app->user->identity['parent_id'];
        }
        $search = new RegionSearch(['diller_id' => $diller_id]);
        $dataProvider = $search->search(\Yii::$app->request->queryParams);

        return $dataProvider;
    }


    public function actionCreate()
    {
        $queryParam = \Yii::$app->getRequest()->getBodyParams();
        $model = new Region();
        $diller_id = \Yii::$app->user->id;
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $diller_id = \Yii::$app->user->identity['parent_id'];
        }
        $model->diller_id = $diller_id;
        $model->setAttributes($queryParam);
        if (!$model->save()){
            return $model->getErrors();
        }

        return $model;
    }


}