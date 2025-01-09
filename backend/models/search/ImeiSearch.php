<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Imei;

/**
 * ImeiSearch represents the model behind the search form of `common\models\Imei`.
 */
class ImeiSearch extends Imei
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'seller_id', 'buyer_id', 'company_id', 'market_id', 'product_id', 'expires_in', 'created_at', 'updated_at'], 'integer'],
            [['imei1', 'imei2', 'description'], 'safe'],
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
        $query = Imei::find();

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
            'seller_id' => $this->seller_id,
            'buyer_id' => $this->buyer_id,
            'company_id' => $this->company_id,
            'market_id' => $this->market_id,
            'product_id' => $this->product_id,
            'expires_in' => $this->expires_in,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'imei1', $this->imei1])
            ->andFilterWhere(['ilike', 'imei2', $this->imei2])
            ->andFilterWhere(['ilike', 'description', $this->description]);

        return $dataProvider;
    }
}
