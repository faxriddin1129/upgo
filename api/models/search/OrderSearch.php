<?php

namespace api\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

/**
 * OrderSearch represents the model behind the search form of `common\models\Order`.
 */
class OrderSearch extends Order
{

    public  $start;
    public  $end;
    public  $agent;
    public  $region_id;
    public  $legal_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'user_id', 'payment_type_id', 'diller_id', 'cashback', 'delivery_time', 'pay_status', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['total_price', 'debt', 'get_price'], 'number'],
            [['start', 'end', 'region_id'], 'integer'],
            [['agent', 'legal_name'], 'string'],
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
        $query = Order::find();

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


        if ($this->start and $this->end){
            $query->andWhere(['>=', 'created_at', $this->start])->andWhere(['<', 'created_at', $this->end]);
        }

        if ($this->agent){
            $this->agent = strtolower($this->agent);
            $query->leftJoin('user u', 'u.id=order.user_id');
            $query->leftJoin('user_detail ud', 'u.id=ud.user_id');
            $query->andFilterWhere(['like', 'first_name', $this->agent]);
        }

        if ($this->legal_name){
            $this->agent = strtolower($this->agent);
            $query->leftJoin('client c', 'c.id=order.client_i   d');
            $query->andFilterWhere(['like', 'legal_name', $this->legal_name]);
        }

        if ($this->region_id){
            $query->leftJoin('client c', 'c.id=order.client_id');
            $query->andFilterWhere(['like', 'region_id', $this->region_id]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'client_id' => $this->client_id,
            'order.user_id' => $this->user_id,
            'diller_id' => $this->diller_id,
            'payment_type_id' => $this->payment_type_id,
            'cashback' => $this->cashback,
            'delivery_time' => $this->delivery_time,
            'total_price' => $this->total_price,
            'debt' => $this->debt,
            'pay_status' => $this->pay_status,
            'get_price' => $this->get_price,
            'status' => $this->status,
        ]);



        return $dataProvider;
    }
}
