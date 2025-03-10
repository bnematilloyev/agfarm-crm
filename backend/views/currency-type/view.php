<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\CurrencyType $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Currency Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="currency-type-view">

    <div class="headline border-0">
        <div class="d-flex align-items-center flex-wrap">
            <button onclick="customNavigate(-1)" class="go_back mr-10"><img src="/images/icons/go_back.svg"></button>
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="d-flex flex-wrap block__w mmt mb-30">
        <?= Html::a(Html::img('/images/icons/mode.svg', ['alt' => 'mode', 'style' => 'margin-right:10px;height:17px']) . Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'd-inline mr-5 button ripple-effect text-white', 'style' => 'padding :8px 15px; background-color:#008DFF']) ?>
        <?php if (Yii::$app->user->identity->is_creator)
            echo Html::a(Html::img('/images/icons/Delete.svg', ['alt' => 'Delete', 'style' => 'margin-right:10px']) . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'd-inline mr-5 button ripple-effect red', 'style' => 'padding :8px 15px; background-color:#E83333',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
    </div>

    <div class="content with-padding padding-bottom-0 table-view-content">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'slug',
                'value',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>

</div>
