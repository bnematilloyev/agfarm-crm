<?php

use dmstr\widgets\Alert;

/** @var string $content */
?>
<!-- Dashboard Content
================================================== -->
<div class="dashboard-content-container" data-simplebar>
    <div class="dashboard-content-inner">
        <?php if (isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []) : ?>
            <div class="dashboard-headline">
                <?= $this->render(
                    'breadcrumb.php'
                ) ?>
            </div>
        <?php endif; ?>
        <?php if (isset($this->blocks['content-header'])) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-box mt-0" style="background-color: transparent !important; box-shadow: none !important;">
                        <h1><?= $this->blocks['content-header'] ?></h1>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-box mt-0"  style="background-color: transparent !important;  box-shadow: none !important;">
                        <h1>
                            <?php
                            if ($this->title !== null) {
//                    echo \yii\helpers\Html::encode($this->title);
                            } else {
                                echo \yii\helpers\Inflector::camel2words(
                                    \yii\helpers\Inflector::id2camel($this->context->module->id)
                                );
                                echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                            } ?>
                        </h1>
                    </div>
                </div>
            </div>
        <?php } ?>


        <div class="row">
            <div class="col-md-12">
                <div class="dashboard-box mt-0 customer_view_status">
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </div>
        </div>

        <div class="dashboard-footer-spacer"></div>
        <div class="small-footer mt-15 d-flex justify-content-between footer-color border-0"  align="center">
            <div class="small-footer-copyrights pl-30">
                Copyright &copy; 2021-<?= date('Y') ?> <strong><a href="https://ceo.asaxiy.uz/gafurov.html" class="copyright-user">Eldor G'ofurov </a></strong> is a founder
            </div>

            <div class="footer-social-links" align="center">
                <b>Created by </b> <a href="https://husayn.uz/" target="_blank" class="created-user">Husayn Hasanov</a>
            </div>
            <div class="footer-social-links d-none">
                <b>Version</b> 2.0 <a href="https://murad-developer.uz/" target="_blank">Murad edition</a>
            </div>
        </div>
    </div>
</div>
