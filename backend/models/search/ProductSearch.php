<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * ProductSearch represents the model behind the search form of `common\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'category_id', 'brand_id', 'state', 'status', 'sort', 'currency_id', 'trust_percent', 'creator_id', 'updater_admin_id', 'price_changed_at', 'created_at', 'updated_at'], 'integer'],
            [['name_uz', 'name_ru', 'name_en', 'description_uz', 'description_ru', 'description_en', 'slug', 'main_image', 'imageField', 'video', 'meta_json_uz', 'meta_json_ru', 'meta_json_en', 'categories', 'similar', 'stat'], 'safe'],
            [['actual_price', 'old_price', 'cost'], 'number'],
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
        $query = Product::find()->orderBy(['status' => SORT_DESC, 'created_at' => SORT_DESC]);

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
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'state' => $this->state,
            'status' => $this->status,
            'sort' => $this->sort,
            'actual_price' => $this->actual_price,
            'old_price' => $this->old_price,
            'cost' => $this->cost,
            'currency_id' => $this->currency_id,
            'trust_percent' => $this->trust_percent,
            'creator_id' => $this->creator_id,
            'updater_admin_id' => $this->updater_admin_id,
            'price_changed_at' => $this->price_changed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'name_uz', $this->name_uz])
            ->andFilterWhere(['ilike', 'name_ru', $this->name_ru])
            ->andFilterWhere(['ilike', 'name_en', $this->name_en])
            ->andFilterWhere(['ilike', 'description_uz', $this->description_uz])
            ->andFilterWhere(['ilike', 'description_ru', $this->description_ru])
            ->andFilterWhere(['ilike', 'description_en', $this->description_en])
            ->andFilterWhere(['ilike', 'slug', $this->slug])
            ->andFilterWhere(['ilike', 'main_image', $this->main_image])
            ->andFilterWhere(['ilike', 'video', $this->video])
            ->andFilterWhere(['ilike', 'meta_json_uz', $this->meta_json_uz])
            ->andFilterWhere(['ilike', 'meta_json_ru', $this->meta_json_ru])
            ->andFilterWhere(['ilike', 'meta_json_en', $this->meta_json_en])
            ->andFilterWhere(['ilike', 'categories', $this->categories])
            ->andFilterWhere(['ilike', 'similar', $this->similar])
            ->andFilterWhere(['ilike', 'stat', $this->stat]);

        return $dataProvider;
    }

    public function search_by_priority($params)
    {
        $query = Product::find()->orderBy(['sort' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'company_id' => $this->company_id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'status' => $this->status,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['ilike', 'name_uz', $this->name_uz])
            ->andFilterWhere(['ilike', 'name_ru', $this->name_ru])
            ->andFilterWhere(['ilike', 'name_en', $this->name_en]);

        return $dataProvider;
    }

    public function search_by_price($params)
    {
        $query = Product::find()->orderBy(['sort' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'company_id' => $this->company_id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'status' => $this->status,
            'sort' => $this->sort,
            'actual_price' => $this->actual_price,
            'old_price' => $this->old_price,
            'cost' => $this->cost,
            'currency_id' => $this->currency_id,
            'trust_percent' => $this->trust_percent,
        ]);

        $query->andFilterWhere(['ilike', 'name_uz', $this->name_uz])
            ->andFilterWhere(['ilike', 'name_ru', $this->name_ru])
            ->andFilterWhere(['ilike', 'name_en', $this->name_en]);

        return $dataProvider;
    }
}
