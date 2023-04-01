<?php

namespace api\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Client;

/**
 * ClientSearch represents the model behind the search form of `common\models\Client`.
 */
class ClientSearch extends Client
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'region_id', 'file_id', 'status'], 'integer'],
            [['legal_name', 'name', 'address', 'location', 'nearby', 'inn', 'deleted_description'], 'safe'],
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
        $query = Client::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->load($params) && $params) {
            if (array_key_exists('filter',$params)){
                $this->setAttributes($params['filter']);
            }
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'region_id' => $this->region_id,
            'file_id' => $this->file_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'legal_name', $this->legal_name])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'nearby', $this->nearby])
            ->andFilterWhere(['like', 'inn', $this->inn])
            ->andFilterWhere(['like', 'deleted_description', $this->deleted_description]);

        $query->andWhere(['<>', 'status', Client::STATUS_DELETED]);

        return $dataProvider;
    }
}
