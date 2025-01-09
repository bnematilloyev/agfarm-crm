<?php

namespace merchant\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Log;

/**
 * LogSearch represents the model behind the search form of `common\models\Log`.
 */
class LogSearch extends Log
{
    public $to_date_range;
    public $from_date_range;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'market_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['text', 'to_date_range', 'from_date_range'], 'safe'],
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
    public function search($params, $market_id)
    {
        $query = Log::find();
        if (!Yii::$app->user->identity->is_creator)
            $query->where(['and', ['<>', 'user_id', 1], ['company_id' => \Yii::$app->user->identity->company_id]]);

        // add conditions that should always apply here

        if ($market_id != null)
            $query->andWhere(['market_id' => $market_id]);

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
            $query->andFilterWhere(['between', 'log.created_at', $start_date, $end_date]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search_by_user_id($params, $user_id = null)
    {
        $query = Log::find()
            ->with(['user']);

        if (!Yii::$app->user->identity->is_creator)
            $query->where(['and', ['<>', 'user_id', 1], ['company_id' => \Yii::$app->user->identity->company_id]]);

        // add conditions that should always apply here

        if ($user_id != null)
            $query->andWhere(['user_id' => $user_id]);

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
            $query->andFilterWhere(['between', 'log.created_at', $start_date, $end_date]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
