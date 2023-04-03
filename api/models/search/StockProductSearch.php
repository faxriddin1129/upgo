<?php

namespace api\models\search;

use common\models\Category;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StockProduct;

/**
 * StockProductSearch represents the model behind the search form of `common\models\StockProduct`.
 */
class StockProductSearch extends StockProduct
{

    public $name;
    public $category_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'stock_id', 'category_id'], 'integer'],
            [['count'], 'number'],
            [['name'], 'string'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
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
        $query = StockProduct::find();

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
            'product_id' => $this->product_id,
            'count' => $this->count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'stock_id' => $this->stock_id,
        ]);

        if ($this->name){
            $this->name = strtolower($this->name);
            $query->leftJoin('product p', 'p.id=stock_product.product_id')
                ->andFilterWhere(['like', 'name', $this->name]);
        }

        if ($this->category_id){
            $this->category_id = strtolower($this->category_id);
            $query->leftJoin('product p', 'p.id=stock_product.product_id');
            $query->leftJoin('category c', 'c.id=p.id')
                ->andFilterWhere(['like', 'category_id', $this->category_id]);
        }

        return $dataProvider;
    }
}

