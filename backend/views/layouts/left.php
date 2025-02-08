<?php

use yii\helpers\Url;

$user = Yii::$app->user->identity;
?>

<!-- Dashboard Sidebar
================================================== -->
<div class="dashboard-sidebar left-sidebar">
    <div class="dashboard-sidebar-inner" data-simplebar>
        <div class="dashboard-nav-container">
            <!-- Navigation -->
            <div class="dashboard-nav">
                <div class="dashboard-nav-inner">
                    <ul>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="icon-material-outline-dashboard"></i>
                                <span><?= Yii::t('app', 'Company') ?></span>
                            </a>
                            <ul>
                                <li>
                                    <a href="<?= Url::to(['/company/view?id=' . $user->company_id]) ?>">
                                        <i class="icon-material-outline-account-balance"></i>
                                        <span><?= Yii::t('app', 'Company') ?> </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/market']) ?>">
                                        <i class="icon-feather-shopping-bag"></i>
                                        <span><?= Yii::t('app', 'Market') ?> </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/currency-type']) ?>">
                                        <i class="icon-line-awesome-dollar"></i>
                                        <span><?= Yii::t('app', 'Currency') ?> </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="icon-feather-box"></i>
                                <span><?= Yii::t('app', 'Product') ?> </span>
                            </a>
                            <ul>
                                <li>
                                    <a href="<?= Url::to(['/product-brand']) ?>">
                                        <i class="icon-feather-circle"></i>
                                        <span><?= Yii::t('app', 'Brand') ?> </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/product-category']) ?>">
                                        <i class="icon-material-outline-dashboard"></i>
                                        <span><?= Yii::t('app', 'Category') ?> </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/product']) ?>">
                                        <i class="icon-feather-box"></i>
                                        <span><?= Yii::t('app', 'Product') ?> </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="icon-feather-box"></i>
                                <span><?= Yii::t('app', 'Product Charasteristic') ?> </span>
                            </a>
                            <ul>
                                <li>
                                    <a href="<?= Url::to(['/product-option']) ?>">
                                        <i class="icon-feather-box"></i>
                                        <span><?= Yii::t('app', 'Product option') ?> </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/product-option-name']) ?>">
                                        <i class="icon-feather-box"></i>
                                        <span><?= Yii::t('app', 'Product option name') ?> </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/product-option-type']) ?>">
                                        <i class="icon-feather-box"></i>
                                        <span><?= Yii::t('app', 'Product option type') ?> </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="fas fa-mobile-alt"></i>
                                <span><?= Yii::t('app', 'Website setting') ?> </span>
                            </a>
                            <ul>
                                <li>
                                    <a href="<?=Url::to(['/website-settings/product-price'])?>">
                                        <i class="icon-line-awesome-dollar"></i>
                                        <span><?=Yii::t('app', 'Product price')?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?=Url::to(['/website-settings/product-priority'])?>">
                                        <i class="fas fa-chart-line"></i>
                                        <span><?=Yii::t('app', 'Product priority')?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?= Url::to(['/user']) ?>">
                                <i class="icon-line-awesome-users"></i>
                                <span><?= Yii::t('app', 'User') ?> </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Dashboard Sidebar / End -->
<?php
$js = <<<JS


document.querySelectorAll('.user-update-buttons button').forEach((button, index) => {
    button.addEventListener('click', function() {
        document.querySelectorAll('.user-update-buttons button').forEach(btn => {
            btn.classList.remove('active');
            let img = btn.querySelector('img');
            img.src = img.src.replace('-white', '');
        });
        this.classList.add('active');
        let activeImg = this.querySelector('img');
        if (!activeImg.src.includes('-white')) {
            activeImg.src = activeImg.src.replace('.svg', '-white.svg');
        }
        const table = document.querySelector('.user__statistics-one-line');
        const userStatistics = document.querySelector('.user__statistics');

        if (index === 1) { 
            table.classList.add('d-inline-table');
            table.classList.remove('d-none');
            userStatistics.classList.add('d-none');
            userStatistics.classList.remove('d-flex');
        } else { 
            table.classList.add('d-none');
            table.classList.remove('d-inline-table');
            userStatistics.classList.add('d-flex');
            userStatistics.classList.remove('d-none');
        }
    });
});

document.querySelectorAll('.branch__buttons button').forEach(button => {
    button.addEventListener('click', function() {
        document.querySelectorAll('.branch__buttons button').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
    });
});
document.querySelectorAll('.attendance_buttons button').forEach(button => {
    button.addEventListener('click', function() {
        document.querySelectorAll('.attendance_buttons button').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
    });
});



JS;
$this->registerJs($js);
?>

