<?php

namespace merchant\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CustomerMarket;

/**
 * CustomerMarketSearch represents the model behind the search form of `common\models\CustomerMarket`.
 */
class CustomerMarketSearch extends CustomerMarket
{
    public $to_date_range;
    public $from_date_range;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'market_id', 'customer_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['from_date_range', 'to_date_range'],'safe']
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
        $customers = CustomerMarket::find()->all();
        $ids = [];
        foreach ($customers as $customer) {
            /** @var CustomerMarket $customer */
            $cnt = CustomerMarket::find()->where(['and', ['customer_id' => $customer->customer_id], ['company_id' => $customer->company_id]])->count();
            if($cnt > 1)
                $ids[] = $customer->customer_id;
        }
        $query = CustomerMarket::find()->where(['in', 'customer_id', $ids]);

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
            'company_id' => $this->company_id,
            'market_id' => $this->market_id,
            'customer_id' => $this->customer_id,
            'status' => $this->status,
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
    public function search_by_customer_id($params, $customer_id)
    {
        $query = CustomerMarket::find()->where(['and', ['customer_id' => $customer_id], ['company_id' => \Yii::$app->user->identity->company_id]]);

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
            'customer_id' => $this->customer_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
