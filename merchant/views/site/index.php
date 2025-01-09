<?php
/* @var $this yii\web\View */
/* @var $settings Setting[] */
/** @var \common\models\ProjectName $project_name */

$this->title = $project_name->title_name;

use common\models\Setting;
?>
<style>
    .box-bg{
        background-color: white;
        border-radius: 12px;

    }
</style>

<div class="row">
    <div class="col-md-12 box-bg">
        <div class="order-confirmation-page pt-50 pb-50">
            <h2 class="mb-100"><?= $project_name->index_name ?></h2>
            <div class="breathing-icon"><i class="icon-feather-check"></i></div>
            <p><?= Yii::t('app', "Tizimga muvaffaqiyatli kirdingiz.")?></p>
        </div>
    </div>
</div>