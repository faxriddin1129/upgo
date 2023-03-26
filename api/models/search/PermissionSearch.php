<?php

namespace api\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Permission;

/**
 * PermissionSearch represents the model behind the search form of `common\models\Permission`.
 */
class PermissionSearch extends Permission
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'permission'], 'integer'],
            [['position', 'name', 'action_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Permission::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'permission' => $this->permission,
        ]);

        $query->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'action_id', $this->action_id]);

        return $dataProvider;
    }
}
