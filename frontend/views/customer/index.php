<?php
/* @var $this yii\web\View */
/* @var $degrees array */
$this->title = "Mijozlar | Asaxiy.uz";
?>
<div class="page-content">
    <!--service start-->
    <section class="light-bg position-relative overflow-hidden">
        <div class="pattern-3">
            <img class="img-fluid rotateme" src="/images/pattern/03.png" alt="">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 mx-auto">
                    <div class="section-title text-center">
                        <h2 class="title">Mijozlar darajasi</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($degrees as $degree) { ?>
                    <div class="col-lg-6 col-md-6 mt-5">
                        <div class="featured-item style-3">
                            <div class="featured-icon">
                                <img class="img-fluid" width="115" src="<?= $degree['big_icon'] ?>" alt="">
                            </div>
                            <div class="featured-title">
                                <h5 style="color: <?= $degree['degree_color'] ?>"><?= $degree['degree_name'] ?></h5>
                            </div>
                            <div class="featured-desc">
                                <?php foreach ($degree['requirements'] as $requirement) { ?>
                                    <p><?= $requirement['label'] ?> - <?= $requirement['required'] ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!--service end-->
</div>