<?php

namespace merchant\models;

use common\models\Market;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductMarket;

/**
 * ProductMarketSearch represents the model behind the search form of `common\models\ProductMarket`.
 */
class ProductMarketSearch extends ProductMarket
{
    public $currency_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'market_id', 'bonus', 'price', 'currency_id', 'created_at', 'updated_at'], 'integer'],
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
        $query = ProductMarket::find();
        if (\Yii::$app->user->identity->is_merchant_admin)
            $query->andWhere(['market_id' => Market::getAdminMerchantMarketIds(\Yii::$app->user->identity)]);
        else
            $query->andWhere(['market_id' => \Yii::$app->user->identity->market_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->currency_id)) {
            $query->leftJoin(Market::tableName(), 'product_market.market_id = market.id');
            $query->andWhere(['market.currency_id' => $this->currency_id]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'market_id' => $this->market_id,
            'bonus' => $this->bonus,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
