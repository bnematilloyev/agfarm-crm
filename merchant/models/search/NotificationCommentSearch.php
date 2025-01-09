<?php

namespace merchant\models\search;

use common\models\constants\NCStatus;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\NotificationComment;

/**
 * NotificationCommentSearch represents the model behind the search form of `common\models\NotificationComment`.
 */
class NotificationCommentSearch extends NotificationComment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'order_id', 'comment_id', 'user_id', 'days', 'status', 'expires_at', 'created_at', 'updated_at'], 'integer'],
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
    public function search($params, $type = null)
    {
        $query = NotificationComment::findActive()->andWhere(['status' => NCStatus::STATUS_WAITING]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['expires_at' => SORT_ASC]],
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        if ($type != null) {
            $today = strtotime(date('d.m.Y'));
            if ($type == "delays")
                $query->andWhere(['<', 'expires_at', $today]);
            if ($type == "upcomings")
                $query->andWhere(['and', ['>=', 'expires_at', $today], ['<=', 'expires_at', $today + 86400]]);
            // add conditions that should always apply here
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => ['defaultOrder' => ['expires_at' => SORT_ASC]],
            ]);
        }

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
            'order_id' => $this->order_id,
            'comment_id' => $this->comment_id,
            'user_id' => $this->user_id,
            'days' => $this->days,
            'status' => $this->status,
            'expires_at' => $this->expires_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
