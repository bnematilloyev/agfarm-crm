<?php

namespace merchant\models\search;

use common\models\Order;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Action;

/**
 * ActionSearch represents the model behind the search form of `common\models\Action`.
 */
class ActionSearch extends Action
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'market_id', 'user_id', 'product_id', 'customer_id', 'created_at', 'updated_at'], 'integer'],
            [['cost', 'price', 'quantity', 'prepaid', 'leasing', 'profit'], 'number'],
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
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $orders = Order::find()->all();
        $ids = [];
        foreach ($orders as $order)
            $ids[] = $order->id;
        $query = Action::find()->where(['not', ['in', 'order_id', $ids]]);

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
            'company_id' => $this->company_id,
            'market_id' => $this->market_id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'customer_id' => $this->customer_id,
            'cost' => $this->cost,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'prepaid' => $this->prepaid,
            'leasing' => $this->leasing,
            'profit' => $this->profit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */

    public function search_wrong($params)
    {
        $orders = Order::find()->all();
        $ids = [];
        foreach ($orders as $order)
            $ids[] = $order->id;
        $query = Action::find()->where(['not', ['in', 'order_id', $ids]]);

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
            'company_id' => $this->company_id,
            'market_id' => $this->market_id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'customer_id' => $this->customer_id,
            'cost' => $this->cost,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'prepaid' => $this->prepaid,
            'leasing' => $this->leasing,
            'profit' => $this->profit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search_by_user_id($params, $user_id)
    {
        $query = Action::find()->with(['market', 'user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        $query->andWhere(['user_id' => $user_id]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search_by_order_id($params, $order_id)
    {
        $query = Action::find()->where(['order_id' => $order_id]);

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

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search_by_product_id($params, $product_id)
    {
        $query = Action::find()->where(['product_id' => $product_id]);

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
            'company_id' => $this->company_id,
            'market_id' => $this->market_id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'customer_id' => $this->customer_id,
            'cost' => $this->cost,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'prepaid' => $this->prepaid,
            'leasing' => $this->leasing,
            'profit' => $this->profit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @param $market_id
     * @return ActiveDataProvider
     */
    public function search_by_market_id($params, $market_id)
    {
        $query = Action::find()->where(['market_id' => $market_id]);

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
            'company_id' => $this->company_id,
            'market_id' => $this->market_id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'customer_id' => $this->customer_id,
            'cost' => $this->cost,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'prepaid' => $this->prepaid,
            'leasing' => $this->leasing,
            'profit' => $this->profit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}