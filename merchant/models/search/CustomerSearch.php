<?php

namespace merchant\models\search;

use common\models\Action;
use common\models\constants\CustomerDegree;
use common\models\constants\CustomerStatus;
use common\models\constants\LeasingStatus;
use common\models\constants\OrderStatus;
use common\models\Customer;
use common\models\CustomerCard;
use common\models\CustomerMarket;
use common\models\Order;
use common\models\Region;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CustomerSearch represents the model behind the search form of `common\models\Customer`.
 */
class CustomerSearch extends Customer
{
    public $market_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'city_id', 'region_id', 'address', 'family_status', 'status', 'created_at', 'updated_at', 'number_of_leasing', 'degree'], 'integer'],
            ['ms_id', 'string'],
            [['pin', 'first_name', 'last_name', 'middle_name', 'phone', 'image', 'market_id'], 'safe'],
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
    public function search($params, $status = null)
    {
        $query = Customer::find();
        if (!\Yii::$app->user->identity->is_scoring) {
            if (\Yii::$app->user->identity->is_investor) {
                $customers = Order::findActive()->select('customer_id')->asArray()->column();
                $query->andWhere(['in', 'customer.id', $customers]);
            } else {
                $customers = Order::findActive()->select('customer_id')->asArray()->column();
                $markets = CustomerMarket::find()->where(['market_id' => \Yii::$app->user->identity->market_id])->select('customer_id')->asArray()->column();
                $query->andWhere(['or', ['in', 'customer.id', $customers], ['in', 'customer.id', $markets]]);
            }
        }
        if (\Yii::$app->user->identity->is_merchant_admin) {
            $query->innerJoin('customer_market', 'customer_market.customer_id=customer.id')
                ->andWhere(['in', 'customer_market.market_id', \Yii::$app->user->identity->market_id_array])
                ->andWhere(['<>', 'customer.status', CustomerStatus::STATUS_DELETED]);
        }
        if ($status == CustomerStatus::STATUS_READY) {
            $customers_ids = Order::find()->andWhere(['>=', 'status', OrderStatus::STATUS_ACTIVE])->select('customer_id')->asArray()->column();
            $query->andWhere(['and', ['status' => CustomerStatus::STATUS_MEMBER], ['not in', 'customer.id', $customers_ids]]);
        } else if ($status != null)
            $query->andWhere(['status' => $status]);

        $this->load($params);

        if (intval($this->market_id) > 0) {
            $markets = CustomerMarket::find()->where(['market_id' => $this->market_id])->select('customer_id')->asArray()->column();
            $query = Customer::find()->where(['in', 'customer.id', $markets]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'customer.id' => $this->id,
            'city_id' => $this->city_id,
            'region_id' => $this->region_id,
            'address' => $this->address,
            'family_status' => $this->family_status,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'number_of_leasing' => $this->number_of_leasing
        ]);

        $query->andFilterWhere(['ilike', 'pin', $this->pin])
            ->andFilterWhere(['ilike', 'first_name', $this->first_name])
            ->andFilterWhere(['ilike', 'last_name', $this->last_name])
            ->andFilterWhere(['ilike', 'middle_name', $this->middle_name])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'ms_id', $this->ms_id])
            ->andFilterWhere(['ilike', 'image', $this->image]);

        return $dataProvider;
    }

    public function search_with_order($params, $status = null)
    {
        $query = Customer::find()->where(['<>', 'customer.status', CustomerStatus::STATUS_DELETED]);
        if (!\Yii::$app->user->identity->is_scoring) {
            if (\Yii::$app->user->identity->is_investor) {
                $customers = Order::findActive()->select('customer_id')->asArray()->column();
                $query->andWhere(['in', 'customer.id', $customers]);
            } else {
                $customers = Order::findActive()->select('customer_id')->asArray()->column();
                $markets = CustomerMarket::find()->where(['market_id' => \Yii::$app->user->identity->market_id])->select('customer_id')->asArray()->column();
                $query->andWhere(['or', ['in', 'customer.id', $customers], ['in', 'customer.id', $markets]]);
            }
        }
        if (\Yii::$app->user->identity->is_merchant_admin) {
            $query->innerJoin('customer_market', 'customer_market.customer_id=customer.id')
                ->andWhere(['in', 'customer_market.market_id', \Yii::$app->user->identity->getMarketsOfAdminMerchant()])
                ->andWhere(['<>', 'customer.status', CustomerStatus::STATUS_DELETED]);
        }
        if ($status == CustomerStatus::STATUS_READY) {
            $customers_ids = Order::find()->andWhere(['>=', 'status', OrderStatus::STATUS_ACTIVE])->select('customer_id')->asArray()->column();
            $query->andWhere(['and', ['customer.status' => CustomerStatus::STATUS_MEMBER], ['not in', 'id', $customers_ids]]);
        } else if ($status != null)
            $query->andWhere(['customer.status' => $status]);

        $this->load($params);

        if (intval($this->market_id) > 0) {
            $markets = CustomerMarket::find()->where(['market_id' => $this->market_id])->select('customer_id')->asArray()->column();
            $query = Customer::find()->where(['>', 'customer.status', CustomerStatus::STATUS_DELETED])->andWhere(['in', 'id', $markets]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if ($this->degree == CustomerDegree::DEGREE_PASSIVE) {
            $query->andWhere(['in', 'customer.degree', CustomerDegree::getGoodArray()])
                ->innerJoin('public.order', 'public.order.customer_id = customer.id')
                ->groupBy(['customer.id', 'public.order.status'])
                ->having(['and', ['max(public.order.status)' => OrderStatus::STATUS_FINISHED], ['min(public.order.status)' => OrderStatus::STATUS_FINISHED]]);
            $this->degree = null;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'customer.id' => $this->id,
            'customer.city_id' => $this->city_id,
//            'customer.region_id' => $this->region_id,
            'customer.address' => $this->address,
            'customer.family_status' => $this->family_status,
            'customer.status' => $this->status,
            'customer.degree' => $this->degree,
            'customer.created_at' => $this->created_at,
            'customer.updated_at' => $this->updated_at,
            'customer.number_of_leasing' => $this->number_of_leasing
        ]);

        $query->andFilterWhere(Region::setRegionByQuery($this->region_id))
            ->andFilterWhere(['ilike', 'customer.pin', $this->pin])
            ->andFilterWhere(['ilike', 'customer.first_name', $this->first_name])
            ->andFilterWhere(['ilike', 'customer.last_name', $this->last_name])
            ->andFilterWhere(['ilike', 'customer.middle_name', $this->middle_name])
            ->andFilterWhere(['ilike', 'customer.phone', $this->phone])
            ->andFilterWhere(['ilike', 'customer.ms_id', $this->ms_id])
            ->andFilterWhere(['ilike', 'customer.image', $this->image])
            ->andFilterWhere(['ilike', 'customer.city_name', $this->city_name]);
        $orders_amount = Order::find()->where(['and', ['>', 'status', OrderStatus::STATUS_WAITING], ['in', 'customer_id', (clone $query)->select('customer.id')->asArray()->column()]])->sum('amount');

        return [
            'dataProvider' => $dataProvider,
            'orders_amount' => $orders_amount
        ];
    }

    /**
     * @param $params
     * @param null $status
     * @return ActiveDataProvider
     */
    public function search_by_product_id($params, $product_id)
    {
        $customers = Action::find()->where(['product_id' => $product_id])->select('customer_id')->asArray()->column();

        $query = Customer::findActive()->andWhere(['in', 'id', $customers]);

        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'city_id' => $this->city_id,
            'region_id' => $this->region_id,
            'address' => $this->address,
            'family_status' => $this->family_status,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'number_of_leasing' => $this->number_of_leasing
        ]);

        $query->andFilterWhere(['ilike', 'pin', $this->pin])
            ->andFilterWhere(['ilike', 'first_name', $this->first_name])
            ->andFilterWhere(['ilike', 'last_name', $this->last_name])
            ->andFilterWhere(['ilike', 'middle_name', $this->middle_name])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'ms_id', $this->ms_id])
            ->andFilterWhere(['ilike', 'image', $this->image]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @param null $status
     * @return ActiveDataProvider
     */
    public function search_debt($params, $status = null)
    {
        $query = Customer::find()->innerJoin('order_item', 'order_item.customer_id=customer.id')->andWhere(['and', ['>', 'customer.status', CustomerStatus::STATUS_INACTIVE], ['<', 'order_item.starts_in', time()]])->andWhere(['or', ['order_item.status' => LeasingStatus::STATUS_WAITING], ['order_item.status' => LeasingStatus::STATUS_PART]]);
        if ($status != null)
            $query->andWhere(['customer.status' => $status]);

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

        // grid filtering conditions
        $query->andFilterWhere([
            'customer.id' => $this->id,
            'customer.city_id' => $this->city_id,
            'customer.region_id' => $this->region_id,
            'customer.address' => $this->address,
            'customer.family_status' => $this->family_status,
            'customer.status' => $this->status,
            'customer.created_at' => $this->created_at,
            'customer.updated_at' => $this->updated_at,
            'customer.number_of_leasing' => $this->number_of_leasing
        ]);

        $query->andFilterWhere(['ilike', 'customer.pin', $this->pin])
            ->andFilterWhere(['ilike', 'customer.first_name', $this->first_name])
            ->andFilterWhere(['ilike', 'customer.last_name', $this->last_name])
            ->andFilterWhere(['ilike', 'customer.middle_name', $this->middle_name])
            ->andFilterWhere(['ilike', 'customer.phone', $this->phone])
            ->andFilterWhere(['ilike', 'customer.ms_id', $this->ms_id])
            ->andFilterWhere(['ilike', 'customer.image', $this->image]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @param null $status
     * @return ActiveDataProvider
     */
    public function search_double_passport($params, $status = null)
    {
        $query = Customer::findActive()->andWhere(['and', ['in', 'id', [1360, 1488, 1423, 1390, 1094, 751, 919, 1458, 746, 846, 1012, 522, 1123, 1138, 1262, 695, 1007, 1460, 769, 950, 834, 1446, 1432, 1449, 762, 982, 736, 1424, 703, 641, 1294, 769, 1460, 1458]]]);
        if ($status != null)
            $query->andWhere(['customer.status' => $status]);

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'city_id' => $this->city_id,
            'region_id' => $this->region_id,
            'address' => $this->address,
            'family_status' => $this->family_status,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'number_of_leasing' => $this->number_of_leasing
        ]);

        $query->andFilterWhere(['ilike', 'pin', $this->pin])
            ->andFilterWhere(['ilike', 'first_name', $this->first_name])
            ->andFilterWhere(['ilike', 'last_name', $this->last_name])
            ->andFilterWhere(['ilike', 'middle_name', $this->middle_name])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'ms_id', $this->ms_id])
            ->andFilterWhere(['ilike', 'image', $this->image]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @param null $status
     * @return ActiveDataProvider
     */
    public function search_birthday($params, $status = null)
    {
        $today = date('d.m');
        $customers = Customer::find()->where(['and', ['<', 'birth_date', strtotime("01.01.2005")], ['<>', 'birth_date', 0]]);
        echo $customers->count('id') . "\r\n";
        $ids = [];
        foreach ($customers->each() as $customer) {
            /** @var Customer $customer */
            if (date('d.m', $customer->birth_date) == $today) {
                $ids[] = $customer->id;
            }
        }
        $query = Customer::findActive()->andWhere(['in', 'id', $ids]);
        if ($status != null)
            $query->andWhere(['customer.status' => $status]);

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'city_id' => $this->city_id,
            'region_id' => $this->region_id,
            'address' => $this->address,
            'family_status' => $this->family_status,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'number_of_leasing' => $this->number_of_leasing
        ]);

        $query->andFilterWhere(['ilike', 'pin', $this->pin])
            ->andFilterWhere(['ilike', 'first_name', $this->first_name])
            ->andFilterWhere(['ilike', 'last_name', $this->last_name])
            ->andFilterWhere(['ilike', 'middle_name', $this->middle_name])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'ms_id', $this->ms_id])
            ->andFilterWhere(['ilike', 'image', $this->image]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function searchWithoutCards($params)
    {
        $ids = [];
        $cards = CustomerCard::find();
        foreach ($cards->each() as $card)
            /** @var CustomerCard $card */
            if ($card->card_token != null)
                $ids[] = $card->customer_id;
        $query = Customer::find()->where(['not', ['in', 'id', $ids]]);

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'city_id' => $this->city_id,
            'region_id' => $this->region_id,
            'address' => $this->address,
            'family_status' => $this->family_status,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'number_of_leasing' => $this->number_of_leasing
        ]);

        $query->andFilterWhere(['ilike', 'pin', $this->pin])
            ->andFilterWhere(['ilike', 'first_name', $this->first_name])
            ->andFilterWhere(['ilike', 'last_name', $this->last_name])
            ->andFilterWhere(['ilike', 'middle_name', $this->middle_name])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'ms_id', $this->ms_id])
            ->andFilterWhere(['ilike', 'image', $this->image]);

        return $dataProvider;
    }

    public function searchNotConnectedCards($params)
    {
        $sql = "select id from customer where id in (select customer_id from \"order\"
                     where customer_id not in 
                            (select customer_id from customer_card  where card_token is not null  group by customer_id));";
        $customer_ids = \Yii::$app->db->createCommand($sql)->queryColumn();
        $query = Customer::find()->andWhere(['in', 'id', $customer_ids]);
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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'city_id' => $this->city_id,
            'region_id' => $this->region_id,
            'address' => $this->address,
            'family_status' => $this->family_status,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'number_of_leasing' => $this->number_of_leasing
        ]);

        $query->andFilterWhere(['ilike', 'pin', $this->pin])
            ->andFilterWhere(['ilike', 'first_name', $this->first_name])
            ->andFilterWhere(['ilike', 'last_name', $this->last_name])
            ->andFilterWhere(['ilike', 'middle_name', $this->middle_name])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'ms_id', $this->ms_id])
            ->andFilterWhere(['ilike', 'image', $this->image]);

        return $dataProvider;
    }

}
