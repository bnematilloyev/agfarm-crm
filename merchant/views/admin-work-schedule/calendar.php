<?php

use backend\assets\CalendarAsset;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $full_name string */
/* @var $events array */
/* @var $from_date int */
/* @var $end_date int */

CalendarAsset::register($this);
$this->title = Yii::t('app', 'Common Calendar');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="headline">
    <div class="d-flex justify-content-between align-items-center">
        <div class="col-12 col-md-6 col-xl-4">
            <label for="date_range"><?=Yii::t('app','Setting the Time Interval')?></label>
            <form action="">
                <?= DateRangePicker::widget([
                    'name' => 'date_range',
                    'value' => date('d.m.Y', $from_date) . '—' . date('d.m.Y', $end_date),
                    'convertFormat' => true,
                    'useWithAddon' => false,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'd.m.Y',
                            'separator' => '—',
                        ],
                        'opens' => 'left'
                    ],
                    'options' => [
                        'autocomplete' => 'off',
                        'class' => 'form-control update-data',
                        'id' => 'date_range'
                    ]
                ]) ?>
            </form>
        </div>
        <div>
            <?= Html::a(Yii::t('app', 'Create Schedule'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>
<div class="content with-padding padding-bottom-0" id='calendar'></div>

<?php
$events = json_encode($events, JSON_PRETTY_PRINT);
$currentUrl = Yii::$app->request->absoluteUrl;
$js = <<<JS

$('.update-data').on('change',function (e) {
    let date_range = $('#date_range').val();
    let currentUrl = new URL('$currentUrl');
    currentUrl.searchParams.set('date_range', date_range);
    window.location.href = currentUrl.toString();
})

var events=$events;
console.log(events)
var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
    events: events,
    eventOrder: function (a, b) {
        const isWorkTimeA = a.title.includes(': ');
        const isWorkTimeB = b.title.includes(': ');

        if (isWorkTimeA && !isWorkTimeB) {
            return -1;
        } else if (!isWorkTimeA && isWorkTimeB) {
            return 1;
        } else {
            return a.start - b.start;
        }
    }
});
calendar.render();

JS;
$this->registerJs($js);
?>
