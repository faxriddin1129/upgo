<?php

namespace api\modules\v1\controllers;

use api\models\search\PermissionSearch;
use common\components\CrudController;
use common\models\Permission;

class PermissionController extends CrudController
{

    public $modelClass = Permission::class;
    public $searchModel = PermissionSearch::class;

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['delete']);
        return $parent;
    }

    public function actionIndex()
    {
        $search = new PermissionSearch();
        $dataProvider = $search->search(\Yii::$app->request->queryParams);

        return $dataProvider;
    }


}