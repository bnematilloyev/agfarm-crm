<?php
/* @var $this yii\web\View */
/** @var \common\models\ProjectName $project_name */
$this->title = $project_name->title_name;
$admin = Yii::$app->user->identity;

?>

<div class="row index-bg">

    <div class="col-md-12">
        <div class="order-confirmation-page pt-50 pb-50" style="max-width:1800px">
            <h2 class="mb-100"><?= $project_name->index_name ?></h2>
            <div class="breathing-icon">
                <a href="#">
                    <i class="icon-feather-check"></i>
                </a>
            </div>
        </div>
    </div>
</div>