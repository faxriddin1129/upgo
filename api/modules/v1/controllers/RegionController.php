<?php

namespace api\modules\v1\controllers;

use api\models\search\RegionSearch;
use common\components\CrudController;
use common\models\Region;

class RegionController extends CrudController
{

    public $modelClass = Region::class;
    public $searchModel = RegionSearch::class;

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['delete']);
        return $parent;
    }

    public function actionIndex()
    {
        $search = new RegionSearch();
        $dataProvider = $search->search(\Yii::$app->request->queryParams);

        return $dataProvider;
    }


}