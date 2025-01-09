<?php

namespace merchant\models\search;

use common\models\Order;
use common\models\OrderItem;
use common\models\OrderItemAwait;
use pay\models\Customer;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderItemAwaitSearch represents the model behind the search form of `common\models\OrderItemAwait`.
 */
class OrderItemAwaitSearch extends OrderItemAwait
{
    public $to_date_range;
    public $from_date_range;
    public $market_id;
    public $company_id;
    public $customer_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'item_id', 'transaction_id', 'terminal_id', 'requested_at', 'responsed_at', 'success_trans_id', 'created_at', 'updated_at', 'company_id', 'market_id', 'customer_id'], 'integer'],
            [['request', 'response', 'payment_type'], 'number'],
            [['text', 'to_date_range', 'from_date_range', 'order_id', 'company_id', 'str_success_trans_id'], 'safe'],
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
        $query = OrderItemAwait::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
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
            'order_id' => $this->order_id,
            'item_id' => $this->item_id,
            'transaction_id' => $this->transaction_id,
            'terminal_id' => $this->terminal_id,
            'request' => $this->request,
            'response' => $this->response,
            'requested_at' => $this->requested_at,
            'responsed_at' => $this->responsed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'text', $this->text]);

        return $dataProvider;
    }

    public function searchGetSql($request)
    {
        $market_id = intval($request['market_id']);
        $customer_id = intval($request['customer_id']);
        $order_id = intval($request['order_id']);
        $success_trans_id = intval($request['success_trans_id'] ?? 0);
        $response = doubleval($request['response']);
        $text = $request['text'];
        $from_date_range = $request['from_date_range'];
        $to_date_range = $request['to_date_range'];
        $payment_type = $request['payment_type'];
        if ($payment_type !== "") {
            $payment_type = intval($payment_type);
        } else {
            $payment_type = -1;
        }
        $query = OrderItemAwait::find()->joinWith(['order']);
        if ($market_id != 0)
            $query->andWhere(['order_item_await.market_id' => $market_id]);
        if ($customer_id != 0)
            $query->andWhere(['public.order.customer_id' => $customer_id]);
        if ($order_id != 0)
            $query->andWhere(['order_item_await.order_id' => $order_id]);
        if ($success_trans_id != 0)
            $query->andWhere(['order_item_await.success_trans_id' => $success_trans_id]);
        if ($response != 0)
            $query->andWhere(['order_item_await.response' => $response]);
        else
            $query->andWhere(['>', 'order_item_await.response', 10]);
        if ($payment_type != -1)
            $query->andWhere(['order_item_await.payment_type' => $payment_type]);

        if ($to_date_range !== "" && !is_null($to_date_range)) {
            $start_date = strtotime($from_date_range);
            $end_date = strtotime($to_date_range) + 60 * 60 * 24;
            $query->andWhere(['between', 'order_item_await.responsed_at', $start_date, $end_date]);
        }
        $query->andWhere(['ilike', 'order_item_await.text', $text])->select('order_item_await.*, public.order.customer_id');

        return $query->createCommand()->rawSql;
    }


    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search_wrong_null($params)
    {
        $query = OrderItemAwait::find();
        $order_item_ids = OrderItem::findActive()->select('id')->asArray()->column();
        $order_ids = Order::findActive()->select('id')->asArray()->column();
        $query->andWhere(['or', ['not in', 'item_id', $order_item_ids], ['not in', 'order_id', $order_ids]]);
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
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
            'order_id' => $this->order_id,
            'item_id' => $this->item_id,
            'transaction_id' => $this->transaction_id,
            'terminal_id' => $this->terminal_id,
            'success_trans_id' => $this->success_trans_id,
            'request' => $this->request,
            'response' => $this->response,
            'requested_at' => $this->requested_at,
            'responsed_at' => $this->responsed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'text', $this->text]);

        return $dataProvider;
    }

    public function search_transaction_unired($params)
    {
        $query = OrderItemAwait::findActive()->
        andWhere(['ilike', 'text', 'Unired']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ],
                'attributes' => [
                    'id', 'customer_id', 'order_id', 'response', 'responsed_at', 'company_id', 'market_id', 'text', 'payment_type'
                ]
            ],
        ]);

        $this->load($params);

        if ($this->market_id) {
            $query->andWhere(['order.market_id' => $this->market_id]);
        }
        if ($this->customer_id) {
            $query->andWhere(['customer_id' => $this->customer_id]);
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->to_date_range !== "" && !is_null($this->to_date_range)) {
            $start_date = strtotime($this->from_date_range);
            $end_date = strtotime($this->to_date_range) + 60 * 60 * 24;
            $query->andFilterWhere(['between', 'order_item_await.created_at', $start_date, $end_date]);
        }
        /** @var Order $order */
        $query->andFilterWhere([
            'order_item_await.id' => $this->id,
            'order_id' => $this->order_id,
            'item_id' => $this->item_id,
            'transaction_id' => $this->transaction_id,
            'order_item_await.terminal_id' => $this->terminal_id,
            'order_item_await.payment_type' => $this->payment_type,
            'success_trans_id' => $this->success_trans_id,
            'request' => $this->request,
            'response' => $this->response,
            'requested_at' => $this->requested_at,
            'responsed_at' => $this->responsed_at,
            'order_item_await.created_at' => $this->created_at,
            'order_item_await.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'text', $this->text]);

        return [
            'dataProvider' => $dataProvider,
            'sum' => $query->sum('response'),
        ];
    }

    public function search_transaction_fresh($params, $status = null, $is_card = null)
    {
        $customer_ids = Customer::findActive()->select('id')->asArray()->column();
        $query = OrderItemAwait::findActive()
            ->with(['order.company', 'order.market'])
            ->joinWith(['order'])
            ->andWhere(['and', ['>', 'order_item_await.response', 0], ['in', 'order.customer_id', $customer_ids]]);

        if ($is_card == 0) {
            $query->andWhere(['and', ['ilike', 'text', 'kassadan'], ['not ilike', 'text', 'UNIRED']]);
        } else if ($is_card == 1) {
            $query->andWhere(['and', ['not ilike', 'text', 'kassadan'], ['not ilike', 'text', 'UNIRED']]);
        }
        if (in_array($status, [40, 50, 60]) && $status != null) {
            $ids = [];
            $sql = "";
            switch ($status) {
                case 40:
                    $sql = "select oia.id from order_item inner join order_item_await oia on order_item.id = oia.item_id  where oia.responsed_at-order_item.starts_in < 0 and oia.response > 0";
                    break;
                case 50:
                    $sql = "select oia.id from order_item inner join order_item_await oia on order_item.id = oia.item_id  where oia.responsed_at-order_item.starts_in >= 0 and oia.responsed_at-order_item.starts_in < 86400 and oia.response > 0";
                    break;
                case 60:
                    $sql = "select oia.id from order_item inner join order_item_await oia on order_item.id = oia.item_id  where oia.responsed_at-order_item.starts_in >= 86400 and oia.response > 0";
                    break;
                default:
                    break;
            }
            $ids = \Yii::$app->db->createCommand($sql)->queryColumn();
            $query->andWhere(['in', 'order_item_await.id', $ids]);

            if ($is_card != -1 || $status != null) {
                $ids = \Yii::$app->db->createCommand($sql)->queryColumn();
                $query->andWhere(['in', 'order_item_await.id', $ids]);
            }
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ],
                'attributes' => [
                    'id', 'customer_id', 'order_id', 'response', 'responsed_at', 'company_id', 'market_id', 'text', 'success_trans_id', 'payment_type'
                ]
            ],
        ]);

        $this->load($params);

        if ($this->market_id) {
            $query->andWhere(['order.market_id' => $this->market_id]);
        }
        if ($this->customer_id) {
            $query->andWhere(['customer_id' => $this->customer_id]);
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->to_date_range !== "" && !is_null($this->to_date_range)) {
            $start_date = strtotime($this->from_date_range);
            $end_date = strtotime($this->to_date_range) + 60 * 60 * 24;
            $query->andFilterWhere(['between', 'order_item_await.created_at', $start_date, $end_date]);
        }

        /** @var Order $order */
        $query->andFilterWhere([
            'order_item_await.id' => $this->id,
            'order_id' => $this->order_id,
            'item_id' => $this->item_id,
            'transaction_id' => $this->transaction_id,
            'order_item_await.terminal_id' => $this->terminal_id,
            'order_item_await.payment_type' => $this->payment_type,
            'order_item_await.success_trans_id' => $this->success_trans_id,
            'request' => $this->request,
            'response' => $this->response,
            'requested_at' => $this->requested_at,
            'responsed_at' => $this->responsed_at,
            'order_item_await.created_at' => $this->created_at,
            'order_item_await.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'text', $this->text]);

        return [
            'dataProvider' => $dataProvider,
            'sum' => $query->sum('response'),
        ];
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
        $query = OrderItemAwait::find();
        $all = $query->all();
        $ids = [];
        foreach ($all as $item_await) {
            /** @var OrderItemAwait $item_await */
            if ($item_await->order == null) {
                $ids[] = $item_await->id;
            }
        }
        $query->where(['in', 'id', $ids]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
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
            'order_id' => $this->order_id,
            'item_id' => $this->item_id,
            'transaction_id' => $this->transaction_id,
            'terminal_id' => $this->terminal_id,
            'success_trans_id' => $this->success_trans_id,
            'request' => $this->request,
            'response' => $this->response,
            'requested_at' => $this->requested_at,
            'responsed_at' => $this->responsed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'text', $this->text]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search_last_month($params, $history = null)
    {
        $time = time() - 86400 * 30;
        $query = OrderItemAwait::find()->innerJoin('order', 'public.order.id=order_item_await.order_id')->where(['and', ['public.order.market_id' => \Yii::$app->user->identity->market_id], ['>=', 'order_item_await.created_at', $time]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 5,
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
            'order_id' => $this->order_id,
            'item_id' => $this->item_id,
            'transaction_id' => $this->transaction_id,
            'terminal_id' => $this->terminal_id,
            'success_trans_id' => $this->success_trans_id,
            'request' => $this->request,
            'response' => $this->response,
            'requested_at' => $this->requested_at,
            'responsed_at' => $this->responsed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'text', $this->text]);

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
        $query = OrderItemAwait::find()->where(['order_id' => $order_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 5,
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
            'order_id' => $this->order_id,
            'item_id' => $this->item_id,
            'transaction_id' => $this->transaction_id,
            'terminal_id' => $this->terminal_id,
            'success_trans_id' => $this->success_trans_id,
            'request' => $this->request,
            'response' => $this->response,
            'requested_at' => $this->requested_at,
            'responsed_at' => $this->responsed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'text', $this->text]);

        return $dataProvider;
    }


    /**
     * @param $params
     * @param $order_id
     * @return array|ActiveDataProvider
     */
    public function search_by_order_id_for_response($params, $order_id)
    {
        $query = OrderItemAwait::find()->where(['order_id' => $order_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 5,
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
            'order_id' => $this->order_id,
            'response' => $this->response,
            'item_id' => $this->item_id,
            'transaction_id' => $this->transaction_id,
            'terminal_id' => $this->terminal_id,
            'success_trans_id' => $this->success_trans_id,
            'request' => $this->request,
            'requested_at' => $this->requested_at,
            'responsed_at' => $this->responsed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return [
            'dataProvider' => $dataProvider,
            'sum' => $query->sum('response')
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search_by_item_id($params, $item_id, $only_success = false)
    {
        $query = OrderItemAwait::find()->where(['item_id' => $item_id]);
        if ($only_success) {
            $query->andWhere(['>', 'response', 0]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'requested_at' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 10000,
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
            'order_id' => $this->order_id,
            'item_id' => $this->item_id,
            'transaction_id' => $this->transaction_id,
            'terminal_id' => $this->terminal_id,
            'success_trans_id' => $this->success_trans_id,
            'request' => $this->request,
            'response' => $this->response,
            'requested_at' => $this->requested_at,
            'responsed_at' => $this->responsed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'text', $this->text]);

        return $dataProvider;
    }

}
