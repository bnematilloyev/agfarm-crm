<?php

use common\widgets\PageSize;
use dosamigos\datepicker\DateRangePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="headline pb-0 pl-20">
    <h2><?= Html::encode($this->title) ?></h2>
</div>

<div class="content with-padding padding-bottom-0">

    <?php Pjax::begin(); ?>

    <?= PageSize::widget(); ?>
    <div class="custom__table changes-table-crm" style="overflow-x: auto;overflow-y: hidden;">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'filterSelector' => 'select[name="per-page"]',
            'pager' => array(
                'maxButtonCount' => 5,
                'firstPageLabel' => '<i class="icon-material-outline-keyboard-arrow-left"></i>',
                'lastPageLabel' => '<i class="icon-material-outline-keyboard-arrow-right"></i>'
            ),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'user_id',
                    'value' => function ($model) {
                        return $model->user->full_name;
                    },
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'user_id',
                        'data' => ArrayHelper::map(\common\models\User::findActive()->all(), 'id', 'full_name'),
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'options' => [
                            'placeholder' => Yii::t('app', 'Select ...'),
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])
                ],
                'text',
                [
                    'attribute' => 'created_at',
                    'value' => function ($model) {
                        return date('M d, Y H:i:s', $model->created_at);
                    },
                    'filter' => DateRangePicker::widget([
                        'model' => $searchModel,
                        'attributeTo' => 'to_date_range',
                        'attribute' => 'from_date_range',
                        'labelTo' => '-',
                        'value' => $searchModel->from_date_range,
                        'valueTo' => $searchModel->to_date_range,
                        'clientOptions' => [
                            'format' => 'dd-mm-yyyy',
                            'autoclose' => true
                        ]
                    ]),
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>

</div>
