<?php

use common\helpers\Utilities;
use common\models\constants\OrderStatus;
use common\models\constants\UserRole;
use common\models\Order;
use common\widgets\PageSize;
use dosamigos\datepicker\DateRangePicker;
use kartik\select2\Select2;
use common\models\Order as OrderModel;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $sum double */
$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
    .profil-info_tr {
        display: flex;
        flex-direction: column;
        align-items: start;
        width: 255px;

        & td:nth-child(1) {
            font-family: Inter;
            font-size: 16px;
            font-weight: 400;
            text-align: left;
            padding: 0;
        }

        & td:nth-child(2) {
            font-family: Inter;
            font-size: 20px;
            font-weight: 600;
            text-align: left;
            padding: 0;

        }

    }

    .full-name-user {
        font-family: Inter;
        font-size: 28px;
        font-weight: 600;
        line-height: 24px;
        letter-spacing: 0px;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 15px;

    }
    .delete_card{
        position: fixed;
        top: 0px;
        width: 100vw;
        right: 0;
        height: 100vh;
        backdrop-filter: blur(5px);
        z-index: 999;
        display: flex;
        justify-content: center;
        align-items: center;
        display: none;
    }
    .delete_card_box{
        width: 350px;
        text-align: center;
        background-color: white;
        padding: 40px;
        border-radius: 12px;
    }
    .close_delete{
        background: #008DFF !important;
    }
    .delete-btn{
        background: #F61212 !important;
    }
</style>
<div class="content with-padding padding-bottom-0 mb-50">
    <div class="tabs">
        <div class="headline">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h2 class="full-name-user flex-wrap"><img src="/images/icon/profil.svg"> Profil ma'lumotlar</h2>
                <div class="d-flex block__w mmt justify-content-end align-items-center flex-wrap">


                    <?php if (Yii::$app->user->identity->is_creator) {
                        echo Html::a(Yii::t('app', 'Foydalanuvchi nomidan kirish'), ['user/as', 'id' => $model->id], ['class' => 'd-inline mr-5 button ripple-effect text-white', 'style' => 'background-color: #008DFF']);
                    } ?>

                    <?= Html::a(
                        '<img src="/images/icon/mode.svg" alt="Update" class="mr-5"> '.
                            Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'd-inline mr-5 button ripple-effect text-white', 'style' => 'background-color: #008DFF']) ?>
                            <button class="d-inline button ripple-effect red delete_box" style="background: #E833331A; color: red"> <img src="/images/icon/Delete.svg" alt="Update" class="mr-5"> O'chirish</button>
                </div>
            </div>
        </div>
        <div class="col-12" >
            <div class="row card__box">
                <div class="col-md-3 d-flex justify-content-center align-items-center flex-column" style="border-right: 1px solid silver">
                    <a href="<?= Yii::getAlias('@assets_url/user/') . $model->image ?>" data-fancybox="images"
                       data-caption="<?= $model->full_name ?>">
                        <?= Html::img(Yii::getAlias('@assets_url/user/') . $model->image , ['style' => 'border-radius:50%'])

                        ?>
                    </a>
                    <h2 class="full-name-user mt-30"> <?= Html::encode($this->title) ?></h2>
                    <p class="h4 mt-10 d-block"><?= Yii::$app->user->identity->roleName  ?></p>
                </div>
                <div class="col-md-8 mt-30 mt-md-0 pl-30">
                    <div>
                        <table class="table w-100">
                            <tbody class="d-flex justify-content-start align-items-center flex-wrap" style="gap: 70px">
                            <tr class="profil-info_tr">
                                <td scope="row"
                                    class="border-0"><?= $model->getAttributeLabel('company_id') ?></td>
                                <td class="border-0"><?= $model->company->name ?></td>
                            </tr>
                            <tr class="profil-info_tr">
                                <td scope="row"
                                    class="border-0"><?= $model->getAttributeLabel('market_id') ?></td>
                                <td class="border-0"><?= $model->branch->name ?></td>
                            </tr>
                            <tr class="profil-info_tr">
                                <td scope="row" class="border-0"><?= Yii::t('app', 'Full name') ?></td>
                                <td class="border-0 py-0">
                                    <?= $model->full_name ?>
                                </td>
                            </tr>
                            <tr class="profil-info_tr">
                                <td scope="row" class="border-0"><?= Yii::t('app', 'Phone') ?></td>
                                <td class="border-0 py-0">
                                    <?= $model->phone ?>
                                </td>
                            </tr>
                            <tr class="d-none profil-info_tr">
                                <td scope="row" class="border-0">Пол</td>
                                <td class="border-0 py-0">
                                    мужс.
                                </td>
                            </tr>
                            <tr class="profil-info_tr">
                                <td scope="row" class="border-0"><?= Yii::t('app', 'Leasings') ?></td>
                                <td class="border-0 py-0"> <?= $model->total_orders ?> </td>
                            </tr>
                            <tr class="profil-info_tr">
                                <td scope="row" class="border-0"><?= Yii::t('app', 'Products') ?></td>
                                <td class="border-0 py-0"><?= $model->total_actions ?></td>
                            </tr>
                            <tr class="profil-info_tr">
                                <td scope="row" class="border-0"><?= Yii::t('app', 'Logs') ?></td>
                                <td class="border-0 py-0"><?= $model->total_changes ?></td>
                            </tr>
                            <tr class="profil-info_tr">
                                <td scope="row" class="border-0"><?= $model->getAttributeLabel('created_at') ?></td>
                                <td class="border-0 py-0"><?= \common\helpers\Utilities::toStringDate($model->created_at) ?></td>
                            </tr>
                            <tr class="profil-info_tr">
                                <td scope="row" class="border-0"><?= $model->getAttributeLabel('updated_at') ?></td>
                                <td class="border-0 py-0"><?= \common\helpers\Utilities::toStringDate($model->updated_at) ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="delete_card">
    <div class="delete_card_box">
        <p style="font-size: 16px ; font-weight: bold; font-font: Inner;">Siz rostdan ham profilni o'chirmoqchimisiz ?</p>
        <div class="delete-buttons d-flex justify-content-between align-items-center">
            <button class=" btn-primary-custom button  close_delete">Отмена</button>
            <?php if (Yii::$app->user->identity->role >= UserRole::ROLE_ADMIN) { ?>
            <?php if (Yii::$app->user->identity->role == UserRole::ROLE_SUPER_ADMIN && $model->id !== 1) { ?>
            <?= Html::a(
                Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'button delete-btn ',
                'data' => [
                    'method' => 'post',
                ],
            ]);
            } ?>
            <?php }
            else { ?>
            <?= Html::a(Yii::t('app', 'Change Avatar'), ['photo', 'id' => $model->id], ['class' => 'd-inline ml-5 button ripple-effect']) ?>
            <?php } ?>
        </div>
    </div>
    <script>
        let deleteBox = document.querySelector(".delete_box")
        let delteCard = document.querySelector(".delete_card")
        deleteBox.addEventListener('click' ,()=>{
            delteCard.style.display='flex'
        })
        let closedelete = document.querySelector(".close_delete")
        closedelete.addEventListener('click', ()=>{
            delteCard.style.display='none'
        })

    </script>