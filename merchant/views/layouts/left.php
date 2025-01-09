<?php

use yii\helpers\Url;

?>
<div class="dashboard-sidebar left-sidebar">
    <div class="dashboard-sidebar-inner" data-simplebar>
        <div class="dashboard-nav-container">
            <!-- Navigation -->
            <div class="dashboard-nav">
                <div class="dashboard-nav-inner">
                    <ul data-submenu-title="Menyu">
<!--                        <li>-->
<!--                            <a href="--><?php //= Url::to(['/site/dashboard-customer']) ?><!--">-->
<!--                                <img src="/images/icon/Category.svg" class="mr-10"  >-->
<!--                                <span>--><?php //= Yii::t('app', 'Maqomlar') ?><!--</span>-->
<!--                            </a>-->
<!--                        </li>-->

                        <li>
                            <a href="<?= Url::to(['/user-action']) ?>">
                                <i class="icon-line-awesome-users"></i>
                                <span><?= Yii::t('app', 'User Action') ?> </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['/admin-work-schedule']) ?>">
                                <i class="icon-line-awesome-users"></i>
                                <span><?= Yii::t('app', 'Admin Work Schedule') ?> </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
