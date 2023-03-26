<?php

namespace api\modules\v1\controllers;

use api\models\search\MeasureSearch;
use common\components\CrudController;
use common\models\Measure;

class MeasureController extends CrudController
{

    public $modelClass = Measure::class;
    public $searchModel = MeasureSearch::class;

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['delete']);
        return $parent;
    }

    public function actionIndex()
    {
        $search = new MeasureSearch();
        $dataProvider = $search->search(\Yii::$app->request->queryParams);

        return $dataProvider;
    }


}