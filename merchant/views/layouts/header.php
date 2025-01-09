<?php

use common\helpers\Utilities;
use common\models\constants\ProjectType;
use common\models\ProjectName;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
$project_name = ProjectName::getMine(ProjectType::MERCHANT);
//$this->title = $project_name->title_name;

$langs = [
    'uz' => 'O`zbekcha',
    'tr' => 'Türk',
    'ru' => 'Русский',
    'en' => 'English'
];

?>
<header id="header-container" class="fullwidth dashboard-header not-sticky">

    <!-- Header -->
    <div id="header">
        <div class="container">
            <!--            Sides wrapper-->
            <div class="header__f d-flex align-items-center justify-content-between">
                <!-- Left Side Content -->
                <div class="left-side d-flex">
                    <div class="header-widget d-inline-flex">
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
                    <div id="logo">
                        <a href="/"> <img src="/images/logo/Logo.svg"></a>
                    </div>

                    <!-- Main Navigation -->
                    <nav id="navigation">
                        <ul>
                            <?php if (Yii::$app->controller->id != 'instruction') { ?>
                                <li class="manual">
                                    <a href="/instruction?url=<?= Yii::$app->request->url ?>"
                                       data-method="POST"><?= Yii::t('app', "Qo'llanma") ?> </a>
                                    <ul class="dropdown-nav">
                                        <?php foreach (\common\models\constants\InstructionCategory::getList() as $category => $name) { ?>
                                            <li>
                                                <a href="/instruction?url=<?= Yii::$app->request->url ?>&category=<?= $category ?>"><?= $name ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } else { ?>
                                <li>
                                    <a href="/instruction"
                                       data-method="POST"><?= Yii::t('app', "Umumiy qo'llanma") ?> </a>
                                </li>
                            <?php } ?>
                        </ul>
                      <div class="d-flex justify-content-between align-items-center">
                          <ul>
                              <li>
                                  <div class="modeswitch-wrap d-inline-flex align-items-center" id="darkModeSwitch">
                                      <div class="modeswitch-item d-flex align-items-center">
                                          <div class="modeswitch-icon d-flex align-items-center justify-content-center"></div>
                                      </div>
<!--                                      <span>Dark mode</span>-->
                                  </div>
                              </li>
                          </ul>
                          <ul id="responsive" class="language_ul">
                              <li><a href="#">
                                      <img src="/flags/<?= Yii::$app->language ?>.svg" class="mr-6"
                                           width="30"> <?= $langs[Yii::$app->language] ?></a>
                                  <ul class="dropdown-nav">
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
                <div class="right-side d-flex">
                    <div class="header-widget_left full-screen_header">
                        <div class="header-notifications h-100 d-flex align-items-center">
                            <div class="header-notifications-trigger">
                                <button type="button" id="fullscreen-button">
                                    <img src="/images/full-ekran.svg" alt="">
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- User Menu -->
                    <div class="header-widget">
                        <!-- Messages -->
                        <div class="header-notifications user-menu">
                            <div class="header-notifications-trigger h-100">
                                <a href="#" class="h-100 d-flex align-items-center">
                                    <div class="user-avatar status-online">
                                        <img
                                                src="<?= Yii::getAlias('@assets_url/user/') . Yii::$app->user->identity->image ?>"
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
                                                    src="<?= Yii::getAlias('@assets_url/user/') . Yii::$app->user->identity->image ?>"
                                                    alt="">

                                        </div>
                                        <div class="user-name">
                                            <?= Yii::$app->user->identity->full_name . ' - ' . Yii::$app->user->identity->roleName ?>
                                            <br>
                                            Ro`yxatdan o`tgan vaqt
                                            <span><?= date('d-m-Y H:i:s', Yii::$app->user->identity->created_at) ?></span>
                                        </div>
                                    </div>
                                </div>

                                <ul class="user-menu-small-nav">
                                          <a  class="  button d-flex align-items-center justify-content-center  mb-10" style="width: 100% ; background: #008DFF; gap: 10px;color: white" href="<?= Url::to(['user/view', 'id' => Yii::$app->user->identity->id]) ?>"><img src="/images/icon/user-circle.svg"> <?= Yii::t('app', 'Profil') ?></a>
                                    <li>
                                        <?= Html::a(
                                             Yii::t('app', 'Tizimdan chiqish') ,
                                            ['/site/logout'],
                                            ['data-method' => 'post', 'class' => 'button ripple-effect red text-center']
                                        ) ?>
                                    </li>
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