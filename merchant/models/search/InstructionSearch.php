<?php

namespace merchant\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Instruction;

/**
 * InstructionSearch represents the model behind the search form of `common\models\Instruction`.
 */
class InstructionSearch extends Instruction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'creator_id', 'project_type', 'created_at', 'updated_at', 'category'], 'integer'],
            [['url', 'name', 'file', 'link', 'video', 'image', 'text'], 'safe'],
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
    public function search($params, $url, $category = null)
    {
        $query = Instruction::find();
        if ($url)
            $query->where(['url' => $url]);
        if ($category)
            $query->where(['category' => $category]);
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
            'creator_id' => $this->creator_id,
            'category' => $this->category,
            'project_type' => $this->project_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'url', $this->url])
            ->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'file', $this->file])
            ->andFilterWhere(['ilike', 'link', $this->link])
            ->andFilterWhere(['ilike', 'video', $this->video])
            ->andFilterWhere(['ilike', 'image', $this->image])
            ->andFilterWhere(['ilike', 'text', $this->text]);

        return $dataProvider;
    }
}
