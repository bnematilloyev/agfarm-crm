<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductOption;

/**
 * ProductOptionSearch represents the model behind the search form of `common\models\ProductOption`.
 */
class ProductOptionSearch extends ProductOption
{
    public $from_date_range;
    public $to_date_range;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'option_type', 'option_name', 'product_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = ProductOption::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

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
            'option_type' => $this->option_type,
            'option_name' => $this->option_name,
            'product_id' => $this->product_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'value', $this->value]);

        return $dataProvider;
    }

    public function search_for_product($product_id)
    {
        return ProductOption::find()->where(['product_id' => $product_id])->all();
    }

}
