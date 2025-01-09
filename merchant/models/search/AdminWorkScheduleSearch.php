<?php

namespace merchant\models\search;

use common\models\UserActivityDuration;
use DateInterval;
use DatePeriod;
use DateTime;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AdminWorkSchedule;
use yii\db\Expression;

/**
 * AdminWorkScheduleSearch represents the model behind the search form of `common\models\AdminWorkSchedule`.
 */
class AdminWorkScheduleSearch extends AdminWorkSchedule
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'admin_id', 'start', 'finish'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
        $query = AdminWorkSchedule::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'admin_id' => $this->admin_id,
            'start' => $this->start,
            'finish' => $this->finish,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'weekday' => $this->weekday,
        ]);

        return $dataProvider;
    }

    /**
     * @throws \Exception
     */
    public function getUserActivities($beginTime, $endTime)
    {
        $weekdays = self::find()->select('weekday')->where(['admin_id' => $this->admin_id])->orderBy('weekday')->column();
        $startDate = new DateTime(date('Y-m-d', $beginTime));
        $endDate = new DateTime(date('Y-m-d', $endTime));
        $interval = new DateInterval('P1D');
        $dateRange = new DatePeriod($startDate, $interval, $endDate->add($interval));
        $result = [];
        foreach ($dateRange as $date) {
            $day = $date->format('Y-m-d');
            $weekday = $date->format('N');
            $result[] = [
                'title' => in_array($weekday, $weekdays) ? Yii::t('app','work time') : Yii::t('app','not worked'),
                'color' => 'black',
                'start' => $day
            ];
            $schedules = self::find()->where(['admin_id' => $this->admin_id, 'weekday' => $weekday])->one();
            if ($schedules instanceof AdminWorkSchedule)
                $result = array_merge($result, $this->getEventsBySchedule($this->admin_id, $schedules, $day));
        }
        return $result;
    }

    /**
     * @throws \Exception
     */
    private function getEventsBySchedule($userId, $schedule, $date)
    {
        $result = [];
        $explodedDate = explode('-', $date);
        $events = UserActivityDuration::getUserActivities($userId, (new DateTime(date('Y-m-d H:i:s', $schedule->start)))->setDate($explodedDate[0], $explodedDate[1], $explodedDate[2])->getTimestamp(), (new DateTime(date('Y-m-d H:i:s', $schedule->finish)))->setDate($explodedDate[0], $explodedDate[1], $explodedDate[2])->getTimestamp());
        foreach ($events as $event) {
            $result[] = [
                'title' => date('H:i:s', $event['start_date']) . ' - ' . date('H:i:s', $event['end_date']),
                'start' => $date,
                'color' => $event['status'] ? 'green' : 'red'
            ];
        }
        return $result;
    }
}
