<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="row ">
    <div class="col-md-12 order-confirmation-background">
        <div class="order-confirmation-page pt-50 kpb-50 error-confirmation-page">
            <div class="error-background">
                <p class="type__error"><?= nl2br(Html::encode($message)) ?> </p>
            </div>
            <p>
                <?= Yii::t('app', "Yuqoridagi xato web-server sizning so'rovingizni ko'rib chiqayotganda yuz berdi.") ?>
            </p>
            <a href="/" class="error-button"><?= Yii::t('app', 'Bosh sahifa') ?></a>
        </div>

    </div>
</div>