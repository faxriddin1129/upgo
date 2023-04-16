<?php

namespace api\modules\v1\controllers;

use api\models\search\PaymentTypeSearch;
use common\components\CrudController;
use common\models\PaymentType;

class PaymentTypeController extends CrudController
{

    public $modelClass = PaymentType::class;
    public $searchModel = PaymentTypeSearch::class;

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['delete']);
        return $parent;
    }

    public function actionIndex()
    {
        $search = new PaymentTypeSearch();
        $dataProvider = $search->search(\Yii::$app->request->queryParams);

        return $dataProvider;
    }


}