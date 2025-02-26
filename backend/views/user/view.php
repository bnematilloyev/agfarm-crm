<?php

use common\helpers\Utilities;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $sum double */
$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$admin = Yii::$app->user->identity;
?>
<div class="content with-padding padding-bottom-0 ">
    <div class="d-flex align-items-center mb-20">
        <button onclick="customNavigate(-1)" class="go_back"><img src="/images/icons/go_back.svg"></button>
        <h2 style="margin-left: 15px;"><?= Yii::t('app', 'Profil') ?></h2>
    </div>
    <div class="tabs" style="padding: 20px; border-radius: 8px">
        <div class="headline">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center">
                    <img src="/images/icons/profil-avatar.svg">
                    <h2 style="margin-left: 15px;"><?= Yii::t('app', 'Profil malumotlari') ?></h2>
                </div>
                <div class="d-flex block__w mmt justify-content-end align-items-center user-view_buttons flex-wrap">


                    <?php if ($admin->is_admin) {
                        echo Html::a(Yii::t('app', 'Set Strong Password'), ['user/generate-new-password', 'id' => $model->id], [
                            'class' => 'd-inline yellow button  mr-5 mt-5',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want update new password ?'),
                                'method' => 'post',
                            ],
                        ]);
                        echo Html::a(Yii::t('app', 'Foydalanuvchi nomidan kirish'), ['user/as', 'id' => $model->id], ['class' => 'd-inline mr-5 button ripple-effect blue mt-5']);
                    } ?>

                    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'd-inline mr-5 button ripple-effect blue mt-5']) ?>
                    <?php if ($admin->is_creator) { ?>
                        <?php if ($model->id > 1) { ?>
                            <?= Html::a(Yii::t('app', Yii::t('app', $model->isActive ? 'Off' : 'On')), ['switch-status', 'id' => $model->id], [
                                'class' => 'd-inline button ripple-effect warning blue ',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to change the status?'),
                                    'method' => 'post',
                                ],
                            ]); ?>
                            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                                'class' => 'd-inline button ripple-effect red',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]);
                        } ?>
                    <?php } ?>
                    <?= Html::a(Yii::t('app', 'Change Avatar'), ['photo', 'id' => $model->id], ['class' => 'd-inline ml-5 button ripple-effect blue mt-5']) ?>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row card__box" style="box-shadow: none">
                <div class="col-12 col-xl-3 profil-name-img">
                    <a href="<?= Yii::getAlias('@assets_url/user') . $model->image ?>" data-fancybox="images"
                       data-caption="<?= $model->full_name ?>">
                        <?= Html::img(Yii::getAlias('@assets_url/user') . $model->image) ?>
                        <h2><?= Html::encode($this->title) ?></h2>
                        <h3><?= $model->roleName ?> <?= isset($model->department) ? "(" . $model->department->name . ")" : "" ?></h3>
                    </a>
                </div>
                <div class="col-12 col-xl-9 mt-15 mt-xl-0">
                    <div>
                        <table class="table w-100">
                            <tbody class="profil-info-body">
                                <tr class="profil-info-tr">
                                    <td scope="row"
                                        class="border-0"><?= $model->getAttributeLabel('company_id') ?></td>
                                    <td class="border-0"><?= $model->company->name ?></td>
                                </tr>
                                <tr class="profil-info-tr">
                                    <td scope="row"
                                        class="border-0"><?= $model->getAttributeLabel('market_id') ?></td>
                                    <td class="border-0"><?= $model->market->name ?></td>
                                </tr>
                                <tr class="profil-info-tr">
                                    <td scope="row" class="border-0"><?= Yii::t('app', 'Full name') ?></td>
                                    <td class="border-0 py-0">
                                        <?= $model->full_name ?>
                                    </td>
                                </tr>
                                <tr class="profil-info-tr">
                                    <td scope="row" class="border-0"><?= Yii::t('app', 'Phone') ?></td>
                                    <td class="border-0 py-0">
                                        <?= Html::a($model->phone, ['/customer/view-by-phone', 'phone' => $model->phone],['style'=>'font-family: Inter;font-size: 20px;font-weight: 600;color: #333;']) ?>
                                    </td>
                                </tr>
                                <tr class="profil-info-tr">
                                    <td scope="row" class="border-0"><?= $model->getAttributeLabel('created_at') ?></td>
                                    <td class="border-0 py-0"><?= Utilities::toStringDate($model->created_at) ?></td>
                                </tr>
                                <tr class="profil-info-tr">
                                    <td scope="row" class="border-0"><?= $model->getAttributeLabel('updated_at') ?></td>
                                    <td class="border-0 py-0"><?= Utilities::toStringDate($model->updated_at) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>