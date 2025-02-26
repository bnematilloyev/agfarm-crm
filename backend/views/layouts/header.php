<?php

use common\models\constants\ProjectType;
use common\models\ProjectName;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
$project_name = ProjectName::getMine(ProjectType::CRM);
$this->title = $project_name->title_name;

$langs = [
    'uz' => 'O`zbekcha',
    'ru' => 'Русский',
    'en' => 'English'
];

?>
<header id="header-container" class="fullwidth dashboard-header not-sticky">

    <!-- Header -->
    <div id="header">
        <div class="container w-100">
            <!--            Sides wrapper-->
            <div class="header__f d-flex align-items-center justify-content-between">
                <!-- Left Side Content -->
                <div class="left-side d-flex">
                    <div class="header-widget d-inline-flex border-0 px-10 pl-md-30 pr-md-20">
                        <div class="header-notifications h-100 d-flex align-items-center">
                            <div class="header-notifications-trigger">
                                <button type="button"
                                        class="left-sidebar-btn">
                                    <i class="icon-feather-align-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Logo -->
                    <div id="logo" style="border-left: 1px solid silver">
                        <a href="/"> <img src="/images/grand_logo.png" alt="logo " width="100"></a>
                    </div>

                    <!-- Main Navigation -->
                    <nav id="navigation">
                        <div></div>
                        <div class="d-flex" style="gap: 10px">
                            <div id="responsive">
                                <div class="modeswitch-wrap d-inline-flex align-items-center" id="darkModeSwitch">
                                    <div class="modeswitch-item d-flex align-items-center">
                                        <div class="modeswitch-icon d-flex align-items-center justify-content-center"></div>
                                    </div>
                                    <!--                                <span>Dark mode</span>-->
                                </div>
                            </div>

                            <ul class="language_ul">
                                <li><a href="#" class="d-flex align-items-center">
                                        <img src="/flags/<?= Yii::$app->language ?>.svg" class="mr-6"
                                             width="30">
                                        <p class="m-0" id="responsive"><?= $langs[Yii::$app->language] ?></p></a>
                                    <ul class="dropdown-nav responsive__language-header">
                                        <?php foreach ($langs as $lang => $name) if (Yii::$app->language != $lang) { ?>
                                            <li>
                                                <a href="<?= Url::to(array_merge([''], $_GET, ['language' => $lang])) ?>">
                                                    <img src="/flags/<?= $lang ?>.svg" class="mr-6" width="30">
                                                    <?= $name ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <!-- Main Navigation / End -->

                </div>
                <!-- Left Side Content / End -->


                <!-- Right Side Content / End -->
                <div class="right-side d-flex align-items-center p-0 pr-md-50 " style="gap: 25px">
                    <div class="header-widget" id="responsive" style="height: 36px !important;">
                        <div class="header-notifications">
                            <div class="header-notifications-trigger">
                                <button type="button" id="fullscreen-button"
                                        class="d-flex justify-content-center align-items-center"
                                        style="height: 24px !important;">
                                    <img src="/images/icons/full-ekran.svg">
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php if (Yii::$app->user->identity->is_creator) { ?>
                        <div class="header-widget" style="height: 36px !important;">
                            <div class="header-notifications h-100 d-flex align-items-center">
                                <div class="header-notifications-trigger">
                                    <button type="button"
                                            class="right-sidebar-btn d-flex justify-content-center align-items-center"
                                            style="height: 20px !important;">
                                        <i class="icon-feather-align-left"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- User Menu -->
                    <div class="header-widget border-0">
                        <!-- Messages -->
                        <div class="header-notifications user-menu">
                            <div class="header-notifications-trigger h-100">
                                <a href="#" class="h-100 d-flex align-items-center">
                                    <div class="user-avatar status-online">
                                        <img
                                                src="<?= Yii::getAlias('@assets_url/user'. Yii::$app->user->identity->image) ?>"
                                                alt="<?= Yii::$app->user->identity->full_name ?>">
                                    </div>
                                    <div class="user-name"
                                         style="max-width: 140px;"><?= Yii::$app->user->identity->full_name ?></div>
                                </a>
                            </div>

                            <!-- Dropdown -->
                            <div class="header-notifications-dropdown">

                                <!-- User Status -->
                                <div class="user-status">
                                    <!-- User Name / Avatar -->
                                    <div class="user-details">
                                        <div class="user-avatar status-online">
                                            <img
                                                    src="<?= Yii::getAlias('@assets_url/user/no-photo.png') ?>"
                                                    alt="">
                                        </div>
                                        <div class="user-name">
                                            <?= Yii::$app->user->identity->full_name . ' - ' . Yii::$app->user->identity->roleName ?>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center" style="font-size: 12px ; gap: 7px">
                                        <span> <?= Yii::t('app', 'Ro`yxatdan o`tgan vaqt') ?>:</span>
                                        <span style="color: silver"><?= date('d-m-Y H:i:s', Yii::$app->user->identity->created_at) ?></span>
                                    </div>
                                </div>

                                <ul class="user-menu-small-nav backend_user-nav ">
                                    <li class="mb-5">
                                        <a class="dropdown-item"
                                           href="<?= Url::to(['user-activity/index', 'UserActivitySearch[user_id]' => Yii::$app->user->identity->id]) ?>">
                                            <img src="/images/icons/line_left.svg"><?= Yii::t('backend', 'Активность') ?>
                                        </a>
                                        <a href="<?= \yii\helpers\Url::to(['user/view', 'id' => Yii::$app->user->identity->id]) ?>">
                                            <img src="/images/icons/profil_icon.svg">
                                            <?= Yii::t('app', 'Profile') ?></a></li>
                                    <!--                                    --><?php //if (Yii::$app->user->identity->is_admin) { ?>
                                    <!--                                        <li class="mb-10">-->
                                    <!--                                            <a href="https://panel.abrand.uz/login-via-access/-->
                                    <?php //= Yii::$app->user->identity->auth_key ?><!--"><i-->
                                    <!--                                                    class="icon-material-outline-person-pin"></i>-->
                                    <!--                                                PANELga o'tish</a></li>-->
                                    <!--                                    --><?php //} ?>

                                    <li class="mb-5">
                                        <a href="<?= "/request-excel" ?>">
                                            <img src="/images/icons/Excel.svg">
                                            <?= Yii::t('app', 'Request Excels') ?></a></li>
                                    <li class="responsive_profil-items">

                                        <div class="modeswitch-wrap d-inline-flex align-items-center responsive_profil-items mt-10"
                                             id="darkModeSwitch">
                                            <div class="modeswitch-item d-flex align-items-center">
                                                <div
                                                        class="modeswitch-icon d-flex align-items-center justify-content-center"></div>
                                            </div>
                                            <span>Dark mode</span>
                                        </div>

                                    </li>
                                    <li>
                                        <hr style="margin-top: 0">
                                        <?= Html::a(
                                            '<img src="/images/default.svg" alt="Rasm" style="margin-right: 5px">' . 'Tizimdan chiqish',
                                            ['/site/logout'],
                                            ['data-method' => 'post', 'class' => 'ripple-effect ', 'style' => 'color:red']
                                        ) ?>
                                    </li>
                                    <!--                                <li><a href="index-logged-out.html"-->
                                    <!--                                    ><i-->
                                    <!--                                                class="icon-material-outline-power-settings-new"></i> Logout</a></li>-->
                                </ul>

                            </div>
                        </div>

                    </div>
                    <!-- User Menu / End -->

                    <!-- Mobile Navigation Button -->
                    <span class="mmenu-trigger">
                    <button class="hamburger hamburger--collapse" type="button">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </span>

                </div>
                <!-- Right Side Content / End -->
            </div>
        </div>
    </div>
    <!-- Header / End -->
</header>

<!--<script>-->
<!--    window.onload = () => {-->
<!--        --><?php //if (Yii::$app->user->identity->has_expired_courts && !Yii::$app->user->identity->is_creator) { ?>
<!--//        toastr.error('<a href="/court/index?CourtSearch[status]=3&sort=created_at" class="text-white">Sudga chiqarish muddatidan o`tgan xaridorlar bor</a>');-->
<!--//        --><?php ////} ?>
<!--        --><?php //if (Yii::$app->user->identity->has_new_courts && !Yii::$app->user->identity->is_creator) { ?>
<!--//        toastr.success('<a href="/court/index?CourtSearch[status]=2&sort=-created_at" class="text-white">Sudga chiqarish uchun yangi xaridorlar qo`shildi</a>');-->
<!--//        --><?php ////} ?>
<!--//    }-->
<!--//</script>-->