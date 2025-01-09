<?php

use yii\helpers\Html;
use yii\bootstrap4\Modal;

/** @var \common\models\Market $branches */
/** @var \common\models\UserWorkTime $user_work_time */
/** @var \common\models\Event $event_provider */

$this->title = Yii::t('app', 'Dashboard');
$this->params['breadcrumbs'][] = $this->title;
$me = Yii::$app->user->identity;
?>
<div class="headline border-0 ">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h2><?= Html::encode($this->title) ?></h2>
        <div class="block__w mmt">
            <?= Html::a(Html::img('/images/workify-icons/add-user.svg', ['style' => 'height:24px; margin-right:8px;']) . Yii::t('app', 'Xodim qo\'shish'), ['/user/create'],
                ['class' => 'd-inline button ripple-effect green', 'style' => 'padding:7px 20px; background: linear-gradient(84.77deg, #04A396 -4.65%, #03D1C0 102.82%); border-radius:8px']) ?>

            <?= Html::a(Html::img('/images/workify-icons/add-user.svg', ['style' => 'height:24px; margin-right:8px;']) . Yii::t('app', 'Jadval qo\'shish'), ['/admin-work-schedule/create'],
                ['class' => 'd-inline button ripple-effect green', 'style' => 'padding:7px 20px; background: linear-gradient(84.77deg, #04A396 -4.65%, #03D1C0 102.82%); border-radius:8px']) ?>
        </div>
    </div>
</div>

<div class="content with-padding dashboard__workify-content">
    <div class="col-md-8 left-content-dashboard">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="workify__dashboard-title">
                <?= Yii::t('app', 'Davomat') ?>
                <img src="/images/workify-icons/right-arrow.svg" alt="" width="20">
            </h2>
            <div class="user-update-buttons">
                <button class=" user-statistic-button">
                    <img src="/images/workify-icons/grid-user.svg">
                </button>
                <button class=" user-one-line active">
                    <img src="/images/workify-icons/one-line-user-white.svg">
                </button>
            </div>
        </div>
        <div class="branch__buttons">
            <button class="all__branch active">
                <?= Yii::t('app', 'Barcha manzillar') ?>
            </button>
            <?php
            foreach ($branches as $branch) { ?>
                <button class="branch__button" data-branch-id = "<?=$branch['id']?>">
                    <?=$branch['name']?>
                </button>
            <?php } ?>
        </div>
        <div class="attendance_buttons">
            <button class="attendance_button active">
                <p class="attendance_button-number"> 128</p>
                <p class="attendance_button-text"> <?= Yii::t('app', 'Barchasi') ?></p>
            </button>
            <button class="attendance_button">
                <p class="attendance_button-number"> 12</p>
                <p class="attendance_button-text"> <?= Yii::t('app', 'Kech') ?></p>
            </button>
            <button class="attendance_button">
                <p class="attendance_button-number"> 128</p>
                <p class="attendance_button-text"> <?= Yii::t('app', 'O\'z vaqtida') ?></p>
            </button>
            <button class="attendance_button">
                <p class="attendance_button-number"> 128</p>
                <p class="attendance_button-text"> <?= Yii::t('app', 'Ishtirok etmagan') ?></p>
            </button>
            <button class="attendance_button">
                <p class="attendance_button-number"> 128</p>
                <p class="attendance_button-text"> <?= Yii::t('app', 'Dam olish kuni') ?></p>
            </button>
            <button class="attendance_button">
                <p class="attendance_button-number"> 128</p>
                <p class="attendance_button-text"> <?= Yii::t('app', 'Vaqt tuagdi') ?></p>
            </button>
        </div>
        <div class="table__user-box">
            <table class="user__statistics-one-line">
                <thead>
                <tr>
                    <th scope="col"><?= Yii::t('app', 'F.I.O') ?></th>
                    <th scope="col"><?= Yii::t('app', 'Kelish vaqti') ?></th>
                    <th scope="col"><?= Yii::t('app', 'Ketish vaqti') ?></th>
                    <th scope="col"><?= Yii::t('app', 'Status') ?></th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($user_work_time->getModels() as $action) { ?>
                    <tr>
                        <td class="user__avatar-td">
                            <?= Html::img(Yii::getAlias('@assets_url/user/') . $action->user->image) ?>
                            <div class="text">
                                <p><?=$action->user->full_name?></p>
                                <span><?=\common\models\constants\UserRole::getString($action->user->role)?></span>
                            </div>
                        </td>
                        <td class="arrival__time-td">
                            <p class="m-0"><?=date('H:i', $action->created_at)?></p>
                            <span>9:00</span>
                        </td>
                        <td class="leave__time-td">
                            <p><?=date('H:i', $action->finished_at)?></p>
                            <span>9:00</span>
                        </td>
                        <td>
                            <div class="status__user-arrival-time status__user-time-4"> o'zvaqtida</div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div class="user__statistics mt-3 row w-100 d-none">
                <?php for ($i = 0; $i <= 24; $i++) { ?>
                    <div class="col-6 col-md-4 col-xl-3 mt-10">
                        <div class="user__info-statistic-items"
                             style="background:url('https://th-i.thgim.com/public/incoming/xv54he/article68123998.ece/alternates/FREE_1200/IMG_IMA_RV_Asokan_2_1_NAC70H61.jpg')">
                            <p class="user__name-statistic"> kamol U.</p>
                            <?php if (1 > 0) { ?>
                                <img src="images/workify-icons/avatar-user.png" alt="">
                            <?php } ?>
                            <?php if (1 > 0) { ?>
                                <div class="time_statistic_user">
                                    <p class="m-0"> 8:50</p>
                                    <span>9:00</span>
                                </div>
                            <?php } else { ?>
                                <div class="status__user-arrival-time status__user-time-4 p-2"> o'zvaqtida</div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-4 mt-15 mt-md-0 padding__none-box">
        <div class="left-content-dashboard">
            <div class="d-flex justify-content-between align-items-center">
                <a class="workify__dashboard-title" href="site/recent-events">
                    <?= Yii::t('app', 'Oxirgi voqealar') ?>
                    <img src="/images/workify-icons/right-arrow.svg" alt="" width="20">
                </a>
                <a class="add__new-questionnaires-button"  data-url="/admin-work-schedule/questionary">
                    <img src="/images/workify-icons/questionnaires.svg">
                </a>
            </div>
            <?php foreach ($event_provider as $data) { ?>
                <div class="resent__events">
                    <div class="resent__event">
                        <div class="user__avatar-box">
                            <?= Html::img(Yii::getAlias('@assets_url/user/') . $data->creator->image) ?>
                            <div class="text">
                                <p><?=$data->creator->full_name?></p>
                                <span><?=\common\models\constants\UserRole::getString($data->creator->role)?></span>
                            </div>
                        </div>
                        <div class="resent__events-text">
                            <p><?=$data->source_type?></p>
                            <span><?=date('d M Y H:i',$data->created_at)?></span>
                        </div>
                    </div>
                    <div class="status__user-arrival-time status__user-time-<?=$data->type?> w-100 text-center "
                         style="padding: 4px !important;"><?=\common\models\Event::getString($data->type)?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
//Modal::begin([
//    'id' => 'add-files-modal',
//    'size' => 'modal-xl',
//    'title' => false,
//    'headerOptions' => ['style' => 'display:none'],
//]);
//echo "<div id='questionnairesModal'></div>";
//Modal::end();
//?>
<div id="questionModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body" id="questionnairesModal"></div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=Yii::t('app',"Close")?></button>
            </div>
        </div>
    </div>
</div>
<?php
$main_url = Yii::$app->params['dashboardUrl'];

$url = $main_url . '/dashboard-info';


$jwt_auth_key = \common\models\constants\AppConstants::BEARER_AUTH_HEADER_PREFIX;
$jwt_auth_key .= (!\Yii::$app->user->isGuest ? \Yii::$app->jwtService->generateAccessToken($me->id) : '');
$js = <<<JS
$.ajaxSetup({
  headers: {
    'Authorization': '$jwt_auth_key'
  }
});

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

$(document).ready(function() {
    $('.add__new-questionnaires-button').on("click", function() {
        console.log($(this).data('url'));
        $('#questionnairesModal').load($(this).data('url'));
        $('#questionModal').modal().show();
    });
});


JS;
$this->registerJs($js);
?>
