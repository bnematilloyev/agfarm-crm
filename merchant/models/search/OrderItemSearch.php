<?php

namespace merchant\models\search;

use common\models\Order;
use common\models\OrderItem;
use pay\models\Customer;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderItemSearch represents the model behind the search form of `common\models\OrderItem`.
 */
class OrderItemSearch extends OrderItem
{
    public $to_date_range;
    public $from_date_range;

    public $to_date_range_starts;
    public $from_date_range_starts;

    public $to_date_range_update;
    public $from_date_range_update;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cheque', 'order_id', 'customer_id', 'company_id', 'market_id', 'status', 'starts_in', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'number'],
            [['remote_id', 'transaction_id', 'terminal_id', 'to_date_range', 'from_date_range', 'to_date_range_starts', 'from_date_range_starts', 'to_date_range_update', 'from_date_range_update'], 'safe'],
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
        $query = OrderItem::findActive();

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
        if ($this->to_date_range_starts !== "" && !is_null($this->to_date_range_starts)) {
            $start_date = strtotime($this->from_date_range_starts);
            $end_date = strtotime($this->to_date_range_starts) + 60 * 60 * 24;
            $query->andFilterWhere(['between', 'starts_in', $start_date, $end_date]);
        }

        if ($this->to_date_range !== "" && !is_null($this->to_date_range)) {
            $start_date = strtotime($this->from_date_range);
            $end_date = strtotime($this->to_date_range) + 60 * 60 * 24;
            $query->andFilterWhere(['between', 'created_at', $start_date, $end_date]);
        }

        if ($this->to_date_range_update !== "" && !is_null($this->to_date_range_update)) {
            $start_date = strtotime($this->from_date_range_update);
            $end_date = strtotime($this->to_date_range_update) + 60 * 60 * 24;
            $query->andFilterWhere(['between', 'updated_at', $start_date, $end_date]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cheque' => $this->cheque,
            'order_id' => $this->order_id,
            'customer_id' => $this->customer_id,
            'company_id' => $this->company_id,
            'market_id' => $this->market_id,
            'status' => $this->status,
            'amount' => $this->amount,
            'starts_in' => $this->starts_in,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'remote_id', $this->remote_id])
            ->andFilterWhere(['ilike', 'transaction_id', $this->transaction_id])
            ->andFilterWhere(['ilike', 'terminal_id', $this->terminal_id]);

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
        $query = OrderItem::find()->where(['order_id' => $order_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['starts_in' => SORT_ASC]],
            'pagination' => [
                'pageSize' => 100,
            ],
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
            'cheque' => $this->cheque,
            'order_id' => $this->order_id,
            'customer_id' => $this->customer_id,
            'company_id' => $this->company_id,
            'market_id' => $this->market_id,
            'status' => $this->status,
            'amount' => $this->amount,
            'starts_in' => $this->starts_in,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'remote_id', $this->remote_id])
            ->andFilterWhere(['ilike', 'transaction_id', $this->transaction_id])
            ->andFilterWhere(['ilike', 'terminal_id', $this->terminal_id]);

        return $dataProvider;
    }


    /**
     * @return array
     */
    public function debt_month_search()
    {
        $sql = "SELECT extract(month from TO_TIMESTAMP(starts_in)) as month, extract(year from TO_TIMESTAMP(starts_in)) as year,
                SUM(order_item.amount) as plan, SUM(order_item.paid_amount) as fact, SUM(order_item.amount)-SUM(order_item.paid_amount) as expect 
                FROM  order_item GROUP BY month, year order by year, month";
        $data = \Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
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
        $customer_ids = Customer::find()->select('id')->asArray()->column();
        $order_ids = Order::find()->where(['not in', 'customer_id', $customer_ids])->select('id')->asArray()->column();
        $query = OrderItem::find()->where(['in', 'order_id', $order_ids]);
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
        if ($this->to_date_range_starts !== "" && !is_null($this->to_date_range_starts)) {
            $start_date = strtotime($this->from_date_range_starts);
            $end_date = strtotime($this->to_date_range_starts) + 60 * 60 * 24;
            $query->andFilterWhere(['between', 'starts_in', $start_date, $end_date]);
        }

        if ($this->to_date_range !== "" && !is_null($this->to_date_range)) {
            $start_date = strtotime($this->from_date_range);
            $end_date = strtotime($this->to_date_range) + 60 * 60 * 24;
            $query->andFilterWhere(['between', 'created_at', $start_date, $end_date]);
        }

        if ($this->to_date_range_update !== "" && !is_null($this->to_date_range_update)) {
            $start_date = strtotime($this->from_date_range_update);
            $end_date = strtotime($this->to_date_range_update) + 60 * 60 * 24;
            $query->andFilterWhere(['between', 'updated_at', $start_date, $end_date]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cheque' => $this->cheque,
            'order_id' => $this->order_id,
            'customer_id' => $this->customer_id,
            'company_id' => $this->company_id,
            'market_id' => $this->market_id,
            'status' => $this->status,
            'amount' => $this->amount,
            'starts_in' => $this->starts_in,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'remote_id', $this->remote_id])
            ->andFilterWhere(['ilike', 'transaction_id', $this->transaction_id])
            ->andFilterWhere(['ilike', 'terminal_id', $this->terminal_id]);

        return $dataProvider;
    }
}
