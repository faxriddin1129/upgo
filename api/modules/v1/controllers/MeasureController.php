<?php

namespace api\modules\v1\controllers;

use api\models\search\MeasureSearch;
use common\components\CrudController;
use common\models\Measure;
use common\models\User;

class MeasureController extends CrudController
{

    public $modelClass = Measure::class;
    public $searchModel = MeasureSearch::class;

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['delete']);
        unset($parent['create']);
        return $parent;
    }

    public function actionCreate()
    {
        $queryParam = \Yii::$app->getRequest()->getBodyParams();
        $model = new Measure();
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

    public function actionIndex()
    {
        $diller_id = \Yii::$app->user->id;
        if (\Yii::$app->user->identity['role'] == User::ROLE_SUP_DILLER){
            $diller_id = \Yii::$app->user->identity['parent_id'];
        }
        $search = new MeasureSearch(['diller_id' => $diller_id]);
        $dataProvider = $search->search(\Yii::$app->request->queryParams);

        return $dataProvider;
    }


}