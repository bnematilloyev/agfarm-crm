<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<!--page title start-->

<section class="page-title overflow-hidden text-center light-bg bg-contain animatedBackground"
         data-bg-img="/images/pattern/05.png">
    <div class="page-title-pattern"><img class="img-fluid" src="/images/bg/06.png" alt=""></div>
</section>

<!--page title end-->


<!--body content start-->
<div class="page-content">
    <section class="position-relative">
        <div class="pattern-3">
            <img class="img-fluid rotateme" src="assets/images/pattern/03.png" alt="">
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="section-title text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="200" class="mb-5" viewBox="0 0 50 50"
                             style="enable-background:new 0 0 50 50" xml:space="preserve"><circle style="fill:#25ae88"
                                                                                                  cx="25" cy="25"
                                                                                                  r="25"/>
                            <path style="fill:none;stroke:#fff;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10"
                                  d="M38 15 22 33l-10-8"/></svg>
                        <h2 class="title">
                            Қизиқишингиз учун раҳмат!
                            <br>
                            Сизнинг аризангиз муваффақиятли қабул қилинди, бизнинг ходимларимиздан хабарни кутинг
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!--body content end-->

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