<?php

use common\models\Company;
use common\models\constants\GeneralStatus;
use common\models\constants\UserRole;
use common\models\Market;
use common\models\TelegramChat;
use common\widgets\PageSize;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TelegramChatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Telegram Chats');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="headline border-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex align-items-center">
            <button onclick="customNavigate(-1)" class="go_back mr-10"><img src="/images/icons/go_back.svg"></button>
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="block__w mmt">
            <?= Html::a(Yii::t('app', 'Create Telegram Chat'), ['create'], ['class' => 'button ripple-effect green create-buttons']) ?>
        </div>
    </div>
</div>

<div class="content with-padding padding-bottom-0 main-index-tables">

    <?php Pjax::begin(); ?>
    <?= PageSize::widget(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterSelector' => 'select[name="per-page"]',
        'pager' => array(
            'firstPageLabel' => '<<<',
            'lastPageLabel' => '>>>'
        ),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            [
//                'attribute' => 'company_id',
//                'value' => function ($model) {
//                    /** @var \common\models\Market $model */
//                    return $model->company->name;
//                },
//                'filter' => Yii::$app->user->identity->role == UserRole::ROLE_SUPER_ADMIN ? Select2::widget([
//                    'model' => $searchModel,
//                    'attribute' => 'company_id',
//                    'data' => ArrayHelper::map(Company::findActive()->all(), 'id', 'name'),
//                    'theme' => Select2::THEME_BOOTSTRAP,
//                    'options' => [
//                        'placeholder' => Yii::t('app', 'Select ...'),
//                    ],
//                    'pluginOptions' => [
//                        'allowClear' => true
//                    ],
//                ]) : false
//            ],
//            'market_id',
//            [
//                'attribute' => 'market_id',
//                'value' => function ($model) {
//                    /** @var \common\models\Market $model */
//                    return $model->company->name;
//                },
//                'filter' => Yii::$app->user->identity->role == UserRole::ROLE_SUPER_ADMIN ? Select2::widget([
//                    'model' => $searchModel,
//                    'attribute' => 'market_id',
//                    'data' => ArrayHelper::map(Market::findActive()->all(), 'id', 'name'),
//                    'theme' => Select2::THEME_BOOTSTRAP,
//                    'options' => [
//                        'placeholder' => Yii::t('app', 'Select ...'),
//                    ],
//                    'pluginOptions' => [
//                        'allowClear' => true
//                    ],
//                ]) : false
//            ],
            'chat_id',
            'slug',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function (TelegramChat $model) {
                    return Html::a("<i class='icon-feather-message-square' style='color: white !important;'></i>", null, ['class' => 'd-inline mr-5 button ripple-effect ajax-action', 'data-url' => \yii\helpers\Url::to(['send-message', 'id' => $model->id])]);
                },
                'label' => Yii::t('app', 'Xabar')
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    /** @var \common\models\TelegramChat $model */
                    return $model->statusName;
                },
                'filter' => GeneralStatus::getList()
            ],
            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Yii::$app->user->identity->is_creator ? "{view} {update} {delete} " : (Yii::$app->user->identity->is_president ? "{view} {update}" : "{view}"),
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('yii', 'View'),
                            'class' => 'button_view',
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                            'class' => 'button_update',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('yii', 'Delete'),
                            'class' => 'button_delete',
                            'data' => [
                                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
                'contentOptions' => [
                    'class' => 'buttons_update-icon',
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php
Modal::begin([
    'options' => [
        'id' => 'ajax-action-id',
        'size' => 'modal-lg,',
        'tabindex' => false
    ]
]);
echo "<div id='ajax-action-content'></div>";
Modal::end();
?>

<?php
$js = <<<JS
    $('.ajax-action').on("click", function(){
        $('#ajax-action-content').load($(this).data('url'));
        $('#ajax-action-id').modal().show();
    });
JS;
$this->registerJs($js);
?>
