<?php

namespace merchant\models\search;

use common\models\OrderItem;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PaymoListener;

/**
 * PaymoListenerSearch represents the model behind the search form of `common\models\PaymoListener`.
 */
class PaymoListenerSearch extends PaymoListener
{

    public $to_date_range;
    public $from_date_range;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'transaction_id', 'store_id', 'created_at', 'updated_at', 'order_id', 'customer_id', 'company_id', 'market_id'], 'integer'],
            [['invoice', 'sign', 'to_date_range', 'from_date_range'], 'safe'],
            [['amount'], 'number'],
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
     * @return array|ActiveDataProvider
     */
    public function search($params)
    {
        $query = PaymoListener::findActive();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->to_date_range !== "" && !is_null($this->to_date_range)) {
            $start_date = strtotime($this->from_date_range);
            $end_date = strtotime($this->to_date_range) + 60 * 60 * 24;
            $query->andFilterWhere(['between', 'created_at', $start_date, $end_date]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'order_id' => $this->order_id,
            'customer_id' => $this->customer_id,
            'company_id' => $this->company_id,
            'market_id' => $this->market_id,
            'store_id' => $this->store_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'invoice', $this->invoice])
            ->andFilterWhere(['ilike', 'CAST(amount AS TEXT)', $this->amount])
            ->andFilterWhere(['ilike', 'sign', $this->sign]);

        return [
            'dataProvider' => $dataProvider,
            'sum' => $query->sum('amount'),
        ];
    }

    public function search_transaction($params, $status = null)
    {
        $query = PaymoListener::findActive();
        if ($status != null) {
            $ids = [];
            $listeners = $query->all();
            /** @var PaymoListener $item */
            foreach ($listeners as $item) {
                $ids[] = $item->order_item_id;
            }

            $orderItem = OrderItem::find()->where(['in', 'id', $ids])->all();
            /** @var OrderItem $item */
            $ids2 = [];
            /** @var OrderItem $orderItem */
            foreach ($orderItem as $item) {
                $t = $item->updated_at - $item->starts_in;
                if ($status == 0) {
                    if ($t < 0) {
                        $ids2[] = $item->id;
                    }
                } else if ($status == 5) {
                    if ($t >= 0 && $t < 60 * 60 * 24) {
                        $ids2[] = $item->id;
                    }
                } else if ($status == 10) {
                    if ($t > 60 * 60 * 24) {
                        $ids2[] = $item->id;
                    }
                }
            }
            $query->where(['in', 'order_item_id', $ids2]);
        }
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

        if ($this->to_date_range !== "" && !is_null($this->to_date_range)) {
            $start_date = strtotime($this->from_date_range);
            $end_date = strtotime($this->to_date_range) + 60 * 60 * 24;
            $query->andFilterWhere(['between', 'created_at', $start_date, $end_date]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'order_id' => $this->order_id,
            'customer_id' => $this->customer_id,
            'store_id' => $this->store_id,
            'company_id' => $this->company_id,
            'market_id' => $this->market_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'invoice', $this->invoice])
            ->andFilterWhere(['ilike', 'CAST(amount AS TEXT)', $this->amount])
            ->andFilterWhere(['ilike', 'sign', $this->sign]);

        return [
            'dataProvider' => $dataProvider,
            'sum' => $query->sum('amount'),
        ];
    }
}
