<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TelegramMessage;

/**
 * TelegramMessageSearch represents the model behind the search form of `common\models\TelegramMessage`.
 */
class TelegramMessageSearch extends TelegramMessage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tg_id', 'chat_id', 'created_at', 'updated_at'], 'integer'],
            [['username', 'tg_first_name', 'tg_last_name', 'phone', 'extra_phone', 'passer', 'pasnum', 'pasdob', 'first_name', 'last_name', 'middle_name', 'pinfl', 'region_name', 'city_name', 'address', 'pasimg1', 'pasimg2', 'pasimg3'], 'safe'],
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
        $query = TelegramMessage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'id' => SORT_DESC
                ]
            ]
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
            'tg_id' => $this->tg_id,
            'chat_id' => $this->chat_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'username', $this->username])
            ->andFilterWhere(['ilike', 'tg_first_name', $this->tg_first_name])
            ->andFilterWhere(['ilike', 'tg_last_name', $this->tg_last_name])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'extra_phone', $this->extra_phone])
            ->andFilterWhere(['ilike', 'passer', $this->passer])
            ->andFilterWhere(['ilike', 'pasnum', $this->pasnum])
            ->andFilterWhere(['ilike', 'pasdob', $this->pasdob])
            ->andFilterWhere(['ilike', 'first_name', $this->first_name])
            ->andFilterWhere(['ilike', 'last_name', $this->last_name])
            ->andFilterWhere(['ilike', 'middle_name', $this->middle_name])
            ->andFilterWhere(['ilike', 'pinfl', $this->pinfl])
            ->andFilterWhere(['ilike', 'region_name', $this->region_name])
            ->andFilterWhere(['ilike', 'city_name', $this->city_name])
            ->andFilterWhere(['ilike', 'address', $this->address])
            ->andFilterWhere(['ilike', 'pasimg1', $this->pasimg1])
            ->andFilterWhere(['ilike', 'pasimg2', $this->pasimg2])
            ->andFilterWhere(['ilike', 'pasimg3', $this->pasimg3]);

        return $dataProvider;
    }
}
