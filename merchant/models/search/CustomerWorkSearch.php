<?php

namespace merchant\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CustomerWork;

/**
 * CustomerWorkSearch represents the model behind the search form of `common\models\CustomerWork`.
 */
class CustomerWorkSearch extends CustomerWork
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'customer_id', 'work_city_id', 'work_region_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['work_address', 'office', 'position'], 'safe'],
            [['salary'], 'number'],
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
        $query = CustomerWork::find();

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
            'customer_id' => $this->customer_id,
            'work_city_id' => $this->work_city_id,
            'work_region_id' => $this->work_region_id,
            'salary' => $this->salary,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'work_address', $this->work_address])
            ->andFilterWhere(['ilike', 'office', $this->office])
            ->andFilterWhere(['ilike', 'position', $this->position]);

        return $dataProvider;
    }
}
