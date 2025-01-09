<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="page-content">
    <section class="fullscreen-banner p-0 overflow-hidden text-center white-overlay error-page"
             data-bg-img="assets/images/bg/06.jpg" data-overlay="9">
        <div class="align-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center text-black">
                        <h1>4<span><i>0</i></span>4</h1>
                        <h5 class="mb-4 text-capitalize mt-3">
                            Yuqoridagi xato web-server sizning so'rovingizni ko'rib chiqayotganda yuz berdi.
                            <br>
                          Agar bu server xatosi deb o'ylasangiz, iltimos biz bilan bog'laning. Rahmat.
                        </h5>
                        <a class="btn btn-theme btn-radius btn-iconic" href="/"><i
                                    class="fas fa-long-arrow-alt-left"></i> <span>Back to Home</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="row d-none">
    <div class="col-md-12">
        <div class="order-confirmation-page pt-50 pb-50">
            <h2 class="mb-20"><?= Html::encode($this->title) ?></h2>
            <div class="d-flex justify-content-center mb-20">
                <div class="notification error">
                    <h3 class="text-danger"><?= nl2br(Html::encode($message)) ?></h3>
                </div>
            </div>
            <p>
                Yuqoridagi xato web-server sizning so'rovingizni ko'rib chiqayotganda yuz berdi.
            </p>
            <p class="mb-20">
                Agar bu server xatosi deb o'ylasangiz, iltimos biz bilan bog'laning. Rahmat.
            </p>
            <h2 class="mb-20"><a href="https://t.me/Husayn_Hasanov">Texnik yordam</a></h2>
            <p class="no-print" style="text-align:center">Sahifa yaqin orada yopiladi<br/>Qolgan vaqt: <span
                        id="counter">3</span> sekund.</p>
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