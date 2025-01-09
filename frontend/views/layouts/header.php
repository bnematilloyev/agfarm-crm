<?php

use common\helpers\Utilities;
use common\models\constants\ProjectType;
use common\models\ProjectName;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$langs = [
    'uz' => 'O`zbekcha',
//    'tr' => 'Türk',
    'ru' => 'Русский',
    'en' => 'English'
];

?>
<!--header start-->
<header id="site-header" class="header">
    <div id="header-wrap">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav class="navbar navbar-expand-lg justify-content-between">
                        <a class="navbar-brand logo" href="/">
                            <img id="logo-img" class="img-fluid" height="40" src="/images/asaxiy-logo.svg" alt="">
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarNav"
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <a class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <ul class="navbar-nav position-relative">
                                <li class="nav-item">
                                    <a class="nav-link <?= Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index' ? 'active' : '' ?>"
                                       href="/"><?= Yii::t('app', 'Bosh sahifa') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?= Yii::$app->controller->id == 'customer' && Yii::$app->controller->action->id !== 'cashback'  ? 'active' : '' ?>"
                                       href="/customer"><?= Yii::t('app', 'Mijozlar') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?= Yii::$app->controller->action->id == 'cashback' ? 'active' : '' ?>"
                                       href="/cashback"><?= Yii::t('app', 'Keshbek tizimi') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?= Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'contact' ? 'active' : '' ?>"
                                       href="/contact"><?= Yii::t('app', 'Xamkorlik qilish') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="google_translate_element"></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!--header end-->