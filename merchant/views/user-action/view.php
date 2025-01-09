<?php

use common\models\UserAction;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\UserAction $model */

$this->title = $model->user->full_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Workifies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
    <div class="headline border-0">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="d-flex align-items-center">
                <button onclick="customNavigate(-1)" class="go_back mr-10"><img src="/images/icons/go_back.svg">
                </button>
                <h2><?= Html::encode($this->title) ?></h2>
            </div>
            <div class="block__w mmt buttons_veiw">
                <?php if (Yii::$app->user->identity->is_creator) { ?>
                    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="content with-padding padding-bottom-0 product_view_tabs-1">
        <div class="row">
            <div class="col-md-3 d-flex justify-content-center align-items-center flex-column" style="gap: 30px">
                <a href="<?= $model->photo ?>" data-fancybox="images"
                   data-caption="<?= $model->user->full_name ?>">
                    <?= Html::img($model->photo) ?>
                </a>
                <h3><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="col-md-9 product_info-table">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            'attribute' => 'user_id',
                            'value' => function ($model) {
                                /** @var UserAction $model */
                                return $model->user->full_name;
                            },
                        ],
                        'lat',
                        'long',
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]) ?>
            </div>
        </div>
    </div>

    <div id="customer-map" style="height: 500px;"></div>

    <script src="https://api-maps.yandex.ru/2.1/?apikey=3cf9dc24-cdc9-40e7-8a05-50694330af58&lang=ru_RU"
            type="text/javascript"></script>
<?php
$lat = $model->lat;
$long = $model->long;
$js = <<<JS
    ymaps.ready(init);
    let lat = '$lat';
    let long = '$long';

    function init() {
        let mapOptions = {
            center: [41.292824, 69.222882], 
            zoom: 8
        };

        let map = new ymaps.Map('customer-map', mapOptions);
        let marker = new ymaps.Placemark(
                [parseFloat(lat), parseFloat(long)],
                {  
                    preset: 'islands#blueDotIcon'
                }
            );
            map.geoObjects.add(marker);
        }
JS;
$this->registerJs($js);
