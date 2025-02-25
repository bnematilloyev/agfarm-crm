<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductBrand;

/**
 * ProductBrandSearch represents the model behind the search form of `common\models\ProductBrand`.
 */
class ProductBrandSearch extends ProductBrand
{
    public $to_date_range;
    public $from_date_range;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name_uz', 'name_ru', 'name_en', 'slug', 'image', 'meta_json_uz', 'meta_json_ru', 'meta_json_en', 'official_link'], 'safe'],
            [['home_page'], 'boolean'],
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
        $query = ProductBrand::find();

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
            'home_page' => $this->home_page,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'name_uz', $this->name_uz])
            ->andFilterWhere(['ilike', 'name_ru', $this->name_ru])
            ->andFilterWhere(['ilike', 'name_en', $this->name_en])
            ->andFilterWhere(['ilike', 'slug', $this->slug])
            ->andFilterWhere(['ilike', 'image', $this->image])
            ->andFilterWhere(['ilike', 'meta_json_uz', $this->meta_json_uz])
            ->andFilterWhere(['ilike', 'meta_json_ru', $this->meta_json_ru])
            ->andFilterWhere(['ilike', 'meta_json_en', $this->meta_json_en])
            ->andFilterWhere(['ilike', 'official_link', $this->official_link]);

        return $dataProvider;
    }
}
