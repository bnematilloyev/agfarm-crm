<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductCategory;

/**
 * ProductCategorySearch represents the model behind the search form of `common\models\ProductCategory`.
 */
class ProductCategorySearch extends ProductCategory
{
    public $to_date_range;
    public $from_date_range;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'created_at', 'updated_at'], 'integer'],
            [['name_uz', 'name_ru', 'name_en', 'description_uz', 'description_ru', 'description_en'], 'safe'],
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
        $query = ProductCategory::find();

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
            'parent_id' => $this->parent_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'name_uz', $this->name_uz])
            ->andFilterWhere(['ilike', 'name_ru', $this->name_ru])
            ->andFilterWhere(['ilike', 'name_en', $this->name_en])
            ->andFilterWhere(['ilike', 'description_uz', $this->description_uz])
            ->andFilterWhere(['ilike', 'description_ru', $this->description_ru])
            ->andFilterWhere(['ilike', 'description_en', $this->description_en]);

        return $dataProvider;
    }
}
