<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="row">
    <div class="col-md-12 order-confirmation-background">
        <div class="order-confirmation-page pt-50 kpb-50">
            <div class="error-background">
                <p class="type__error m-0">
                    <?= nl2br(Html::encode($message)) ?>
                </p>
            </div>
            <p>Yuqoridagi xato web-server sizning so'rovingizni ko'rib chiqayotganda yuz berdi.</p>
            <p class="mb-20">Agar bu server xatosi deb o'ylasangiz, iltimos biz bilan bog'laning. Rahmat.</p>
            <h2 class="mb-20"><a href="https://t.me/Husayn_Hasanov">Texnik yordam</a></h2>
            <p class="no-print" style="text-align:center">Sahifa yaqin orada yopiladi<br/>Qolgan vaqt: <span
                        id="counter">5</span> sekund.</p>
        </div>

    </div>
</div>

<script type="text/javascript">

    function countdown() {

        var i = document.getElementById('counter');
        i.innerHTML = parseInt(i.innerHTML) - 1;
        if (parseInt(i.innerHTML) < 1) {
            window.location.href = "<?=Yii::$app->request->referrer ?: "/site/index"?>";
        }

    }

    setInterval(function () {
        countdown();
    }, 1000);

</script>