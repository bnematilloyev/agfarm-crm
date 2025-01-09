<?php

use dmstr\widgets\Alert;

/** @var string $content */
?>
<!-- Dashboard Content
================================================== -->
<div class="dashboard-content-container" data-simplebar>
    <div class="dashboard-content-inner pt-50 overflow-backend-box">
        <?php if (isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []) : ?>
            <div class="dashboard-headline mb-5">
                <?= $this->render(
                    'breadcrumb.php'
                ) ?>
            </div>
        <?php endif; ?>
        <?php if (isset($this->blocks['content-header'])) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-box mt-0">
                        <h1><?= $this->blocks['content-header'] ?></h1>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-box mt-0">
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
                <div class="dashboard-box mt-0">
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </div>
        </div>

        <div class="dashboard-footer-spacer" style="padding-top: 125px;"></div>
        <div class="small-footer mt-15 d-flex justify-content-between" style="flex-wrap: wrap" align="center">
            <div class="small-footer-copyrights">
                Copyright &copy; 2025 <strong><a href="#">CEO</a></strong>
            </div>
            <div class="footer-social-links" align="center">
                <b>Created by </b> <a href="#" target="_blank">Botir Nematilloyev</a>
            </div>
            <div class="footer-social-links" align="center">
                <b>Server time </b> <a href="#"><?= date('d.m.Y H:i:s') ?></a>
            </div>
        </div>
    </div>
</div>
